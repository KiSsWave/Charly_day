<?php

namespace charly\core\services\Salaries;

interface SalarieServiceInterface
{

    public function createSalarie(string $nom, array $competences);
    public function getSalaries();

    public function addCompetence(string $nom);

    public function deleteCompetence(string $id);

    public function modifCompetence(string $id, string $nom);

}