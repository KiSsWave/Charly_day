<?php

namespace charly\application\action;

use charly\application\action\AbstractAction;
use charly\core\services\Salaries\SalarieServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSalariesAction extends AbstractAction
{
    private SalarieServiceInterface $salarie;

    public function __construct(SalarieServiceInterface $salarie){
        $this->salarie = $salarie;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $salaries = $this->salarie->getSalaries();
            $resultat["Salaries"]  = [];
            foreach ($salaries as $salary) {
                $resultat["Salaries"][] = [
                    'Id' => $salary->ID,
                    'Nom' => $salary->nom,
                    'Competence' => $salary->competences,
                ];
            }
            $rs->getBody()->write(json_encode($resultat));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

        }catch (\Exception $e){
            $rs->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}