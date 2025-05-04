<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        // Load the Borrowings table
        $borrowingsTable = $this->fetchTable('Borrowings');

        // Fetch pending borrow requests
        $pending = $borrowingsTable->find()
            ->where(['status' => 'pending'])
            ->contain(['Users', 'Items']) // Include Users and Items associations
            ->all();

        $this->set(compact('pending'));
    }

    public function approve($id)
    {
        $borrowingsTable = $this->fetchTable('Borrowings');
        $itemsTable = $this->fetchTable('Items');
    
        $borrowing = $borrowingsTable->get($id, ['contain' => ['Items']]);
        $item = $borrowing->item;
    
        if ($item->quantity >= $borrowing->quantity) {
            $borrowing->status = 'approved';
            $item->quantity -= $borrowing->quantity; // Deduct the quantity only on approval
    
            if ($borrowingsTable->save($borrowing) && $itemsTable->save($item)) {
                $this->Flash->success('The borrowing request has been approved.');
            } else {
                $this->Flash->error('The borrowing request could not be approved. Please try again.');
            }
        } else {
            $this->Flash->error('Not enough items in stock to approve this request.');
        }
    
        return $this->redirect(['action' => 'index']);
    }

    public function reject($id)
    {
        $borrowingsTable = $this->fetchTable('Borrowings');
        $borrowing = $borrowingsTable->get($id, ['contain' => ['Users']]);

        if ($this->request->is(['post', 'put'])) {
            $note = $this->request->getData('note'); // Get the rejection note
            $borrowing->status = 'rejected';
            $borrowing->rejection_note = $note; // Save the note to the borrowing record

            if ($borrowingsTable->save($borrowing)) {
                $this->Flash->success('The borrowing request has been rejected, and the note has been sent to the borrower.');
            } else {
                $this->Flash->error('The borrowing request could not be rejected. Please try again.');
            }

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('borrowing'));
    }

    public function return($id)
    {
        $borrowingsTable = $this->fetchTable('Borrowings');
        $itemsTable = $this->fetchTable('Items');

        $borrowing = $borrowingsTable->get($id, ['contain' => ['Items']]);
        $item = $borrowing->item;

        // Mark as returned and restore the item's quantity
        $borrowing->status = 'returned';
        $item->quantity += $borrowing->quantity;

        if ($borrowingsTable->save($borrowing) && $itemsTable->save($item)) {
            $this->Flash->success('The item has been marked as returned and the inventory updated.');
        } else {
            $this->Flash->error('The item could not be marked as returned. Please try again.');
        }

        return $this->redirect(['action' => 'borrowed']);
    }

    public function borrowed()
    {
        $borrowingsTable = $this->fetchTable('Borrowings');
        $borrowed = $borrowingsTable->find()
            ->where(['status' => 'approved']) // Fetch only approved borrowings
            ->contain(['Users', 'Items']) // Include Users and Items associations
            ->all();

        $this->set(compact('borrowed'));
    }

    public function itemsStatus()
    {
        $borrowingsTable = $this->fetchTable('Borrowings');
    
        // Fetch all borrowings with status 'approved' or 'pending'
        $borrowings = $borrowingsTable->find()
            ->where(['status IN' => ['approved', 'pending']])
            ->contain(['Users', 'Items']) // Include Users and Items associations
            ->all();
    
        $this->set(compact('borrowings'));
    }
}