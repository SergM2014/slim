<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use App\Infrastructure\Mail;

class RecoverPassword extends Action
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
             return $view->render($this->response, 'forgot-password.html', [
               'message' => 'Wrong credentials! Try one more time!',
               'errors' => $validationErrors,
               'oldInput' => $data
            ]);
        }

        $resetToken = $this-> myUserRepository->setResetToken($data);

       //send Email, do not uncoment it doesnot work properly docker enviroment
      // (new Mail())->send($data['email'], $resetToken);

        $sessionId = $this->request->getAttribute('sessionId');

        return $view->render($this->response, 'myIndex.html', [
            'message' => 'See your Email to refresh password',
            'sessionId' => $sessionId
        ]);
    }

    private function checkIsNotValidForm($data): mixed
    {

        $email = ($data['email'])?? null;
        $validationErrors = [];
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validationErrors['email'] = 'email required';
        }

        if (!empty($validationErrors)) {
            return $validationErrors;
         }

         return false;
    }
}