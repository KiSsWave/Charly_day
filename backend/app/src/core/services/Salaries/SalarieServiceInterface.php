<?php

namespace charly\core\services\Salaries;

interface SalarieServiceInterface
{

    public function createSalarie(string $nom, array $competences);
    public function getSalaries();

}