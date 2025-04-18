<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Event\EventInterface;
use Cake\Utility\Security;
use Cake\Log\Log;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Allow non-authenticated users to access login and register
        $this->Authentication->addUnauthenticatedActions(['login', 'register','logtest']);
    }


public function login()
{
    $this->request->allowMethod(['get', 'post']);
    $result = $this->Authentication->getResult();

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // 🔍 Manual DB lookup for logging and fallback
        $user = $this->Users->find('auth')
            ->where(['email' => $data['email']])
            ->first();

        if ($user) {
            $hasher = new DefaultPasswordHasher();
            if ($hasher->check($data['password'], $user->password)) {
                Log::write('debug', '✅ Password matches manually!');

                // ✅ Set identity manually (fallback)
                $this->Authentication->setIdentity($user);
                $this->request = $this->request->withAttribute('identity', $user);
                Log::write('debug', '✅ Manually set identity for login');

                // 🎯 Role-based redirect
                if ($user->role === 'admin') {
                    return $this->redirect(['controller' => 'Admins', 'action' => 'dashboard']);
                } elseif ($user->role === 'borrower') {
                    return $this->redirect(['controller' => 'BorrowRequests', 'action' => 'index']);
                } else {
                    return $this->redirect('/');
                }

            } else {
                Log::write('debug', '❌ Manual password check failed');
                $this->Flash->error('Invalid email or password.');
            }
        } else {
            Log::write('debug', '❌ User not found by email');
            $this->Flash->error('Invalid email or password.');
        }

        // ⛔ Log failed Authentication result from plugin
        if (!$result->isValid()) {
            Log::write('debug', '❌ CakePHP Authentication plugin failed');
            Log::write('debug', print_r($result, true));
        }
    }
}

    


    public function logout()
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['action' => 'login']);
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // Always set role to 'borrower' for public registrations
            $user->role = 'borrower';

            if ($this->Users->save($user)) {
                $this->Flash->success('Registration successful. Please log in.');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('Registration failed. Please check the form and try again.');
        }

        $this->set(compact('user'));
    }

    // 🧠 CRUD functions (from bake)
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['BorrowRequests']);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


public function logtest()
{
    Log::write('debug', '✅ This is a manual debug test.');
    return $this->response->withStringBody('Wrote to debug.log');
}



public function generateAdminPassword()
{
    $hasher = new DefaultPasswordHasher();
    $hashed = $hasher->hash('admin123');
    debug($hashed);
    die;
}
}