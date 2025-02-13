<?php

namespace charly\core\services\Csv;

use charly\core\repositoryInterfaces\CsvRepositoryInterface;
use charly\Infrastructure\http\CsvClient;

class CsvService
{
    private CsvRepositoryInterface $csvRepository;
    private CsvClient $csvClient;

    public function __construct(CsvRepositoryInterface $csvRepository, CsvClient $csvClient)
    {
        $this->csvRepository = $csvRepository;
        $this->csvClient = $csvClient;
    }

    /**
     * Cette méthode lit les fichiers CSV via le repository, les envoie au serveur Java pour traitement
     * et renvoie la réponse du serveur Java (qui est le CSV optimisé).
     *
     * @return string Le contenu du fichier CSV optimisé renvoyé par le serveur Java.
     * @throws \Exception
     */
    public function processCsv(): string
    {
        $csvData = $this->csvRepository->getCsvContent();

        if (!$csvData) {
            throw new \Exception("Aucun contenu CSV trouvé.");
        }

        try {
            $response = $this->csvClient->sendCsv($csvData->getContent());
            return $response;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'envoi du CSV au serveur Java : " . $e->getMessage());
        }
    }
}