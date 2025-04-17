<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class BorrowingsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Borrowings');
        $this->loadModel('Borrowers');
        $this->loadModel('Items');
    }

    public function pending()
    {
        $pending = $this->Borrowings->find()
            ->where(['status' => 'pending'])
            ->contain(['Borrowers', 'Items']);

        $this->set(compact('pending'));
    }

    public function approve($id)
    {
        $borrowing = $this->Borrowings->get($id);
        $borrowing->status = 'approved';

        if ($this->Borrowings->save($borrowing)) {
            $this->Flash->success('Request approved.');
        } else {
            $this->Flash->error('Could not approve.');
        }

        return $this->redirect(['action' => 'pending']);
    }

    public function reject($id)
    {
        $borrowing = $this->Borrowings->get($id);
        $borrowing->status = 'rejected';

        if ($this->Borrowings->save($borrowing)) {
            $this->Flash->success('Request rejected.');
        } else {
            $this->Flash->error('Could not reject.');
        }

        return $this->redirect(['action' => 'pending']);
    }
}
