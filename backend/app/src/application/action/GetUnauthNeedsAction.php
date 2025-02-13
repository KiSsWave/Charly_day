<?php


namespace charly\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetUnauthNeedsAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $needs = $_SESSION['anonymous_needs'] ?? [];

        $rs->getBody()->write(json_encode([
            'needs' => $needs
        ]));
        return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}