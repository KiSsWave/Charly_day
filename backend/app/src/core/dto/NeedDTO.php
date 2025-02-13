<?php

namespace charly\core\dto;
use charly\core\domain\Need\Need;

class NeedDTO extends DTO {
    public string $client_name;
    public string $description;
    public string $competence_type;
    public string $status;

    public function __construct(Need $need) {
        $this->client_name = $need->getClientName();
        $this->description = $need->getDescription();
        $this->competence_type = $need->getCompetenceType();
        $this->status = $need->getStatus();
    }

    public function getClientName(): string {
        return $this->client_name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCompetenceType(): string {
        return $this->competence_type;
    }

    public function getStatus(): string {
        return $this->status;
    }

}