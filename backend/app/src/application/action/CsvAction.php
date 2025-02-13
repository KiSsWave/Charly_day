<?php

namespace charly\application\action;

use charly\core\services\Csv\CsvService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsvAction extends AbstractAction
{
    private CsvService $csvService;

    public function __construct(CsvService $csvService)
    {
        $this->csvService = $csvService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            // Récupérer les fichiers téléchargés
            $uploadedFiles = $rq->getUploadedFiles();

            // Vérifier si un fichier CSV est présent dans la requête
            if (!isset($uploadedFiles['csv_file'])) {
                $rs->getBody()->write("Aucun fichier CSV trouvé dans la requête.");
                return $rs->withStatus(400); // 400 Bad Request
            }

            $csvFile = $uploadedFiles['csv_file'];

            // Vérifier que le fichier a bien été téléchargé sans erreur
            if ($csvFile->getError() !== UPLOAD_ERR_OK) {
                $rs->getBody()->write("Erreur lors du téléchargement du fichier.");
                return $rs->withStatus(500); // 500 Internal Server Error
            }

            // Lire le contenu du fichier CSV téléchargé
            $csvContent = $csvFile->getStream()->getContents();

            // Appeler ton service CsvService pour traiter le contenu du fichier CSV
            $result = $this->csvService->processCsv($csvContent);

            // Enregistrer le résultat dans un fichier sur le serveur
            $responseFilePath = __DIR__ . "/resultats/" . basename($csvFile->getClientFilename(), '.csv') . "_resultat.csv";
            file_put_contents($responseFilePath, $result);

            // Ajouter un message dans la réponse indiquant que l'optimisation est terminée
            $rs->getBody()->write("Optimisation terminée. Résultat enregistré dans '$responseFilePath'.\n");

            return $rs->withStatus(200); // 200 OK
        } catch (\Exception $e) {
            // Gérer les erreurs en cas d'exception
            $rs->getBody()->write("Erreur : " . $e->getMessage());
            return $rs->withStatus(500); // 500 Internal Server Error
        }
    }
}
