package optimisation;

import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.nio.charset.StandardCharsets;
import java.util.List;
import java.util.Map;

public class OptimisationHandler implements HttpHandler {
    @Override
    public void handle(HttpExchange exchange) throws IOException {
        // Vérifier que la méthode de la requête est POST
        if ("POST".equals(exchange.getRequestMethod())) {
            // Lire le corps de la requête (contenu CSV sous forme de String)
            InputStream requestBody = exchange.getRequestBody();
            String csvContent = new String(requestBody.readAllBytes(), StandardCharsets.UTF_8);

            // Traiter le CSV en mémoire sans créer de fichier temporaire
            List<Besoin> besoinsList = Optimisation.chargerBesoins(csvContent);
            Map<String, Salarie> salariesDict = Optimisation.chargerCompetences(csvContent);

            // Exécuter l'algorithme génétique pour optimiser l'affectation
            Map<String, Integer> affectation = Optimisation.algorithmeGenetique(besoinsList, salariesDict, 100);

            // Calculer le score de l'affectation générée
            int score = Optimisation.calculerScore(affectation, besoinsList, salariesDict);

            // Générer la réponse sous forme de String CSV
            String resultatCsv = Optimisation.exporterAffectation(affectation, besoinsList, score);

            // Préparer la réponse HTTP
            exchange.getResponseHeaders().set("Content-Type", "text/csv; charset=UTF-8");
            exchange.sendResponseHeaders(200, resultatCsv.getBytes(StandardCharsets.UTF_8).length);

            // Envoyer le contenu du CSV généré en réponse
            try (OutputStream responseBody = exchange.getResponseBody()) {
                responseBody.write(resultatCsv.getBytes(StandardCharsets.UTF_8));
            }
        } else {
            // Si ce n'est pas une méthode POST, renvoyer une erreur 405 (Method Not Allowed)
            exchange.sendResponseHeaders(405, -1);
        }
    }
}
