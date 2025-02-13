<?php

namespace charly\infrastructure\repositories;

use charly\core\domain\Need\Need;
use charly\core\dto\NeedDTO;
use charly\core\repositoryInterfaces\NeedRepositoryInterface;
use PDO;
use Ramsey\Uuid\Uuid;

class NeedRepository implements NeedRepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(string $client_name, string $description, string $competence_type): string {
        $id = Uuid::uuid4()->toString();
        $need = new Need($client_name, $description, $competence_type);

        $stmt = $this->pdo->prepare('
            INSERT INTO needs (id, client_name, description, competence_type, status)
            VALUES (:id, :client_name, :description, :competence_type, :status)
        ');

        $stmt->execute([
            'id' => $id,
            'client_name' => $need->getClientName(),
            'description' => $need->getDescription(),
            'competence_type' => $need->getCompetenceType(),
            'status' => $need->getStatus()
        ]);

        return $id;
    }

    public function findById(string $id): ?Need {
        $stmt = $this->pdo->prepare('SELECT * FROM needs WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $need = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$need) return null;

        $serviceNeed = new Need(
            $need['client_name'],
            $need['description'],
            $need['competence_type']
        );
        $serviceNeed->setStatus($need['status']);

        return $serviceNeed;
    }

    public function findByClientName(string $clientName): array {
        $stmt = $this->pdo->prepare('SELECT * FROM needs WHERE client_name = :client_name');
        $stmt->execute(['client_name' => $clientName]);
        $needs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($need) {
            $serviceNeed = new Need(
                $need['client_name'],
                $need['description'],
                $need['competence_type']
            );
            $serviceNeed->setStatus($need['status']);
            return $serviceNeed;
        }, $needs);

    }
}