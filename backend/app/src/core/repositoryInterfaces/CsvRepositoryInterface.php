<?php

namespace charly\core\repositoryInterfaces;

use charly\core\domain\CSV\CsvEntities;

interface CsvRepositoryInterface
{
    public function getCsvContent(): CsvEntities;
}