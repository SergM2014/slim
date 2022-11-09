<?php

declare(strict_types=1);

use App\Application\Middleware\MySessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(MySessionMiddleware::class); 
};
