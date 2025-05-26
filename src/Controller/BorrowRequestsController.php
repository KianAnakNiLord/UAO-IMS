<?php
declare(strict_types=1);

namespace App\Controller;
/**
 * @property \App\Model\Table\BorrowRequestsTable $BorrowRequests
 * @property \App\Model\Table\InventoryItemsTable $InventoryItems
 */
use Cake\Mailer\Mailer;

class BorrowRequestsController extends AppController
{
    
    public function initialize(): void
{
    parent::initialize();

    $this->BorrowRequests = $this->fetchTable('BorrowRequests');
    $this->InventoryItems = $this->fetchTable('InventoryItems');
}
    public function index()
{
    $user = $this->request->getAttribute('identity');
    $isAdmin = $user && $user->get('role') === 'admin';

    $now = new \DateTime();

    $overdueRequests = $this->BorrowRequests->find()
        ->contain(['Users', 'InventoryItems'])
        ->where(['status' => 'approved'])
        ->all();

    foreach ($overdueRequests as $request) {
        if ($request->return_date && $request->return_time) {
            $due = new \DateTime($request->return_date->format('Y-m-d') . ' ' . $request->return_time->format('H:i:s'));

            if ($now > $due && $request->status !== 'overdue') {
                $request->status = 'overdue';
                $request->return_remark = 'Automatically marked overdue by system';

                if ($this->BorrowRequests->save($request)) {
                    if ($request->user && $request->inventory_item) {
                        $user = $request->user;
                        $item = $request->inventory_item;

                        $mailer = new Mailer('default');
                        $mailer->setEmailFormat('html')
                            ->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
                            ->setTo($user->email)
                            ->setSubject('Borrow Request Overdue')
                            ->viewBuilder()
                                ->setTemplate('overdue_email')
                                ->setLayout('custom');

                        $mailer->setViewVars([
                            'user' => $user,
                            'item' => $item,
                            'request' => $request
                        ]);

                        $mailer->deliver();
                    }
                }
            }
        }
    }
$statusFilter = $this->request->getQuery('status');

$this->paginate = [
    'limit' => 5,
    'order' => ['BorrowRequests.created' => 'desc']
];

$conditions = [];

if (!$isAdmin) {
    $conditions['user_id'] = $user?->get('id');
}

if (!empty($statusFilter)) {
    $conditions['status'] = $statusFilter;
}
$query = $this->BorrowRequests->find()
    ->where($conditions)
    ->contain(['Users', 'InventoryItems']);

$borrowRequests = $this->paginate($query);
$this->set(compact('borrowRequests', 'statusFilter'));

}
    public function add()
{
    $identity = $this->request->getAttribute('identity');
    $userId = $identity->get('id');
    $hasOverdue = $this->BorrowRequests
        ->find()
        ->where(['user_id' => $userId, 'status' => 'overdue'])
        ->count();

    if ($hasOverdue > 0) {
        $this->Flash->error('You cannot make a new borrow request while you have an overdue item. Please return it first.');
        return $this->redirect(['action' => 'index']);
    }

    $borrowRequest = $this->BorrowRequests->newEmptyEntity();

    if ($this->request->is('post')) {
        $data = $this->request->getData();
        $data['user_id'] = $userId;
        $data['status'] = 'pending';

        if (!empty($data['return_time'])) {
            $data['return_time'] = date('H:i:s', strtotime($data['return_time']));
        }
        $returnDate = $data['return_date'] ?? null;
        $returnTime = $data['return_time'] ?? null;

        if (!empty($returnDate) && !empty($returnTime)) {
            $returnDateTime = new \DateTime("{$returnDate} {$returnTime}");
            $now = new \DateTime();

            if ($returnDateTime <= $now) {
                $this->Flash->error('The return date and time must be in the future.');
                return $this->redirect(['action' => 'add']);
            }
        }
        $file = $this->request->getData('id_image');
        if ($file instanceof \Laminas\Diactoros\UploadedFile && $file->getError() === 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2 MB

            if (!in_array($file->getClientMediaType(), $allowedTypes)) {
                $this->Flash->error('Only JPG, PNG, and GIF files are allowed.');
                return $this->redirect(['action' => 'add']);
            }

            if ($file->getSize() > $maxSize) {
                $this->Flash->error('The image must be less than 2MB.');
                return $this->redirect(['action' => 'add']);
            }

            $filename = time() . '_' . $file->getClientFilename();
            $file->moveTo(WWW_ROOT . 'uploads' . DS . $filename);
            $data['id_image'] = 'uploads/' . $filename;
        } else {
            $data['id_image'] = null;
        }
        $borrowRequest = $this->BorrowRequests->patchEntity($borrowRequest, $data);

        if ($this->BorrowRequests->save($borrowRequest)) {
            $this->Flash->success('Request submitted successfully!');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Could not submit request.');
    }
    $this->InventoryItems = $this->fetchTable('InventoryItems');
$flatInventory = $this->InventoryItems
    ->find()
    ->where([
        'item_condition !=' => 'damaged',
        'quantity >' => 0 
    ])
    ->toArray();

$this->set(compact('borrowRequest', 'flatInventory'));

}
    public function approve($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'approved';
        $this->BorrowRequests->save($request);

        $this->Flash->success('Request approved.');
        return $this->redirect(['action' => 'index']);
    }
    public function reject($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'rejected';
        $this->BorrowRequests->save($request);

        $this->Flash->error('Request rejected.');
        return $this->redirect(['action' => 'index']);
    }
    public function returned($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'returned';
        $request->date_returned = date('Y-m-d');
        $this->BorrowRequests->save($request);

        $this->Flash->success('Marked as returned.');
        return $this->redirect(['action' => 'index']);
    }
public function viewReason($id = null)
{
    $request = $this->BorrowRequests->get($id, [
        'contain' => ['Users', 'InventoryItems'],
    ]);

    $this->set(compact('request'));
}
public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);
    $borrowRequest = $this->BorrowRequests->get($id);

