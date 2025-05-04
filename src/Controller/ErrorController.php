<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ErrorController extends AppController
{
    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Disable authentication for error pages
        $this->Authentication->allowUnauthenticated(['*']);

        // Set a layout specifically for error pages, if needed
        $this->viewBuilder()->setLayout('error');

        // Additional logic: Set a default title for error pages
        $this->set('title', 'Error');
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setTemplatePath('Error');
    }

    /**
     * afterFilter callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return void
     */
    public function afterFilter(EventInterface $event): void
    {
        parent::afterFilter($event);
    }
}