package optimisation;

import com.sun.net.httpserver.HttpServer;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpExchange;
import java.io.*;
import java.net.InetSocketAddress;
import java.util.List;
import java.util.Map;

public class Main {
    public static void main(String[] args) throws IOException {
        // Créer un serveur HTTP écoutant sur le port 8080
        HttpServer server = HttpServer.create(new InetSocketAddress(8080), 0);

        // Créer un handler pour la route /optimisation
        server.createContext("/optimisation", new OptimisationHandler());

        // Démarrer le serveur
        server.start();
        System.out.println("Serveur démarré sur http://localhost:8080");
    }
}

class OptimisationHandler implements HttpHandler {
    @Override
    public void handle(HttpExchange exchange) throws IOException {
        // Vérifier que la méthode de la requête est POST
        if ("POST".equals(exchange.getRequestMethod())) {
            // Lire le corps de la requête (fichier CSV)
            InputStream requestBody = exchange.getRequestBody();
            File inputFile = new File("temp_input.csv");
            try (FileOutputStream fileOutputStream = new FileOutputStream(inputFile)) {
                requestBody.transferTo(fileOutputStream);
            }

            // Définir le chemin du fichier problème à partir du fichier reçu
            List<Besoin> besoinsList = Optimisation.chargerBesoins(inputFile.getAbsolutePath());
            Map<String, Salarie> salariesDict = Optimisation.chargerCompetences(inputFile.getAbsolutePath());

            // Exécuter l'algorithme génétique pour optimiser l'affectation
            Map<String, Integer> affectation = Optimisation.algorithmeGenetique(besoinsList, salariesDict, 100);

            // Calculer le score de l'affectation générée
            int score = Optimisation.calculerScore(affectation, besoinsList, salariesDict);

            // Exporter les résultats dans un fichier CSV de sortie
            File outputFile = new File("resultat_optimisation.csv");
            Optimisation.exporterAffectation(outputFile.getAbsolutePath(), affectation, besoinsList, score);

            // Préparer la réponse avec le fichier de sortie
            exchange.getResponseHeaders().set("Content-Type", "text/csv");
            exchange.getResponseHeaders().set("Content-Disposition", "attachment; filename=resultat_optimisation.csv");
            exchange.sendResponseHeaders(200, outputFile.length());

            // Envoyer le contenu du fichier de sortie en réponse
            try (OutputStream responseBody = exchange.getResponseBody();
                 FileInputStream fileInputStream = new FileInputStream(outputFile)) {
                fileInputStream.transferTo(responseBody);
            }

            // Supprimer les fichiers temporaires
            inputFile.delete();
            outputFile.delete();
        } else {
            // Si ce n'est pas une méthode POST, renvoyer une erreur 405 (Method Not Allowed)
            exchange.sendResponseHeaders(405, -1);
        }
    }
}
