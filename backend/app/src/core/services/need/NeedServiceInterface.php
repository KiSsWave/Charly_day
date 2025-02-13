<?php

namespace charly\core\services\need;

use charly\core\dto\NeedDTO;

interface NeedServiceInterface
{

    public function createNeed(string $client_name, string $description, string $competence): string;

    public function findByIdNeed(string $id): ?NeedDTO;

    public function findByClientNameNeed(string $clientName): array;

    public function updateNeed(string $id, string $description, string $competence_type): NeedDTO;
}