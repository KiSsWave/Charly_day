<?php

namespace charly\application\action;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use charly\core\services\need\NeedServiceInterface;
use Slim\Exception\HttpBadRequestException;

class GetAllNeedsAction extends AbstractAction
{
    private NeedServiceInterface $needService;

    public function __construct(NeedServiceInterface $needService)
    {
        $this->needService = $needService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $needs = $this->needService->findAllNeeds();

            $rs->getBody()->write(json_encode([
                'needs' => $needs
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

        } catch(Exception $e) {
            $rs->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}