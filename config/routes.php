<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    // ✅ SocialAuth plugin routes (Google login and callback) with GET + POST allowed
    $routes->scope('/auth', ['plugin' => 'ADmad/SocialAuth'], function (RouteBuilder $builder): void {
    $builder->connect(
        '/login/{provider}',                        // ✅ accepts /auth/login/Google
        ['controller' => 'Auth', 'action' => 'login'],
        ['pass' => ['provider']]                   // ✅ passes 'Google' to the controller
    );

    $builder->connect(
        '/callback/{provider}',
        ['controller' => 'Auth', 'action' => 'callback'],
        ['pass' => ['provider']]
    );
});





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
        $builder->connect('/admins/borrow-history', ['controller' => 'Admins', 'action' => 'history']);
        $builder->connect('/admins/approved-requests', ['controller' => 'Admins', 'action' => 'approvedRequests']);
        $builder->connect('/admins/mark-as-returned/:id', ['controller' => 'Admins', 'action' => 'markAsReturned']);

        // Pages
        $builder->connect('/pages/*', 'Pages::display');

        // Fallbacks for all other routes
        $builder->fallbacks();
    });
};
