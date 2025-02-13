<?php

namespace charly\application\action;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use charly\core\services\need\NeedServiceInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class UpdateNeedAction extends AbstractAction
{
    private NeedServiceInterface $needService;

    public function __construct(NeedServiceInterface $needService)
    {
        $this->needService = $needService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user = $rq->getAttribute('user');
        if (!$user) {
            throw new HttpBadRequestException($rq, "Utilisateur non authentifié");
        }
        $needId = $args['id'];
        $data = $rq->getParsedBody();
        $description = $data['description'] ?? null;
        $competence_type = $data['competence_type'] ?? null;

        if (!$description || !$competence_type) {
            throw new HttpBadRequestException($rq, "Description et type de compétence requis");
        }

        try {
            $updatedNeed = $this->needService->updateNeed($needId, $description, $competence_type);

            $rs->getBody()->write(json_encode([
                'message' => 'Besoin mis à jour avec succès',
                'need' => $updatedNeed
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
