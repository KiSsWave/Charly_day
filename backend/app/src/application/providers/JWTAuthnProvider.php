<?php

namespace charly\application\providers;

use charly\application\providers\AuthnProviderInterface;
use charly\core\domain\User\User;
use charly\core\dto\CredentialDTO;
use charly\core\dto\UserDTO;
use charly\core\services\auth\AuthnServiceInterface;
use PhpParser\Token;

class JWTAuthnProvider implements AuthnProviderInterface
{

    private $jwtManager;
    private $authService;

    public function __construct(JWTManager $jwtManager, AuthnServiceInterface $authService)
    {
        $this->jwtManager = $jwtManager;
        $this->authService = $authService;
    }



    #[\Override] public function register(CredentialDTO $c, string $login,int $role)
    {
        $this->authService->createUser($c, $login, $role);
    }

    #[\Override] public function signin(CredentialDTO $c): UserDTO
    {

        $userDTO = $this->authService->ByCredentials($c);
        $userDTO->setToken($this->jwtManager->createAccessToken([
            'id' => $userDTO->getID(),
            'email' => $userDTO->getEmail(),
            'login' => $userDTO->getLogin(),
            'role' => $userDTO->getRole()
        ]));

        return $userDTO;
    }

    #[\Override] public function refresh(Token $token): UserDTO
    {
        // TODO: Implement refresh() method.
    }

    #[\Override] public function getSignedInUser(string $token): UserDTO
    {
        $decodedToken = $this->jwtManager->decodeToken($token);
        $email = $decodedToken['email'];
        $login = $decodedToken['login'];
        $role = $decodedToken['role'];
        $user = new User($email,$login,$role);
        $user->setID($decodedToken['id']);

        return new UserDTO($user);
    }
}