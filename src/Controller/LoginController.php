<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class LoginController extends AppController
{
    public function index()
{
    if ($this->request->is('post')) {
        $email = $this->request->getData('email');
        $password = $this->request->getData('password');

        $user = $this->fetchTable('Users')->find()
            ->where(['email' => $email])
            ->first();

        if ($user && password_verify($password, $user->password)) {
            $this->request->getSession()->write('Auth', $user);

            if ($user->role === 'admin') {
                return $this->redirect(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']);
            } else {
                return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
            }
        } else {
            $this->Flash->error('Invalid email or password.');
        }
    }
}

    public function logout()
    {
        $this->request->getSession()->destroy();
        return $this->redirect(['action' => 'index']);
    }
}
