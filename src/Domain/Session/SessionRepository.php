<?php

declare(strict_types=1);

namespace App\Domain\Session;

interface SessionRepository
{
    public function getSessions(): array;
}