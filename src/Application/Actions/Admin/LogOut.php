<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;


class LogOut extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $_SESSION = [];

        $sessionId = $this->request->getAttribute('sessionId');
        
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'myIndex.html', [
             'message' => 'You are logout! Congratulations!',  
             'sessionId' => $sessionId
        ]);
    }
}