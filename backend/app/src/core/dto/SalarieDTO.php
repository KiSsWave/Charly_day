<?php

namespace charly\core\dto;

use charly\core\domain\Salarie\Salarie;
use charly\core\dto\DTO;

class SalarieDTO extends DTO
{
    protected string $ID;
    protected string $nom;

    protected array $competences;

    public function __construct(Salarie $salarie){
        $this->ID = $salarie->getID();
        $this->nom = $salarie->getNom();
        $this->competences = $salarie->getCompetences();
    }

    public function getID(){
        return $this->ID;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getCompetences(): array{
        return $this->competences;
    }
}