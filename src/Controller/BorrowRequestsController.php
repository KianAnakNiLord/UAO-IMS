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

    $query = $isAdmin
        ? $this->BorrowRequests->find('all')->contain(['Users', 'InventoryItems'])
        : $this->BorrowRequests->find('all')
            ->where(['user_id' => $user?->get('id')])
            ->contain(['InventoryItems']);

    // 🔥 This enables pagination
    $borrowRequests = $this->paginate($query);

    $this->set(compact('borrowRequests'));
}

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

            $borrowRequest = $this->BorrowRequests->patchEntity($borrowRequest, $data);

            if ($this->BorrowRequests->save($borrowRequest)) {
                $this->Flash->success('Request submitted successfully!');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not submit request.');
        }

        $inventoryItems = $this->InventoryItems->find('list');
        $this->set(compact('borrowRequest', 'inventoryItems'));
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
}
