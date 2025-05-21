<?php
declare(strict_types=1);

namespace App;

use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

// ✅ Authentication Plugin
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

use Cake\Core\Configure\Engine\PhpConfig;
use ADmad\SocialAuth\Middleware\SocialAuthMiddleware;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
{
    // ✅ FORCE PHP to use Asia/Manila timezone
    date_default_timezone_set('Asia/Manila');
    ini_set('date.timezone', 'Asia/Manila');

    parent::bootstrap();

    // ✅ Load SocialAuth Plugin
    $this->addPlugin('ADmad/SocialAuth');

    // Load the file-based social auth config
    Configure::config('default', new PhpConfig());
    

    if (PHP_SAPI !== 'cli') {
        FactoryLocator::add(
            'Table',
            (new TableLocator())->allowFallbackClass(false)
        );
    }
}


   public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
{
    $middlewareQueue
        ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
        ->add(new AssetMiddleware([
            'cacheTime' => Configure::read('Asset.cacheTime'),
        ]))
        ->add(new RoutingMiddleware($this))
        ->add(new BodyParserMiddleware())
        ->add(new CsrfProtectionMiddleware([
            'httponly' => true,
        ]))
        ->add(new AuthenticationMiddleware($this))
        ->add(new SocialAuthMiddleware([
            'serviceConfig' => [
                'provider' => [
                    'google' => [
                        'applicationId' => '317753544990-k8stjr2n7de20tt2qummpvc1c64o35dp.apps.googleusercontent.com',
                        'applicationSecret' => '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',
                        'redirectUri' => 'http://localhost/uao-ims/auth/callback/google',
                        'hostedDomain' => 'my.xu.edu.ph',
                        'accessType' => 'offline',
                        'prompt' => 'consent',
                        'scope' => ['email', 'profile']
                    ]
                ]
            ],
            'requestMethod' => ['GET', 'POST'],
            'loginUrl' => '/users/login',
            'loginRedirect' => '/borrowers/dashboard',
            'userModel' => 'Users',
            'finder' => 'all',
            'fields' => ['email'],
            'sessionKey' => 'Auth',
            'providerLoader' => [
                'routeParam' => 'provider',
                'transform' => 'strtolower'
            ],
            // Use the model method as a callback instead of closure
            'getUserCallback' => 'findOrCreateFromSocial',
        ]));

    return $middlewareQueue;
}

    public function services(ContainerInterface $container): void
    {
        // No custom services yet
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
{
    $service = new AuthenticationService();

    $service->loadIdentifier('Authentication.Password', [
        'fields' => [
            'username' => 'email',
            'password' => 'password',
        ],
        'resolver' => [
    'className' => \Authentication\Identifier\Resolver\OrmResolver::class,
    'finder' => 'auth',
    'identityClass' => \App\Model\Entity\User::class,
],

        'passwordHasher' => [
            'className' => \Authentication\PasswordHasher\DefaultPasswordHasher::class,
        ],
    ]);

    $service->loadAuthenticator('Authentication.Session');
    $service->loadAuthenticator('Authentication.Form', [
        'fields' => [
            'username' => 'email',
            'password' => 'password',
        ],
        'loginUrl' => '/users/login',
    ]);

    return $service;
}
}
