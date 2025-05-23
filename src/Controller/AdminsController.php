<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Mailer\Mailer;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;
use Cake\Database\Log\QueryLogger;
/**
 * @property \App\Model\Table\BorrowRequestsTable $BorrowRequests
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\InventoryItemsTable $InventoryItems
 */
class AdminsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        // ✅ Use fetchTable instead of loadModel in CakePHP 5+
        $this->BorrowRequests = $this->fetchTable('BorrowRequests');
        $this->Users = $this->fetchTable('Users');
        $this->InventoryItems = $this->fetchTable('InventoryItems');

        $this->loadComponent('Flash');
    }

    public function dashboard()
{
    $user = $this->request->getAttribute('identity');

    // Quick statistics
    $totalItems = $this->InventoryItems->find()->count();
    $pendingRequests = $this->BorrowRequests->find()->where(['status' => 'pending'])->count();
    $approvedRequests = $this->BorrowRequests->find()->where(['status' => 'approved'])->count();
    $returnedRequests = $this->BorrowRequests->find()->where(['status' => 'returned'])->count();
    $overdueRequests = $this->BorrowRequests->find()->where(['status' => 'overdue'])->count();

    // Upcoming returns within 3 days
    $upcomingReturns = $this->BorrowRequests->find()
    ->contain(['Users', 'InventoryItems'])
    ->where([
        'status' => 'approved',
        'return_date >=' => date('Y-m-d'),
        'return_date <=' => date('Y-m-d', strtotime('+3 days'))
    ])
    ->order(['return_date' => 'ASC'])
    ->limit(5)
    ->all(); // 👈 This makes it a result set so you can use isEmpty()


    $this->set(compact(
        'user',
        'totalItems',
        'pendingRequests',
        'approvedRequests',
        'returnedRequests',
        'overdueRequests',
        'upcomingReturns'
    ));
}


