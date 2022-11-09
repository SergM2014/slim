<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CsrfMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    { 
        try{
            if(($_SESSION['csrf']) != $request->getParsedBody()['_token']) {

            throw new \Exception('wrong form credentials!');
            } 
        }
            catch (\Exception $e) {
        
                echo $e->getMessage(); die();
            }

            return $handler->handle($request);
    }
}