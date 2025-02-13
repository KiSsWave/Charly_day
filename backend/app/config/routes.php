<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (\Slim\App $app): \Slim\App {

    $app->add(charly\application\middleware\CorsMiddleware::class);

    $app->post('/signin', charly\application\action\SignInAction::class);
    $app->post('/register', charly\application\action\RegisterAction::class);

    $app->post('/needs', charly\application\action\CreateNeedAction::class);
    $app->post('/salaries' , \charly\application\action\CreateSalarieAction::class);
    $app->get('/salaries' , \charly\application\action\GetSalariesAction::class);

    return $app;
};


