<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * @method \Cake\Controller\ComponentRegistry loadComponent(string $name, array $config = [])
 * @method \Cake\ORM\Table loadModel(string $modelClass = null, string $type = 'Table')
 */
class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }
}
