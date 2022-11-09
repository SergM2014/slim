<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CheckIfLoggedMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    { 
        if(!isset($_SESSION['admin'])) {

           $response = $handler->handle($request);
           return $response->withHeader('Location', '/login')->withStatus(302);
        }
      
        return $handler->handle($request);
    }
}