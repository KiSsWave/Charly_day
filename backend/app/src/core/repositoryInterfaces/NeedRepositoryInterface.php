<?php


namespace charly\core\repositoryInterfaces;
use charly\core\domain\Need\Need;
use charly\core\dto\NeedDTO;


interface NeedRepositoryInterface
{
    public function create(string $client_name, string $description, string $competence_type): string;

    public function findById(string $id): ?Need;

    public function findByClientName(string $clientName): array;





}
