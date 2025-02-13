<?php

namespace charly\core\repositoryInterfaces;

use charly\core\domain\Salarie\Competence;
use charly\core\dto\CompetenceDTO;
use charly\core\dto\CreateSalarieDTO;

interface SalarieRepositoryInterface
{

    public function createSalarie(CreateSalarieDTO $salarie);

    public function getSalaries();

    public function addCompetence(string $nom);

    public function deleteCompetence(string $id);

    public function modifCompetence(CompetenceDTO $competence);

}