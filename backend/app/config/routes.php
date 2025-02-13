<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (\Slim\App $app): \Slim\App {

    $app->add(charly\application\middleware\CorsMiddleware::class);

    $app->post('/signin', charly\application\action\SignInAction::class);
    $app->post('/register', charly\application\action\RegisterAction::class);

    $app->post('/salaries' , \charly\application\action\CreateSalarieAction::class);
    $app->get('/salaries' , \charly\application\action\GetSalariesAction::class);
    $app->post('/competences', \charly\application\action\ManageCompetenceAction::class);
    $app->post('/needs/anonymous', charly\application\action\CreateUnauthNeedAction::class);
    $app->get('/needs/anonymous', charly\application\action\GetUnauthNeedsAction::class);


    $app->group('user', function () use ($app) {
        $app->post('/needs', charly\application\action\CreateNeedAction::class)->add(charly\application\middleware\AuthzUserMiddleware::class);
        $app->get('/needs', charly\application\action\GetUserNeedsAction::class)->add(charly\application\middleware\AuthzUserMiddleware::class);
    })->add(charly\application\middleware\AuthnMiddleware::class);

    $app->post('/mail', charly\application\action\SendMailAction::class);


    return $app;

};
