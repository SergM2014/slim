<?php

declare(strict_types=1);

namespace App\Domain\User;

use app\Domain\User\User;

interface UserRepository
{
    public function store(array $data): void;

    public function getVerifiedUser(array $data): bool|User;

    public function checkUniqueEmail(string $email): bool;

    public function setResetToken(array $data): string;

    public function getCredentials(string $token): bool|array;

    public function changePassword(array $data): void;

    public function getUsers(): array;

    public function delete(int $id): bool;
}
