<?php

namespace charly\application\action;

use charly\core\dto\NeedDTO;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use charly\core\services\need\NeedServiceInterface;
use Slim\Exception\HttpBadRequestException;

class CreateNeedAction extends AbstractAction
{
    private NeedServiceInterface $needService;

    public function __construct(NeedServiceInterface $needService)
    {
        $this->needService = $needService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $client_name = $data['client_name'] ?? null;
        $description = $data['description'] ?? null;
        $competence_type = $data['competence_type'] ?? null;

        if (!$client_name || !$description || !$competence_type) {
            throw new HttpBadRequestException($rq, "Données manquantes");
        }

        try {
            $id = $this->needService->createNeed($client_name, $description, $competence_type);

            $rs->getBody()->write(json_encode([
                'need_id' => $id
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch(Exception $e) {
            $rs->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}