public function inventory()
{
    $this->InventoryItems = $this->fetchTable('InventoryItems');
    $this->BorrowRequests = $this->fetchTable('BorrowRequests');

    $query = $this->InventoryItems->find();

    $query = $query
        ->select([
            'InventoryItems.id',
            'InventoryItems.name',
            'InventoryItems.category',
            'InventoryItems.item_condition',
            'InventoryItems.quantity',
            'InventoryItems.procurement_date',
            'InventoryItems.description',
            'InventoryItems.location',
            'total_borrowed' => $query->func()->coalesce([
                $query->func()->sum(
                    $query->newExpr()->add(['CASE WHEN BorrowRequests.status = "approved" THEN BorrowRequests.quantity_requested ELSE 0 END'])
                ), 0
            ]),
            'total_damaged' => $query->func()->coalesce([
                $query->func()->sum(
                    $query->newExpr()->add(['CASE WHEN BorrowRequests.status = "returned" THEN BorrowRequests.returned_damaged ELSE 0 END'])
                ), 0
            ])
        ])
        ->leftJoinWith('BorrowRequests')
        ->group(['InventoryItems.id']);

    // Filtering
    $search = $this->request->getQuery('search');
    $category = $this->request->getQuery('category');
    $condition = $this->request->getQuery('condition');
    $location = $this->request->getQuery('location');

    if ($search) {
        $query->where(function ($exp, $q) use ($search) {
            return $exp->like('InventoryItems.name', '%' . $search . '%');
        });
    }

    if ($category) {
        $query->where(['InventoryItems.category' => $category]);
    }

    if ($condition) {
        $query->where(['InventoryItems.item_condition' => strtolower($condition)]);
    }

    if ($location) {
        $query->where(['InventoryItems.location' => $location]);
    }

    $inventoryItems = $this->paginate($query);
    $this->set(compact('inventoryItems', 'search', 'category', 'condition', 'location'));
}


    public function addInventory()
    {
        $item = $this->fetchTable('InventoryItems')->newEmptyEntity();

        if ($this->request->is('post')) {
            $item = $this->fetchTable('InventoryItems')->patchEntity($item, $this->request->getData());
            if ($this->fetchTable('InventoryItems')->save($item)) {
                $this->Flash->success('Item added.');
                return $this->redirect(['action' => 'inventory']);
            }
            $this->Flash->error('Could not add item.');
        }

        $this->set(compact('item'));
    }

    public function editInventory($id = null)
    {
        $item = $this->fetchTable('InventoryItems')->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $item = $this->fetchTable('InventoryItems')->patchEntity($item, $this->request->getData());
            if ($this->fetchTable('InventoryItems')->save($item)) {
                $this->Flash->success('Item updated.');
                return $this->redirect(['action' => 'inventory']);
            }
            $this->Flash->error('Could not update item.');
        }

        $this->set(compact('item'));
    }

    public function deleteInventory($id)
{
    $this->InventoryItems = $this->fetchTable('InventoryItems');
    $this->BorrowRequests = $this->fetchTable('BorrowRequests');

    $item = $this->InventoryItems->get($id);

    // Check if there are any linked borrow requests with pending or approved status
    $linkedRequests = $this->BorrowRequests
        ->find()
        ->where([
            'inventory_item_id' => $id,
            'status IN' => ['pending', 'approved']
        ])
        ->count();

    if ($linkedRequests > 0) {
        $this->Flash->error('Cannot delete item. It is currently borrowed or pending approval.');
    } else {
        if ($this->request->is(['post', 'delete'])) {
            if ($this->InventoryItems->delete($item)) {
                $this->Flash->success('Item deleted.');
            } else {
                $this->Flash->error('Item could not be deleted due to database rules.');
            }
        }
    }

    return $this->redirect(['action' => 'inventory']);
}
    public function borrowRequests()
    {
        $this->autoMarkOverdue();

        $requests = $this->BorrowRequests
            ->find('all')
            ->contain(['Users', 'InventoryItems'])
            ->where(['BorrowRequests.status' => 'pending']) // Only show pending borrow requests
            ->order(['BorrowRequests.created' => 'DESC']);

        $this->set('borrowRequests', $requests);
    }

    public function approveRequest($id = null)
{
    $this->autoMarkOverdue();

    $request = $this->BorrowRequests->get($id, ['contain' => ['Users', 'InventoryItems']]);

    if ($this->request->is(['post', 'put'])) {
        $request->status = 'approved';

        // ✅ Optional note from the approve_form
        $approvalNote = trim((string) $this->request->getData('approval_note'));
        if (strlen($approvalNote) > 75) {
            $this->Flash->error('Approval note must not exceed 75 characters.');
            return $this->redirect(['action' => 'approveRequest', $id]);
        }

        $request->approval_note = $approvalNote;

        // ✅ Deduct inventory
        $item = $request->inventory_item;
        $item->quantity -= $request->quantity_requested;
        $item->setDirty('quantity', true); // Required

        $saveRequest = $this->BorrowRequests->save($request);
        $saveItem = $this->fetchTable('InventoryItems')->save($item);

        if ($saveRequest && $saveItem) {
            $this->Flash->success('Request approved successfully and inventory updated.');

            // ✅ Send email
            if ($request->user && $item) {
                $user = $request->user;
                $mailer = new Mailer('default');

                $noteLine = $approvalNote ? "\n\nAdmin Note: {$approvalNote}" : '';

                $mailer->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
                    ->setTo($user->email)
                    ->setSubject('Borrow Request Approved')
                    ->deliver(
                        "Hello {$user->name},\n\n" .
                        "Your borrow request for \"{$item->name}\" has been approved.\n" .
                        "Please return the item by {$request->return_date} at {$request->return_time}." .
                        "{$noteLine}\n\nThank you,\nUAO Inventory Team"
                    );

                echo "<script>alert('📧 Email sent to {$user->email}');</script>";
            } else {
                echo "<script>alert('❌ Email not sent — missing user or item info.');</script>";
            }
        } else {
            $this->Flash->error('Could not approve request or update inventory.');
        }

        return $this->redirect(['action' => 'borrowRequests']);
    }

    // Initial GET request shows form
    $this->set(compact('request'));
    $this->render('approve_form');
}


