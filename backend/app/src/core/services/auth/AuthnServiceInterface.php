<?php

namespace charly\core\services\auth;

use charly\core\dto\CredentialDTO;
use charly\core\dto\UserDTO;

interface AuthnServiceInterface
{
    public function createUser(CredentialDTO $c,string $login,int $role);

    public function byCredentials(CredentialDTO $c): UserDTO;


}