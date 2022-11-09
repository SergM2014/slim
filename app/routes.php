<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;
use App\Application\Actions\Admin\Register;
use App\Application\Actions\Admin\Login;
use App\Application\Actions\Admin\LogOut;
use App\Application\Actions\Admin\RecoverPassword;
use App\Application\Actions\Admin\UserCredentials;
use App\Application\Actions\Admin\ChangePassword;
use App\Application\Actions\Admin\UsersList;
use App\Application\Actions\Admin\UserDelete;
use App\Application\Middleware\CheckIfLoggedMiddleware;
use App\Application\Middleware\OnlyGuestMiddleware;
use App\Application\Actions\Admin\SessionsList;
use App\Application\Middleware\CsrfMiddleware;;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $sessionId = $request->getAttribute('sessionId');
        $isAdmin = $_SESSION['admin'] ?? false ;
        $view = Twig::fromRequest($request);
        return $view->render($response, 'myIndex.html', [
             'sessionId' => $sessionId,
             'isAdmin' => $isAdmin
        ]);
    });

    $app->get('/logout', LogOut::class);

    $app->group('', function(Group $group){
        $group->get('/register', function (Request $request, Response $response) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'register.html', [
                'csrf' => ($_SESSION['csrf'])
            ]);
        });
    
        $group->get('/login', function (Request $request, Response $response) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'login.html', [
                'csrf' => ($_SESSION['csrf'])
            ] );
        });
        
        $group->post('/register', Register::class)->add(CsrfMiddleware::class);
        $group->post('/login', Login::class)->add(CsrfMiddleware::class);
       
        $group->get('/forgot-password', function (Request $request, Response $response) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'forgot-password.html',[
                'csrf' => ($_SESSION['csrf'])
            ] );
        });
        $group->post('/forgot-password', RecoverPassword::class)->add(CsrfMiddleware::class);
    
        $group->get('/recover-password', UserCredentials::class);
        $group->post('/changePassword', ChangePassword::class);
    })->add(OnlyGuestMiddleware::class);


    $app->group('/admin', function(Group $group){
        
        $group->get('', function (Request $request, Response $response) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'index2.html', [
                'name' => ($_SESSION['admin']['name'])?? 'default',
                'email' => ($_SESSION['admin']['email'])?? 'default',
                'csrf' => ($_SESSION['csrf'])
            ]);
        });
        $group->get('/users', UsersList::class);
        $group->post('/users/delete', UserDelete::class)->add(CsrfMiddleware::class);
        $group->get('/sessions', SessionsList::class);

    })->add(CheckIfLoggedMiddleware::class);

};
