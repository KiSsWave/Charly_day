<?php

namespace charly\core\services\Salaries;

use charly\core\domain\Salarie\Salarie;
use charly\core\dto\CreateSalarieDTO;
use charly\core\dto\SalarieDTO;
use charly\core\repositoryInterfaces\SalarieRepositoryInterface;
use charly\core\services\Salaries\SalarieServiceInterface;

class SalarieService implements SalarieServiceInterface
{

    private SalarieRepositoryInterface $repository;

    public function __construct(SalarieRepositoryInterface $repository){
        $this->repository = $repository;
    }


    public function createSalarie(string $nom, array $competences)
    {
        $salarieDTO = new CreateSalarieDTO($nom, $competences);
        $this->repository->createSalarie($salarieDTO);
    }

    public function getSalaries()
    {
        $salaries = $this->repository->getSalaries();
        $salariesDTO = [];
        foreach ($salaries as $salarie) {
            $salariesDTO[] = new SalarieDTO($salarie);
        }
        return $salariesDTO;
    }
}