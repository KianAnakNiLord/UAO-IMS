<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\BorrowingsTable;
use App\Model\Table\BorrowersTable;
use App\Model\Table\ItemsTable;
use Cake\ORM\Query;

/**
 * Borrowings Controller
 *
 * Handles borrowing transactions.
 *
 * @property BorrowingsTable $Borrowings
 * @property BorrowersTable $Borrowers
 * @property ItemsTable $Items
 */
class BorrowingsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        // ✅ Use dependency injection instead of loadModel()
        $this->Borrowings = $this->fetchTable('Borrowings');
        $this->Borrowers = $this->fetchTable('Borrowers');
        $this->Items = $this->fetchTable('Items');
    }

    /**
     * Index method - Lists all borrowings with borrower & item details
     */
    public function index()
    {
        $query = $this->Borrowings->find()->contain(['Borrowers', 'Items']); // ✅ Include Borrowers & Items
    
        $borrowings = $this->paginate($query);
        $this->set(compact('borrowings'));
    }

    /**
     * View method - Shows borrowing details, including borrower and item
     */
    public function view($id = null)
    {
        $borrowing = $this->Borrowings->get($id, [
            'contain' => ['Borrowers', 'Items'],
        ]);

        $this->set(compact('borrowing'));
    }

    /**
     * Add method - Records a new borrowing transaction
     */
    public function add()
    {
        $borrowing = $this->Borrowings->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $borrowing = $this->Borrowings->patchEntity($borrowing, $this->request->getData());
    
            if ($this->Borrowings->save($borrowing)) {
                $this->Flash->success(__('The borrowing record has been saved.'));
                return $this->redirect(['action' => 'index']); // ✅ Redirect to index
            }
    
            $this->Flash->error(__('The borrowing record could not be saved. Please, try again.'));
        }
    
        // Fetch borrowers and items for dropdown selection
        $borrowers = $this->Borrowings->Borrowers->find('list');
        $items = $this->Borrowings->Items->find('list');
    
        $this->set(compact('borrowing', 'borrowers', 'items'));
    }

    public function addborrower()
{
    $borrower = $this->Borrowings->Borrowers->newEmptyEntity();

    if ($this->request->is('post')) {
        $borrower = $this->Borrowings->Borrowers->patchEntity($borrower, $this->request->getData());

        if ($this->Borrowings->Borrowers->save($borrower)) {
            $this->Flash->success(__('The borrower has been added.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('The borrower could not be added. Please, try again.'));
    }

    $this->set(compact('borrower'));
}

    /**
     * Edit method - Modifies a borrowing record
     */
    public function edit($id = null)
    {
        $borrowing = $this->Borrowings->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $borrowing = $this->Borrowings->patchEntity($borrowing, $this->request->getData());
            if ($this->Borrowings->save($borrowing)) {
                $this->Flash->success(__('The borrowing record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The borrowing record could not be updated. Please, try again.'));
        }

        $borrowers = $this->Borrowers->find('list', ['limit' => 200]);
        $items = $this->Items->find('list', ['limit' => 200]);
        $this->set(compact('borrowing', 'borrowers', 'items'));
    }

    /**
     * Delete method - Removes a borrowing record
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $borrowing = $this->Borrowings->get($id);
        if ($this->Borrowings->delete($borrowing)) {
            $this->Flash->success(__('The borrowing record has been deleted.'));
        } else {
            $this->Flash->error(__('The borrowing record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
