<?php

namespace charly\core\repositoryInterfaces;

use charly\core\dto\CreateSalarieDTO;

interface SalarieRepositoryInterface
{

    public function createSalarie(CreateSalarieDTO $salarie);

    public function getSalaries();

}