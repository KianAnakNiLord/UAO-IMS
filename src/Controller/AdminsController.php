<?php
declare(strict_types=1);

namespace App\Controller;

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
        // Admin Dashboard page
    }

    public function inventory()
    {
        $this->InventoryItems = $this->fetchTable('InventoryItems');

        $query = $this->InventoryItems->find();

        // Filtering
        $search = $this->request->getQuery('search');
        $category = $this->request->getQuery('category');

        if ($search) {
            $query->where(function ($exp, $q) use ($search) {
                return $exp->like('name', '%' . $search . '%');
            });
        }

        if ($category) {
            $query->where(['category' => $category]);
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
        $item = $this->InventoryItems->get($id);

        if ($this->request->is(['post', 'delete'])) {
            if ($this->InventoryItems->delete($item)) {
                $this->Flash->success('Item deleted.');
            } else {
                $this->Flash->error('Item could not be deleted.');
            }
        }

        return $this->redirect(['action' => 'inventory']);
    }

    public function borrowRequests()
    {
        $requests = $this->BorrowRequests
            ->find('all')
            ->contain(['Users', 'InventoryItems'])
            ->where(['BorrowRequests.status' => 'pending']) // Only show pending borrow requests
            ->order(['BorrowRequests.created' => 'DESC']);

        $this->set('borrowRequests', $requests);
    }

    public function approveRequest($id = null)
    {
        $request = $this->BorrowRequests->get($id);
        $request->status = 'approved';

        if ($this->BorrowRequests->save($request)) {
            $this->Flash->success('Request approved successfully.');
        } else {
            $this->Flash->error('Could not approve request.');
        }

        return $this->redirect(['action' => 'borrowRequests']);
    }

    public function rejectRequest($id = null)
    {
        $request = $this->BorrowRequests->get($id);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $request->status = 'rejected';
            $request->rejection_reason = $data['rejection_reason'];

            if ($this->BorrowRequests->save($request)) {
                $this->Flash->success('Request rejected with reason.');
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
        // Get search query from the GET request
        $search = $this->request->getQuery('email');

        // Build query for finding the borrow requests
        $query = $this->BorrowRequests->find()
            ->contain(['Users', 'InventoryItems'])
            ->where(['BorrowRequests.status IN' => ['approved', 'rejected', 'returned']])

            ->order(['BorrowRequests.created' => 'DESC']);

        if ($search) {
            $query->where(['Users.email LIKE' => '%' . $search . '%']);
        }

        // Paginate the results
        $history = $this->paginate($query);

        // Set the data for the view
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
        ->where(['BorrowRequests.status' => 'approved']) // Filter approved requests
        ->order(['BorrowRequests.created' => 'DESC']);  // Specify the table for the 'created' column

    $this->set(compact('approvedRequests'));
}



public function markAsReturned($id = null)
{
    $user = $this->request->getAttribute('identity'); // Get the logged-in user

    // Redirect to the login page if the user is not authenticated or not an admin
    if (!$user || $user->role !== 'admin') {
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // Fetch the borrow request by ID
    $request = $this->BorrowRequests->get($id);

    if ($this->request->is(['post', 'put'])) {
        // Get the remark value from the form
        $data = $this->request->getData();
        $request->status = 'returned'; // Update the status to 'returned'
        $request->return_remark = $data['remark']; // Set the remark

        // Save the request and give feedback
        if ($this->BorrowRequests->save($request)) {
            $this->Flash->success('Request marked as returned successfully.');
        } else {
            $this->Flash->error('Could not mark the request as returned.');
        }

        return $this->redirect(['action' => 'approvedRequests']);
    }

    $this->set(compact('request'));
}


}
