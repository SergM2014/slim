<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class Register extends Action
{
    public function __construct(LoggerInterface $logger, UserRepository $myUserRepository)
    {
        parent::__construct($logger);
        $this->myUserRepository = $myUserRepository;
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
       
        $validationErrors = $this->checkIsNotValidForm($data);

        $usedEmailError = !$this->myUserRepository->checkUniqueEmail($data['email'])? 'Email is already used!': '';
        $view = Twig::fromRequest($this->request);

        if($validationErrors OR strlen($usedEmailError)>1) {

            return $view->render($this->response, 'register.html', [
                'message' => 'Wrong credentials! Try one more time!',
                'errors' => $validationErrors, 
                'usedEmailError' => $usedEmailError,
                'oldInput' => $data
           ]);
        }

        $this-> myUserRepository->store($data);

        $this->startAdminSession($data);

        return $view->render($this->response, 'index2.html', [
        'message' => 'You are registered! Greetings!'
        ]);
    }

    private function checkIsNotValidForm($data): mixed
    {
        $password = $data['password'];
        $email = $data['email'];
        $name = $data['name'];

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

        if (empty($name)) {
            $validationErrors['name'] = 'Input required';
        }
        if (strlen($name)<5) {
            $validationErrors['name'] = 'Min 5 characters are required';
        }

        if (!empty($validationErrors)) {
            return $validationErrors;
         }

         return false;
    }
}