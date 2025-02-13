<?php

namespace charly\Infrastructure\repositories;

use charly\core\domain\CSV\CsvEntities;
use charly\core\repositoryInterfaces\CsvRepositoryInterface;

class CsvRepository implements CsvRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Cette méthode récupère le contenu du CSV à partir du fichier ou du répertoire spécifié.
     * Si un répertoire est spécifié, elle lira tous les fichiers CSV à l'intérieur.
     *
     * @return CsvEntities
     * @throws \Exception Si le fichier ou le répertoire n'existe pas ou ne peut pas être lu.
     */
    public function getCsvContent(): CsvEntities
    {
        // Vérifier si le fichier spécifié est un fichier ou un répertoire
        if (is_file($this->filePath)) {
            return $this->getSingleCsvContent();
        } elseif (is_dir($this->filePath)) {
            return $this->getMultipleCsvContent();
        } else {
            throw new \Exception("Le chemin spécifié n'est ni un fichier ni un répertoire valide !");
        }
    }

    /**
     * Récupère le contenu d'un seul fichier CSV.
     *
     * @return CsvEntities
     * @throws \Exception Si le fichier n'existe pas ou est inaccessible.
     */
    private function getSingleCsvContent(): CsvEntities
    {
        if (!file_exists($this->filePath)) {
            throw new \Exception("Le fichier CSV n'existe pas !");
        }

        $content = @file_get_contents($this->filePath);

        if ($content === false) {
            throw new \Exception("Erreur lors de la lecture du fichier CSV.");
        }

        return new CsvEntities($content);
    }

    /**
     * Récupère le contenu de tous les fichiers CSV dans un répertoire.
     *
     * @return CsvEntities
     * @throws \Exception Si un fichier CSV est introuvable ou illisible.
     */
    private function getMultipleCsvContent(): CsvEntities
    {
        // Obtenir tous les fichiers CSV du répertoire
        $csvFiles = glob($this->filePath . DIRECTORY_SEPARATOR . '*.csv');

        if (empty($csvFiles)) {
            throw new \Exception("Aucun fichier CSV trouvé dans le répertoire.");
        }

        // Lire le contenu de chaque fichier CSV et les combiner
        $combinedContent = '';
        foreach ($csvFiles as $file) {
            $content = @file_get_contents($file);

            if ($content === false) {
                throw new \Exception("Erreur lors de la lecture du fichier CSV : $file");
            }

            $combinedContent .= $content . "\n"; // Ajout du contenu de chaque fichier
        }

        return new CsvEntities($combinedContent);
    }
}
