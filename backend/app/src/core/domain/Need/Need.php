<?php

namespace charly\core\domain\Need;

use charly\core\domain\Entity;

class Need extends Entity
{
    protected string $client_name;
    protected string $description;
    protected string $competence_type;
    protected string $status;

    public function __construct(string $client_name, string $description, string $competence_type) {
        $this->client_name = $client_name;
        $this->description = $description;
        $this->competence_type = $competence_type;
        $this->status = 'disponible';
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

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