    $identity = $this->request->getAttribute('identity');
    if ($borrowRequest->user_id !== $identity->get('id')) {
        $this->Flash->error(__('You are not authorized to delete this request.'));
        return $this->redirect(['action' => 'index']);
    }

    if (!in_array($borrowRequest->status, ['pending', 'rejected'])) {
        $this->Flash->error(__('You can only delete requests that are pending or rejected.'));
        return $this->redirect(['action' => 'index']);
    }

    if ($this->BorrowRequests->delete($borrowRequest)) {
        $this->Flash->success(__('The borrow request has been deleted.'));
    } else {
        $this->Flash->error(__('The borrow request could not be deleted. Please try again.'));
    }

    return $this->redirect(['action' => 'index']);
}
public function dashboard()
{
    $user = $this->request->getAttribute('identity'); 
    if (!$user) {
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    $borrowRequests = $this->BorrowRequests->find('all')
        ->where(['user_id' => $user->id])
        ->contain(['InventoryItems'])
        ->order(['created' => 'DESC']);

    $this->set(compact('borrowRequests'));
}
public function checkTime()
{
    echo "<h3>Server Time:</h3>";
    echo date('Y-m-d H:i:s');
    echo "<br><br><strong>Timezone used:</strong> " . date_default_timezone_get();
    phpinfo();
    exit;
}
public function viewApproval($id = null)
{
    $request = $this->BorrowRequests->get($id, [
        'contain' => ['Users', 'InventoryItems'],
    ]);

    $this->set(compact('request'));
}

public function viewRemark($id = null)
{
    $request = $this->BorrowRequests->get($id, [
        'contain' => ['Users', 'InventoryItems'],
    ]);

    $this->set(compact('request'));
}
public function edit($id = null)
{
    $user = $this->request->getAttribute('identity');
    $borrowRequest = $this->BorrowRequests->get($id);

    if (!$user || $user->id !== $borrowRequest->user_id || $borrowRequest->status !== 'pending') {
        $this->Flash->error('You are not allowed to edit this request.');
        return $this->redirect(['action' => 'index']);
    }

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();

        if (!empty($data['return_time'])) {
            $data['return_time'] = date('H:i:s', strtotime($data['return_time']));
        }

        if (!empty($data['return_date']) && !empty($data['return_time'])) {
            $returnDateTime = new \DateTime("{$data['return_date']} {$data['return_time']}");
            $now = new \DateTime();
            if ($returnDateTime <= $now) {
                $this->Flash->error('Return date/time must be in the future.');
                return $this->redirect(['action' => 'edit', $id]);
            }
        }
        $file = $this->request->getData('id_image');
        if ($file instanceof \Laminas\Diactoros\UploadedFile && $file->getError() === 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($file->getClientMediaType(), $allowedTypes)) {
    $this->set('fileUploadError', 'Only JPG, PNG, and GIF files are allowed.');
    $this->set(compact('borrowRequest')); 
    return; 
}
            if ($file->getSize() > $maxSize) {
                $this->Flash->error('The image must be less than 2MB.');
                return $this->redirect(['action' => 'edit', $id]);
            }
            $filename = time() . '_' . $file->getClientFilename();
            $file->moveTo(WWW_ROOT . 'uploads' . DS . $filename);
            $data['id_image'] = 'uploads/' . $filename;
        } else {
            unset($data['id_image']); 
        }

        $this->BorrowRequests->patchEntity($borrowRequest, $data);

        if ($this->BorrowRequests->save($borrowRequest)) {
            $this->Flash->success('Request updated successfully.');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Could not update the request.');
    }
    $flatInventory = $this->InventoryItems
        ->find()
        ->where(['item_condition !=' => 'damaged', 'quantity >' => 0])
        ->toArray();

    $this->set(compact('borrowRequest', 'flatInventory'));
}

}