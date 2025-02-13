<?php

namespace charly\application\action;

use charly\application\action\AbstractAction;
use charly\application\providers\AuthnProviderInterface;
use charly\core\dto\CredentialDTO;
use charly\core\services\auth\AuthServiceBadDataException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class SignInAction extends AbstractAction
{
    private AuthnProviderInterface $authnProvider;

    public function __construct(AuthnProviderInterface $authnProvider){
        $this->authnProvider = $authnProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;


        try {
            $user = $this->authnProvider->signin(new CredentialDTO($email, $password));
            $token = $user->getToken();
        }catch(AuthServiceBadDataException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        $rs->getBody()->write(json_encode([
            'token' => $token,
            'role' => $user->getRole()
        ]));

        return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}