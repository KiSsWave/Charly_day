package optimisation;

import com.sun.net.httpserver.HttpServer;
import java.io.*;
import java.net.InetSocketAddress;

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
