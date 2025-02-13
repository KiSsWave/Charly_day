<?php

namespace charly\application\action;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Ramsey\Uuid\Uuid;

class CreateUnauthNeedAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $client_name = $data['client_name'] ?? null;
        $description = $data['description'] ?? null;
        $competence_type = $data['competence_type'] ?? null;

        if (!$client_name || !$description || !$competence_type) {
            throw new HttpBadRequestException($rq, "Données manquantes - nom du client, description et type de compétence requis");
        }

        try {
            $id = Uuid::uuid4()->toString();

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['anonymous_needs'])) {
                $_SESSION['anonymous_needs'] = [];
            }

            $_SESSION['anonymous_needs'][] = [
                'id' => $id,
                'client_name' => $client_name,
                'description' => $description,
                'competence_type' => $competence_type,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'disponible'
            ];

            $rs->getBody()->write(json_encode([
                'need_id' => $id,
                'message' => 'Besoin stocké en session'
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