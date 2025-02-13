<?php

namespace charly\core\dto;

use charly\core\dto\DTO;

class CompetenceDTO extends DTO
{

    protected string $id;

    protected string $nom;

    public function __construct($id, $nom){
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

}