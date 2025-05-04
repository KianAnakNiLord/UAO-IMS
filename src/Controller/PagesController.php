<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Http\Response;
use App\Model\Table\ItemsTable; // Explicitly import ItemsTable
use Cake\ORM\TableRegistry; // Required for accessing tables in CakePHP 5

/**
 * Pages Controller
 *
 * This controller renders views from templates/Pages/
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    private ItemsTable $Items; // Define a property for the Items table

    /**
     * Initialize the controller and load the Items table
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Items = TableRegistry::getTableLocator()->get('Items'); // Load the Items model
    }

    /**
     * Home page
     *
     * Fetches the latest inventory items and passes them to the view.
     */
    public function home(): ?Response
    {
        // Retrieve the latest 5 inventory items, ordered by creation date (newest first)
        $latestItems = $this->Items->find()
            ->order(['created' => 'DESC'])
            ->limit(5)
            ->all();

        // Pass the items to the view
        $this->set(compact('latestItems'));

        return $this->render('home'); // Render the home template
    }

    /**
     * Displays a static page view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException If directory traversal is attempted.
     * @throws \Cake\View\Exception\MissingTemplateException If the view file is missing.
     * @throws \Cake\Http\Exception\NotFoundException If the view file is not found and debug is off.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if ($this->request->is('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
    
        // Allow only the login page to be accessed without authentication
        $allowedActions = ['display'];
        if (!in_array($this->request->getParam('action'), $allowedActions)) {
            $user = $this->request->getSession()->read('Auth');
            if (!$user) {
                $this->Flash->error('You must log in to access this page.');
                $this->redirect(['controller' => 'Login', 'action' => 'index']);
            }
        }
    }
}
