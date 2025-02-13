<?php

namespace charly\application\action;

use charly\application\action\AbstractAction;
use charly\core\services\Salaries\SalarieServiceInterface;
use PHPUnit\Framework\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ManageCompetenceAction extends AbstractAction
{

    private SalarieServiceInterface $salarie;

    public function __construct(SalarieServiceInterface $salarie){
        $this->salarie = $salarie;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $body = $rq->getParsedBody();
            if(!isset($body['action'])){
                throw new Exception("Action non specifiee");
            }

            switch ($body['action']) {
                case 'add':
                    if (!isset($body['nom'])) {
                        throw new Exception("Nom de la compétence requis.");
                    }
                    $this->salarie->addCompetence($body['nom']);
                    break;
                case 'delete':
                    if (!isset($body['id'])) {
                        throw new Exception("ID de la compétence requis.");
                    }
                    $this->salarie->deleteCompetence($body['id']);
                    break;
                case 'update':
                    if (!isset($body['id']) && !isset($body['nom'])) {
                        throw new Exception("ID et nom de la compétence requis.");
                    }

                    $this->salarie->modifCompetence($body['id'], $body['nom']);
                    break;

                default:
                    throw new Exception("Action invalide.");
            }

            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

        }catch (Exception $e){
            $rs->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}