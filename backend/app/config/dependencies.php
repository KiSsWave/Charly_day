<?php

require_once __DIR__ . '/../vendor/autoload.php';

use charly\application\action\RegisterAction;
use charly\application\action\SignInAction;
use charly\application\middleware\AuthnMiddleware;
use charly\application\middleware\AuthzUserMiddleware;
use charly\application\middleware\AuthzAdminMiddleware;
use charly\application\providers\AuthnProviderInterface;
use charly\application\providers\JWTAuthnProvider;
use charly\application\providers\JWTManager;
use charly\core\repositoryInterfaces\UserRepositoryInterface;
use charly\core\services\auth\AuthnService;
use charly\core\services\auth\AuthnServiceInterface;
use charly\core\services\auth\AuthzService;
use charly\core\services\auth\AuthzServiceInterface;
use charly\infrastructure\repositories\UserRepository;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;
use charly\application\middleware\CorsMiddleware;


return [
    'dotenv' => function () {
        $dotenv = Dotenv::createImmutable(__DIR__ , ['.env','dbconnexion.env']);
        $dotenv->load();
        return $dotenv;
    },


    'db.config' => function () {
        return [
            'dsn' => "pgsql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=charly",
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ];
    },

    PDO::class => function (ContainerInterface $container) {
        $config = $container->get('db.config');

        try {
            $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            throw new RuntimeException("Erreur lors de la connexion à la base de données : " . $e->getMessage());
        }
    },

    CorsMiddleware::class => function (){
        return new CorsMiddleware();
    },

    JWTManager::class => function () {
        return new JWTManager();
    },



    UserRepositoryInterface::class => function(ContainerInterface $c){
      return new UserRepository($c->get(PDO::class));
    },

    AuthnServiceInterface::class => function (ContainerInterface $c){
        return new AuthnService($c->get(UserRepositoryInterface::class));
    },

    AuthnProviderInterface::class =>function (ContainerInterface $c){
        return new JWTAuthnProvider($c->get(JWTManager::class), $c->get(AuthnServiceInterface::class));
    },

    AuthzServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzService($c->get(UserRepositoryInterface::class));
    },

    AuthnMiddleware::class =>function (ContainerInterface $c){
        return new AuthnMiddleware($c->get(AuthnProviderInterface::class));
    },

    AuthzUserMiddleware::class =>function (ContainerInterface $c){
        return new AuthzUserMiddleware($c->get(AuthzServiceInterface::class));
    },

    AuthzAdminMiddleware::class =>function (ContainerInterface $c){
        return new AuthzAdminMiddleware($c->get(AuthzServiceInterface::class));
    },


    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get(AuthnProviderInterface::class));
    },

    RegisterAction::class => function (ContainerInterface $c){
        return new RegisterAction($c->get(AuthnProviderInterface::class));
    },


];
