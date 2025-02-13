<?php

namespace charly\infrastructure\repositories;

use charly\core\domain\Salarie\Competence;
use charly\core\domain\Salarie\Salarie;
use charly\core\dto\CompetenceDTO;
use charly\core\dto\CreateSalarieDTO;
use charly\core\repositoryInterfaces\SalarieRepositoryInterface;
use Exception;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

class SalarieRepository implements SalarieRepositoryInterface
{

    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }


    public function createSalarie(CreateSalarieDTO $salarieDTO)
    {
        $salarie = new Salarie($salarieDTO->getNom(), $salarieDTO->getCompetences());
        $salarie->setID(Uuid::uuid4()->toString());
        $insert = $this->pdo->prepare('INSERT INTO Salaries(id,nom) VALUES (:id,:nom)');
        $insert->execute([
            'id' => $salarie->getID(),
            'nom' => $salarie->getNom()
        ]);

        if (!empty($salarieDTO->getCompetences())) {
            $insertCompetence = $this->pdo->prepare('
            INSERT INTO salarie_competence (salarie_id, competence_id, note) 
            VALUES (:salarie_id, :competence_id, :note)
        ');

            foreach ($salarieDTO->getCompetences() as $competence) {
                $check = $this->pdo->prepare('SELECT id FROM competences WHERE nom = :nom');
                $check->execute(['nom' => $competence['nom']]);
                $competenceID = $check->fetchColumn();

                if(!$competenceID) {
                    $this->addCompetence($competence['nom']);
                }

                $insertCompetence->execute([
                    'salarie_id' => $salarie->getID(),
                    'competence_id' => $competence['id'],
                    'note' => $competence['note']
                ]);

            }
        }
    }

    public function getSalaries()
    {
        try{
            $query = $this->pdo->query("SELECT * FROM Salaries");
            $salariesData = $query->fetchAll(PDO::FETCH_ASSOC);

            $salaries = [];

            foreach ($salariesData as $salarieData) {
                $stmt = $this->pdo->prepare("
                SELECT c.id, c.nom, sc.note 
                FROM salarie_competence sc
                JOIN competences c ON sc.competence_id = c.id
                WHERE sc.salarie_id = :salarie_id
            ");
                $stmt->execute(['salarie_id' => $salarieData['id']]);
                $competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $salarie = new Salarie($salarieData['nom'], $competences);
                $salarie->setID($salarieData['id']);
                $salaries[] = $salarie;
            }

            return $salaries;
        }catch (PDOException $e){
            throw new Exception($e->getMessage());
        }
    }

    public function addCompetence(string $nom)
    {
        $stmt = $this->pdo->prepare("INSERT INTO competences (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $nom]);    }

    public function deleteCompetence(string $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM competences WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function modifCompetence(CompetenceDTO $competence)
    {
        $stmt = $this->pdo->prepare("UPDATE competences SET nom = :nom WHERE id = :id");
        $stmt->execute(['nom' => $competence->getNom(), 'id' => $competence->getId()]);
    }
}