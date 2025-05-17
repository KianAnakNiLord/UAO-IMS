<?php
declare(strict_types=1);

namespace App\Controller;
/**
 * @property \App\Model\Table\BorrowRequestsTable $BorrowRequests
 * @property \App\Model\Table\InventoryItemsTable $InventoryItems
 */


class BorrowRequestsController extends AppController
{
    
    public function initialize(): void
{
    parent::initialize();

    $this->BorrowRequests = $this->fetchTable('BorrowRequests');
    $this->InventoryItems = $this->fetchTable('InventoryItems');
}



    // ✅ Borrower - View Their Own Requests
    public function index()
{
    $user = $this->request->getAttribute('identity');
    $isAdmin = $user && $user->get('role') === 'admin';

    // ✅ Auto-mark overdue if return_date + return_time is in the past
    $now = new \DateTime();

    $overdueRequests = $this->BorrowRequests->find()
        ->where(['status IN' => ['approved', 'pending']])
        ->all();

    foreach ($overdueRequests as $request) {
        if ($request->return_date && $request->return_time) {
            $due = new \DateTime($request->return_date->format('Y-m-d') . ' ' . $request->return_time->format('H:i:s'));
            if ($now > $due) {
                $request->status = 'overdue';
                $this->BorrowRequests->save($request);
            }
        }
    }

    $query = $isAdmin
        ? $this->BorrowRequests->find('all')->contain(['Users', 'InventoryItems'])
        : $this->BorrowRequests->find('all')
            ->where(['user_id' => $user?->get('id')])
            ->contain(['InventoryItems']);

    $borrowRequests = $this->paginate($query);

    $this->set(compact('borrowRequests'));
}


    // ✅ Borrower - Submit Request
    // ✅ Borrower - Submit Request
    public function add()
    {
        $borrowRequest = $this->BorrowRequests->newEmptyEntity();
    
        if ($this->request->is('post')) {
            $data = $this->request->getData();
    
            // Automatically set user_id and status
            $identity = $this->request->getAttribute('identity');
            $data['user_id'] = $identity->get('id');
            $data['status'] = 'pending';
    
            // Convert return_time to proper format
            if (!empty($data['return_time'])) {
                $data['return_time'] = date('H:i:s', strtotime($data['return_time']));
            }
    
            // ✅ Handle ID image upload with file type and size validation
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
    
            // Patch and save the request
            $borrowRequest = $this->BorrowRequests->patchEntity($borrowRequest, $data);
    
            if ($this->BorrowRequests->save($borrowRequest)) {
                $this->Flash->success('Request submitted successfully!');
                return $this->redirect(['action' => 'index']);
            }
    
            $this->Flash->error('Could not submit request.');
        }
    
        // Fetch inventory items for the form dropdown
        $this->InventoryItems = $this->fetchTable('InventoryItems');
$flatInventory = $this->InventoryItems->find('all')->toArray();
$this->set(compact('borrowRequest', 'flatInventory'));

    }
    

    

    // ✅ Admin - Approve Request
    public function approve($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'approved';
        $this->BorrowRequests->save($request);

        $this->Flash->success('Request approved.');
        return $this->redirect(['action' => 'index']);
    }

    // ✅ Admin - Reject Request
    public function reject($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'rejected';
        $this->BorrowRequests->save($request);

        $this->Flash->error('Request rejected.');
        return $this->redirect(['action' => 'index']);
    }

    // ✅ Admin - Mark as Returned
    public function returned($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'returned';
        $request->date_returned = date('Y-m-d');
        $this->BorrowRequests->save($request);

        $this->Flash->success('Marked as returned.');
        return $this->redirect(['action' => 'index']);
    }

    // ✅ Admin - Mark as Overdue
    public function overdue($id)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'overdue';
        $this->BorrowRequests->save($request);

        $this->Flash->error('Marked as overdue.');
        return $this->redirect(['action' => 'index']);
    }


public function viewReason($id = null)
{
    $request = $this->BorrowRequests->get($id, [
        'contain' => ['Users', 'InventoryItems'],
    ]);

    $this->set(compact('request'));
}

// BorrowRequestsController.php

public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);
    $borrowRequest = $this->BorrowRequests->get($id);

    $identity = $this->request->getAttribute('identity');

    // ✅ Only allow delete if owner and status is 'pending' or 'rejected'
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
    $user = $this->request->getAttribute('identity'); // Get the logged-in user
    if (!$user) {
        // Redirect if the user is not logged in
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // Fetch borrow requests for the logged-in user
    $borrowRequests = $this->BorrowRequests->find('all')
        ->where(['user_id' => $user->id])
        ->contain(['InventoryItems'])
        ->order(['created' => 'DESC']);

    $this->set(compact('borrowRequests'));
}
}