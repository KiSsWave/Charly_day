<?php

namespace charly\Infrastructure\http;

class CsvClient
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Envoie un fichier CSV à un serveur pour traitement.
     *
     * @param string $csvContent Le contenu du fichier CSV à envoyer.
     * @return string La réponse du serveur (CSV optimisé ou message d'erreur).
     * @throws \Exception Si une erreur survient lors de la requête HTTP ou de l'envoi du CSV.
     */
    public function sendCsv(string $csvContent): string
    {
        // Initialisation de cURL
        $ch = curl_init($this->url);

        // Définition des options cURL
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $csvContent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: text/csv",
            "Content-Length: " . strlen($csvContent)
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Exécution de la requête
        $response = curl_exec($ch);

        // Gestion des erreurs cURL
        if (curl_errno($ch)) {
            curl_close($ch);
            throw new \Exception("Erreur cURL : " . curl_error($ch));
        }

        // Vérification du code de statut HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            curl_close($ch);
            throw new \Exception("Erreur HTTP : Code $httpCode");
        }

        // Fermeture de la session cURL
        curl_close($ch);

        // Retourner la réponse du serveur (CSV optimisé ou message d'erreur)
        return $response;
    }
}