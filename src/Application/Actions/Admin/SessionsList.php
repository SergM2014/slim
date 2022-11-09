<?php

declare(strict_types=1);

namespace App\Application\Actions\Admin;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use App\Domain\Session\SessionRepository;

class SessionsList extends Action
{
    public function __construct(LoggerInterface $logger, SessionRepository $sessionRepository)
    {
        parent::__construct($logger);
        $this->sessionRepository = $sessionRepository;
    }

    protected function action(): Response
    {
        $sessions = $this->sessionRepository->getSessions();

        return $this->respondWithData($sessions);
    }
}