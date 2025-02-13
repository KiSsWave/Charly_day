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
        $needs = $this->needRepository->findByClientName($clientName);

        return array_map(function(Need $need) {
            return new NeedDTO($need);
        }, $needs);
    }
}