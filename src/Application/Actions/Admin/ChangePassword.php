<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class ChangePassword extends Action
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
        $data = $this->getFormData();
       
        $validationErrors = $this->checkIsNotValidForm($data);

        $view = Twig::fromRequest($this->request);

        if($validationErrors) {
            return $view->render($this->response, 'recover-password.html', [
                'message' => 'Wrong credentials! Try one more time!',
                'error' => $validationErrors['password'], 
                'name' => $data['name'],
                'email' => $data['email'],
           ]);
        }

        $this-> myUserRepository->changePassword($data);

        $this->startAdminSession($data);

        return $view->render($this->response, 'index2.html');
    }

    private function checkIsNotValidForm($data): mixed
    {
        $password = $data['password'];
      
        $validationErrors = [];

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