<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        // Default route - redirect to login
        $builder->connect('/', ['controller' => 'Users', 'action' => 'login']);

        // Users
        $builder->connect('/users/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/users/register', ['controller' => 'Users', 'action' => 'register']);
        $builder->connect('/users/logout', ['controller' => 'Users', 'action' => 'logout']);

        // Borrowers
        $builder->connect('/borrowers/dashboard', ['controller' => 'Borrowers', 'action' => 'dashboard']);
        $builder->connect('/borrowers/borrow', ['controller' => 'Borrowers', 'action' => 'borrow']);

        // Admins
        $builder->connect('/admins/dashboard', ['controller' => 'Admins', 'action' => 'dashboard']);
        $builder->connect('/admins/inventory', ['controller' => 'Admins', 'action' => 'inventory']);
        $builder->connect('/admins/borrow_requests', ['controller' => 'Admins', 'action' => 'borrowRequests']);

        // Pages
        $builder->connect('/pages/*', 'Pages::display');

        // Fallbacks for all other routes
        $builder->fallbacks();
    });
};
