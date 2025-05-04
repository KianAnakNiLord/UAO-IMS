<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Datasource\Exception\RecordNotFoundException;

class RegisterController extends AppController
{
    public function index()
    {
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $usersTable->patchEntity($user, $this->request->getData());
            $user->role = 'user'; // Default role for new users
            if ($usersTable->save($user)) {
                $this->Flash->success('Registration successful. You can now log in.');
                return $this->redirect(['controller' => 'Login', 'action' => 'index']);
            }
            $this->Flash->error('Unable to register. Please check the form for errors.');
        }

        $this->set(compact('user'));
    }
}