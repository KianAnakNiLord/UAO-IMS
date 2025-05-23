<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Event\EventInterface;
use Cake\Utility\Security;
use Cake\Log\Log;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Mailer\Mailer;
use Cake\Chronos\Chronos;


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

    $this->Authentication->addUnauthenticatedActions([
        'login', 'register', 'verifyOtp', 'googleLogin', 'googleLoginCallback', 'logtest'
    ]);

    // 🛡️ Restrict access to admin-only actions
    $user = $this->Authentication->getIdentity();
    $adminActions = ['index', 'view', 'add', 'edit', 'delete'];

    if (in_array($this->request->getParam('action'), $adminActions)) {
        if (!$user || $user->get('role') !== 'admin') {
            $this->Flash->error('Unauthorized access.');
            return $this->redirect('/');
        }
    }
}


public function login()
{
    $this->request->allowMethod(['get', 'post']);
    $result = $this->Authentication->getResult();

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        $user = $this->Users->find('auth')
            ->where(['email' => $data['email']])
            ->first();

        if ($user) {
            $hasher = new DefaultPasswordHasher();

           if ($user->role !== 'admin' && (string)$user->is_verified !== '1') {
                $this->Flash->error('This account is not yet verified. Please check your email and enter the OTP.');
                return;
            }
            if ($hasher->check($data['password'], $user->password)) {
                // ✅ NO more OTP checking here

                $this->Authentication->setIdentity($user);
                $this->request = $this->request->withAttribute('identity', $user);

                if ($user->role === 'admin') {
                    return $this->redirect(['controller' => 'Admins', 'action' => 'dashboard']);
                } elseif ($user->role === 'borrower') {
                    return $this->redirect(['controller' => 'BorrowRequests', 'action' => 'index']);
                } else {
                    return $this->redirect('/');
                }
            } else {
                $this->Flash->error('Invalid email or password.');
            }
        } else {
            $this->Flash->error('Invalid email or password.');
        }

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
        $data = $this->request->getData();

        // Generate OTP and expiration
        $otp = str_pad(strval(random_int(100000, 999999)), 6, '0', STR_PAD_LEFT);
        $data['otp_code'] = $otp;
        $data['otp_expires_at'] = Chronos::now()->addMinutes(10);
        $data['is_verified'] = false;
        $data['role'] = 'borrower';

        $user = $this->Users->patchEntity($user, $data);

        try {
            // Send the email first
            $mailer = new Mailer('default');
            $mailer->setFrom(['noreply@uao-ims.test' => 'UAO IMS'])
                ->setTo($data['email'])
                ->setSubject('UAO IMS Email Verification')
                ->deliver("Your OTP is: {$otp}\n\nThis code expires in 10 minutes.");

            // If email was sent successfully, save the user
            if ($this->Users->save($user)) {
                $this->Flash->success('Registration successful! Check your email for the OTP code.');
                return $this->redirect(['action' => 'verifyOtp', $user->id]);
            } else {
                $this->Flash->error('User could not be saved. Please try again.');
            }
        } catch (\Exception $e) {
            // Log and inform if email failed
            Log::write('error', 'OTP Email Error: ' . $e->getMessage());
            $this->Flash->error('Unable to send OTP email. Registration was not completed.');
        }
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

public function verifyOtp($userId = null)
{
    $user = $this->Users->get($userId);

    if ($this->request->is('post')) {
        $submittedOtp = $this->request->getData('otp');

        if ($user->otp_code === $submittedOtp && $user->otp_expires_at > Chronos::now()) {
            $user->is_verified = true;
            $user->otp_code = null;
            $user->otp_expires_at = null;

            if ($this->Users->save($user)) {
                $this->Flash->success('✅ Email verified successfully. You may now log in.');
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('⚠️ Verification failed. Please try again.');
            }
        } else {
            $this->Flash->error('❌ Invalid or expired OTP.');
        }
    }

    $this->set(compact('user'));
}
public function socialLogin($provider = null)
{
    // Log incoming request data (for debugging)
    $this->log($this->request->getData(), 'debug');
    $this->log($this->request->getQuery(), 'debug');

    // Continue with your logic
    $result = $this->Authentication->getResult();

    if ($result->isValid()) {
        // Redirect to dashboard or homepage
        return $this->redirect($this->Authentication->getLoginRedirect() ?? '/');
    }

    // If failed
    $this->Flash->error('Social login failed. Please try again.');
    return $this->redirect(['action' => 'login']);
}
}

