<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Items Controller
 *
 * Handles inventory item management.
 *
 * @property \App\Model\Table\ItemsTable $Items
 */
class ItemsController extends AppController
{
    /**
     * Index method - Lists all items
     */
    public function index()
    {
        $items = $this->paginate($this->Items);
        $this->set(compact('items'));
    }

    /**
     * View method - Shows details of a single item
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id);
        $this->set(compact('item'));
    }

    /**
     * Add method - Adds a new item
     */
    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be added. Please, try again.'));
        }
        $this->set(compact('item'));
    }

    /**
     * Edit method - Updates an existing item
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be updated. Please, try again.'));
        }
        $this->set(compact('item'));
    }

    /**
     * Delete method - Removes an item
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