public function rejectRequest($id = null)
{
    $request = $this->BorrowRequests->get($id, ['contain' => ['Users', 'InventoryItems']]);

    if ($this->request->is(['post', 'put'])) {
        $data = $this->request->getData();
        $rejectionReason = trim((string) $data['rejection_reason']);

        if (strlen($rejectionReason) > 75) {
            $this->Flash->error('Rejection reason must not exceed 75 characters.');
            return $this->redirect(['action' => 'rejectRequest', $id]);
        }

        $request->status = 'rejected';
        $request->rejection_reason = $rejectionReason;

        if ($this->BorrowRequests->save($request)) {
            $this->Flash->success('Request rejected with reason.');

            // ✅ Send rejection email
            if ($request->user && $request->inventory_item) {
                $user = $request->user;
                $item = $request->inventory_item;

                $mailer = new Mailer('default');
                $mailer->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
                    ->setTo($user->email)
                    ->setSubject('Borrow Request Rejected')
                    ->deliver(
                        "Hello {$user->name},\n\n" .
                        "Your borrow request for \"{$item->name}\" has been rejected.\n\n" .
                        "Reason: {$rejectionReason}\n\n" .
                        "Please contact the UAO office if you need further assistance.\n\n" .
                        "Thank you,\nUAO Inventory Team"
                    );

                echo "<script>alert('📧 Rejection email sent to {$user->email}');</script>";
            } else {
                echo "<script>alert('❌ Email not sent — missing user or item info.');</script>";
            }

        } else {
            $this->Flash->error('Could not reject the request.');
        }

        return $this->redirect(['action' => 'borrowRequests']);
    }

    return $this->redirect(['action' => 'borrowRequests']);
}



    public function rejectForm($id)
    {
        $request = $this->BorrowRequests->get($id, ['contain' => ['Users', 'InventoryItems']]);
        $this->set(compact('request'));
    }

    public function adminDashboard()
    {
        $this->autoMarkOverdue();

        $user = $this->request->getAttribute('identity'); // Get the logged-in user

        // Redirect to the login page if the user is not authenticated or not an admin
        if (!$user || $user->role !== 'admin') {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // Fetch borrow requests or any other data you need for the admin dashboard
        $borrowRequests = $this->BorrowRequests->find('all')
            ->contain(['Users', 'InventoryItems'])
            ->order(['created' => 'DESC']);

        $this->set(compact('borrowRequests'));
    }

    public function history()
{
    // Get search queries from GET
    $emailSearch = $this->request->getQuery('email');
    $nameSearch = $this->request->getQuery('name');

    // Build base query
    $query = $this->BorrowRequests->find()
        ->contain(['Users', 'InventoryItems'])
        ->where(['BorrowRequests.status IN' => ['approved', 'rejected', 'returned']])
        ->order(['BorrowRequests.created' => 'DESC']);

    // Apply filters
    if (!empty($emailSearch)) {
        $query->where(['Users.email LIKE' => '%' . $emailSearch . '%']);
    }

    if (!empty($nameSearch)) {
        $query->where(['Users.name LIKE' => '%' . $nameSearch . '%']);
    }

    // Paginate results
    $history = $this->paginate($query);

    // Set for view
    $this->set(compact('history'));
}

    public function approvedRequests()
{
    $user = $this->request->getAttribute('identity'); // Get the logged-in user

    // Redirect to the login page if the user is not authenticated or not an admin
    if (!$user || $user->role !== 'admin') {
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // Fetch the approved borrow requests and avoid ambiguity by specifying the table for 'created'
    $approvedRequests = $this->BorrowRequests
        ->find('all')
        ->contain(['Users', 'InventoryItems'])
        ->where(['BorrowRequests.status IN' => ['approved', 'overdue']]) // Filter approved requests
        ->order(['BorrowRequests.created' => 'DESC']);  // Specify the table for the 'created' column

    $this->set(compact('approvedRequests'));
}

public function markAsReturned($id = null)
{
    $user = $this->request->getAttribute('identity');

    if (!$user || $user->role !== 'admin') {
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    $request = $this->BorrowRequests->get($id);

    if ($this->request->is(['post', 'put'])) {
        // ✅ Setup Query Logger
        $logger = new \Cake\Database\Log\QueryLogger();
        $connection = ConnectionManager::get('default');
        $driver = $connection->getDriver();

        if (method_exists($driver, 'setLogger')) {
            $driver->setLogger($logger);
        }

        $data = $this->request->getData();
        $returnedGood = (int)$data['returned_quantity'];
        $returnedDamaged = (int)$data['damaged_quantity'];
        $totalReturned = $returnedGood + $returnedDamaged;

        if ($totalReturned > $request->quantity_requested) {
            $this->Flash->error('Total returned quantity exceeds what was borrowed.');
            return $this->redirect(['action' => 'markAsReturned', $id]);
        }

        $originalStatus = $request->status;

        // ✅ Calculate overdue duration
        $duration = null;
        if ($originalStatus === 'overdue' && $request->return_date && $request->return_time) {
            $due = new \DateTime($request->return_date->format('Y-m-d') . ' ' . $request->return_time->format('H:i:s'));
            $returnedAt = new \DateTime();

            if ($returnedAt > $due) {
                $interval = $due->diff($returnedAt);
                $duration = "{$interval->days} day(s), {$interval->h} hour(s), {$interval->i} min(s)";
                debug("Setting overdue duration: $duration");
                \Cake\Log\Log::write('debug', "⏱ overdue_duration set to: $duration");
            } else {
                debug("Not overdue anymore.");
                \Cake\Log\Log::write('debug', "Returned on time. No overdue_duration set.");
            }
        } else {
            \Cake\Log\Log::write('debug', "Not previously overdue or missing return date/time.");
        }

        // ✅ Patch entity
        $this->BorrowRequests->patchEntity($request, [
            
            'status' => 'returned',
            'returned_good' => $returnedGood,
            'returned_damaged' => $returnedDamaged,
            'return_remark' => "Returned: {$returnedGood} good" . ($returnedDamaged > 0 ? ", {$returnedDamaged} damaged" : ""),
            'quantity' => $totalReturned,
            'overdue_duration' => $duration
        ]);
        $request->setDirty('overdue_duration', true);
        // ✅ Inventory update
        $inventoryTable = $this->fetchTable('InventoryItems');
        $item = $inventoryTable->get($request->inventory_item_id);
        $item->quantity += $returnedGood;
        $item->setDirty('quantity', true);

        debug($request);
        debug('FINAL TO SAVE: ' . json_encode($request->toArray()));
        debug($request->getErrors());

        // ✅ Save the request
        if (!$this->BorrowRequests->save($request)) {
            $reflection = new \ReflectionClass($logger);
            if ($reflection->hasProperty('_queries')) {
                $prop = $reflection->getProperty('_queries');
                $prop->setAccessible(true);
                $queries = $prop->getValue($logger);
                debug("❌ SQL QUERY LOG:");
                debug(end($queries));
            }

            \Cake\Log\Log::write('error', '❌ Failed to save BorrowRequest: ' . json_encode($request->getErrors()));
            $this->Flash->error("Borrow request save failed: " . json_encode($request->getErrors()));
            return $this->redirect(['action' => 'approvedRequests']);
        }

        // ✅ Save the inventory item
        if (!$inventoryTable->save($item)) {
            $this->Flash->error("Inventory save failed: " . json_encode($item->getErrors()));
            return $this->redirect(['action' => 'approvedRequests']);
        }

        $this->Flash->success("Marked as returned. Inventory updated with {$returnedGood} good item(s).");
        return $this->redirect(['action' => 'approvedRequests']);
    }

    $this->set(compact('request'));
}




public function markAsOverdue($id = null)
{
    // Get the borrow request by ID
    $request = $this->BorrowRequests->get($id);

    // Only allow if the request is POST or PUT
    if ($this->request->is(['post', 'put'])) {
        // Mark as overdue
        $request->status = 'overdue';
        $request->return_remark = 'Marked overdue by admin';

        // Save and give feedback
        if ($this->BorrowRequests->save($request)) {
            $this->Flash->success('Request marked as overdue.');
        } else {
            $this->Flash->error('Could not mark as overdue.');
        }
    }

    // Redirect back to Approved Requests page
    return $this->redirect(['action' => 'approvedRequests']);
}

public function exportInventoryPdf()
{
    $inventoryItems = $this->InventoryItems->find()->all();
    $this->set(compact('inventoryItems'));

    $this->viewBuilder()->disableAutoLayout();
    $this->viewBuilder()->setTemplate('pdf_inventory');

    // ✅ Convert stream to string
    $html = (string) $this->render()->getBody();

    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $options->set('isRemoteEnabled', true); // ✅ enable remote loading

    $dompdf = new Dompdf($options);

    // ✅ Fix image path from local to full URL
    $baseUrl = Router::url('/', true);
    $html = str_replace(
        'src="' . WWW_ROOT . 'img/cruslogo.png"',
        'src="' . $baseUrl . 'img/cruslogo.png"',
        $html
    );

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $this->response
        ->withType('application/pdf')
        ->withHeader('Content-Disposition', 'attachment; filename="inventory_report.pdf"')
        ->withStringBody($dompdf->output());
}


public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);

    $user = $this->request->getAttribute('identity');

    // Block access if not admin
    if (!$user || $user->role !== 'admin') {
        $this->Flash->error('You are not authorized to access this page.');
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}

public function deleteHistory($id = null)
{
    $this->request->allowMethod(['post', 'delete']);

    $request = $this->BorrowRequests->get($id);

    if ($this->BorrowRequests->delete($request)) {
        $this->Flash->success('Borrow request history deleted.');
    } else {
        $this->Flash->error('Could not delete the borrow request.');
    }

    return $this->redirect(['action' => 'history']);
}
private function autoMarkOverdue(): void
{
    $now = new \DateTime();

    $requests = $this->BorrowRequests->find()
        ->contain(['Users', 'InventoryItems'])
        ->where(['status IN' => ['approved']])
        ->all();

    foreach ($requests as $request) {
        if (
            $request->status !== 'approved' || // ✅ Extra safety
            !$request->return_date || 
            !$request->return_time
        ) {
            continue;
        }

        $due = new \DateTime($request->return_date->format('Y-m-d') . ' ' . $request->return_time->format('H:i:s'));

        if ($now > $due && $request->status !== 'overdue') {
            $request->status = 'overdue';
            $request->return_remark = 'Automatically marked overdue by system';

            if ($this->BorrowRequests->save($request)) {
                if ($request->user && $request->inventory_item) {
                    $user = $request->user;
                    $item = $request->inventory_item;

                    (new Mailer('default'))
                        ->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
                        ->setTo($user->email)
                        ->setSubject('Borrow Request Overdue')
                        ->deliver(
                            "Hello {$user->name},\n\n" .
                            "Your borrow request for \"{$item->name}\" is now marked as OVERDUE.\n\n" .
                            "Return Due: {$request->return_date->format('Y-m-d')} at {$request->return_time->format('H:i')}\n\n" .
                            "Please return the item immediately to avoid any further issues.\n\n" .
                            "Thank you,\nUAO Inventory Team"
                        );
                }
            }
        }
    }
}

}
