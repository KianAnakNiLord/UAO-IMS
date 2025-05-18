<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Mailer\Mailer;
use Cake\Log\Log;
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

    // Base query
    $query = $this->InventoryItems->find();

    // Join and aggregate only approved borrow requests
    $query = $query
        ->select([
            'InventoryItems.id',
            'InventoryItems.name',
            'InventoryItems.category',
            'InventoryItems.item_condition',
            'InventoryItems.quantity',
            'InventoryItems.procurement_date',
            'InventoryItems.description',
            'total_borrowed' => $query->func()->coalesce([
                $query->func()->sum('BorrowRequests.quantity_requested'), 0
            ])
        ])
        ->leftJoinWith('BorrowRequests', function ($q) {
            return $q->where(['BorrowRequests.status' => 'approved']);
        })
        ->group(['InventoryItems.id']);

    // Filtering
    $search = $this->request->getQuery('search');
    $category = $this->request->getQuery('category');

    if ($search) {
        $query->where(function ($exp, $q) use ($search) {
            return $exp->like('InventoryItems.name', '%' . $search . '%');
        });
    }

    if ($category) {
        $query->where(['InventoryItems.category' => $category]);
    }

    $inventoryItems = $this->paginate($query);
    $this->set(compact('inventoryItems', 'search', 'category'));
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
    $request->status = 'approved';

    $item = $request->inventory_item;
    $item->quantity -= $request->quantity_requested;
    $item->setDirty('quantity', true); // ✅ REQUIRED!

    $saveRequest = $this->BorrowRequests->save($request);
    $saveItem = $this->fetchTable('InventoryItems')->save($item); // or just use $this->InventoryItems if already fetched

    if ($saveRequest && $saveItem) {
        $this->Flash->success('Request approved successfully and inventory updated.');

        // ✅ Send email
        if ($request->user && $item) {
            $user = $request->user;
            $mailer = new Mailer('default');

            $emailResult = $mailer->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
                ->setTo($user->email)
                ->setSubject('Borrow Request Approved')
                ->deliver(
                    "Hello {$user->name},\n\n" .
                    "Your borrow request for \"{$item->name}\" has been approved.\n\n" .
                    "Please return the item by {$request->return_date} at {$request->return_time}.\n\n" .
                    "Thank you,\nUAO Inventory Team"
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

public function rejectRequest($id = null)
{
    $request = $this->BorrowRequests->get($id, ['contain' => ['Users', 'InventoryItems']]);

    if ($this->request->is(['post', 'put'])) {
        $data = $this->request->getData();
        $request->status = 'rejected';
        $request->rejection_reason = $data['rejection_reason'];

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
                        "Reason: {$request->rejection_reason}\n\n" .
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
        $data = $this->request->getData();
        $returnedQty = (int)$data['returned_quantity'];

        // Clamp value to not exceed requested
        $returnedQty = min($returnedQty, $request->quantity_requested);
        $damagedQty = $request->quantity_requested - $returnedQty;

        // Update return remark with summary
        $request->status = 'returned';
        $request->return_remark = "Returned: {$returnedQty} good" . ($damagedQty > 0 ? ", {$damagedQty} damaged" : "");

        $inventoryTable = $this->fetchTable('InventoryItems');
        $item = $inventoryTable->get($request->inventory_item_id);
        $item->quantity += $returnedQty;
        $item->setDirty('quantity', true);

        if (
            $this->BorrowRequests->save($request) &&
            $inventoryTable->save($item)
        ) {
            $this->Flash->success("Marked as returned. {$returnedQty} added to inventory.");
        } else {
            $this->Flash->error("Could not update inventory or borrow request.");
        }

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

    // ✅ Pass $inventoryItems to the view
    $this->set(compact('inventoryItems'));

    // Load view into variable
    $this->viewBuilder()->disableAutoLayout();
    $this->viewBuilder()->setTemplate('pdf_inventory'); // refers to templates/Admins/pdf_inventory.php
    $html = $this->render()->getBody();

    // Generate PDF
    $options = new \Dompdf\Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output to browser
    return $this->response
        ->withType('application/pdf')
        ->withHeader('Content-Disposition', 'attachment; filename="inventory_list.pdf"')
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
        ->where(['status IN' => ['approved', 'pending']])
        ->all();

    foreach ($requests as $request) {
        if ($request->return_date && $request->return_time) {
            $due = new \DateTime($request->return_date->format('Y-m-d') . ' ' . $request->return_time->format('H:i:s'));

            if ($now > $due && $request->status !== 'overdue') {
                $request->status = 'overdue';
                $request->return_remark = 'Automatically marked overdue by system';

                if ($this->BorrowRequests->save($request)) {
                    // Send email if user and item info exist
                    if ($request->user && $request->inventory_item) {
                        $user = $request->user;
                        $item = $request->inventory_item;

                        $mailer = new Mailer('default');
                        $mailer->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
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

}
