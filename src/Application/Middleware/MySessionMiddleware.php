<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class MySessionMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    { 
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
          }

            $sessionId = session_id();
            $request = $request->withAttribute('sessionId', $sessionId);
            if(!isset($_COOKIE['sessionId']) OR $sessionId === $_COOKIE['sessionId']) {
                setcookie('sessionId', $sessionId, time()+3600, '/'); 

            }
       
        return $handler->handle($request);
    }
}