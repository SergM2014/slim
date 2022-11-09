<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class UserCredentials extends Action
{
    public function __construct(LoggerInterface $logger, UserRepository $myUserRepository)
    {
        parent::__construct($logger);
        $this->myUserRepository = $myUserRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $token = $_GET['token']?? 'no-cred';
        
        $sessionId = $this->request->getAttribute('sessionId');
       
        $view = Twig::fromRequest($this->request);

        $credentials = $this-> myUserRepository->getCredentials($token);

        $errorMessage = !$credentials ? 'Somethig went wrong with token!' : 'More than 1 Hour of time is passed! You should retry You atempt!';

        $currentTime = time();
        $resetTimestamp = ($credentials['reset_timestamp'])?? ($currentTime - 5000);
        
        if(($currentTime - $resetTimestamp )> 3600){
            return $view->render($this->response, 'myIndex.html', [
                'message' => $errorMessage,  
                'sessionId' => $sessionId 
           ]);
        }

        return $view->render($this->response, 'recover-password.html', [
            'name' => $credentials['name'],
            'email' => $credentials['email']
        ]);
    }

}