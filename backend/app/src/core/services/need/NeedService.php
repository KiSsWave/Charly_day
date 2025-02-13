<?php

namespace charly\core\services\need;

use charly\core\domain\Need\Need;
use charly\core\dto\NeedDTO;
use charly\core\repositoryInterfaces\NeedRepositoryInterface;

class NeedService implements NeedServiceInterface
{
    private NeedRepositoryInterface $needRepository;

    public function __construct(NeedRepositoryInterface $needRepository)
    {
        $this->needRepository = $needRepository;
    }

    public function createNeed(string $client_name, string $description, string $competence): string
    {
        $need = new Need($client_name, $description, $competence);
        return $this->needRepository->create($client_name, $description, $competence);
    }

    public function findByIdNeed(string $id): ?NeedDTO
    {
        $need = $this->needRepository->findById($id);

        if (!$need) {
            return null;
        }

        return new NeedDTO($need);
    }

    public function findByClientNameNeed(string $clientName): array
    {
        return $this->needRepository->findByClientName($clientName);

    }

    public function updateNeed(string $id, string $description, string $competence_type): NeedDTO
    {

        $this->needRepository->update($id, $description, $competence_type);


        $need = $this->needRepository->findById($id);

        if (!$need) {
            throw new \RuntimeException("Le besoin n'a pas pu être récupéré après mise à jour");
        }

        return new NeedDTO($need);
    }

    public function findAllNeeds(): array
    {
        return $this->needRepository->findAll();
    }
}