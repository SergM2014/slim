<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class Login extends Action
{
    public function __construct(LoggerInterface $logger, UserRepository $myUserRepository)
    {
        parent::__construct($logger);
        $this->myUserRepository = $myUserRepository;
    }

    protected function action(): Response
    {
        $data = $this->getFormData();

        $view = Twig::fromRequest($this->request);
        
        $validationErrors = $this->checkIsNotValidForm($data);

        if($validationErrors) {
             return $view->render($this->response, 'login.html', [
               'errors' => $validationErrors,
               'oldInput' => $data
            ]);
        }

        $loggedUser = $this-> myUserRepository->getVerifiedUser($data);
     
        if(!$loggedUser){
            return $view->render($this->response, 'login.html', [
              'message' => 'Wrong credentials! Try one more time!'
            ]);
        };
      
        $this->startAdminSession($loggedUser);

        return $view->render($this->response, 'index2.html', [
        'message' => 'You are registered! Greetings!', 'name' => $loggedUser->getName()
        ]);
    }

    private function checkIsNotValidForm($data)
    {
        $password = $data['password'];
        $email = $data['email'];

        $validationErrors = [];

        if (empty($email)) {
            $validationErrors['email'] = 'Input required';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validationErrors['email'] = 'email required';
        }

        if (empty($password)) {
            $validationErrors['password'] = 'Input required';
        }
        if (strlen($password)<6) {
            $validationErrors['password'] = 'Min 6 characters are required';
        }

        if (!empty($validationErrors)) {
            return $validationErrors;
         }

         return false;
    }
}