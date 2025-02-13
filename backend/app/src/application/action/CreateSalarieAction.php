<?php

namespace charly\application\action;

use charly\application\action\AbstractAction;
use charly\core\services\Salaries\SalarieServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateSalarieAction extends AbstractAction
{

    private SalarieServiceInterface $salarieService;

    public function __construct(SalarieServiceInterface $salarieService){
        $this->salarieService = $salarieService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        try {
            $body = $rq->getParsedBody();
            $nom = $body['nom'];
            $competence = $body['competences'];
            $this->salarieService->createSalarie($nom, $competence);

            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        }catch (\Exception $e){
            $rs->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

    }
}