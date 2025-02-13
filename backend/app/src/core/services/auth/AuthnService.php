<?php

namespace charly\core\services\auth;

use charly\core\domain\User\User;
use charly\core\dto\CredentialDTO;
use charly\core\dto\UserDTO;
use charly\core\repositoryInterfaces\UserRepositoryInterface;
use charly\core\services\auth\AuthnServiceInterface;
use Ramsey\Uuid\Uuid;

class AuthnService implements AuthnServiceInterface
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[\Override] public function createUser(CredentialDTO $c, string $login, int $role): string
    {
        $user = new User($c->getEmail(),$login, $role);
        $user->setID(Uuid::uuid4()->toString());
        $user->setPassword(password_hash($c->getPassword(), PASSWORD_DEFAULT));
        return $this->userRepository->save($user);
    }

    #[\Override] public function byCredentials(CredentialDTO $c): UserDTO
    {
        $user = $this->userRepository->getUserByEmail($c->getEmail());

        if ($user && password_verify($c->getPassword(), $user->getPassword())) {
            return new UserDTO($user);
        } else {
            throw new AuthServiceBadDataException('Erreur 400 : Email ou mot de passe incorrect', 400);
        }
    }
}