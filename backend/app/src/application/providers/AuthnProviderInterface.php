<?php

namespace charly\application\providers;


use DateTime;
use charly\core\dto\UserDTO;
use charly\core\dto\CredentialDTO;
use PhpParser\Token;

interface AuthnProviderInterface
{
    public function register(CredentialDTO $c,string $login,int $role);
    public function signin(CredentialDTO $c): UserDTO;
    public function refresh(Token $token): UserDTO;
    public function getSignedInUser(string $token): UserDTO;
}