<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\DbUserRepository;
use DI\ContainerBuilder;
use App\Domain\Session\SessionRepository;
use App\Infrastructure\Persistence\Session\DbSessionRepository;

return function (ContainerBuilder $containerBuilder) {
    
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(DbUserRepository::class),
        SessionRepository::class => \Di\autowire(DbSessionRepository::class),
    ]);
};
