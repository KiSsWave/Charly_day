package optimisation;

import java.util.List;
import java.util.Map;

/**
 * Classe principale qui exécute l'algorithme d'optimisation pour l'affectation des salariés aux besoins.
 * Elle charge les données depuis un fichier, applique l'algorithme génétique pour obtenir une affectation,
 * et exporte les résultats dans un fichier de sortie.
 */
public class Main {
    public static void main(String[] args) {
        // Définition du fichier problème à traiter
        String fichierProbleme = "./src/optimisation/csv_2025/etudiant/02_pb_complexes/Probleme_1_nbSalaries_10_nbClients_10_nbTaches_3.csv";

        // Charger les besoins et les compétences des salariés depuis le fichier problème
        List<Besoin> besoinsList = Optimisation.chargerBesoins(fichierProbleme);
        Map<String, Salarie> salariesDict = Optimisation.chargerCompetences(fichierProbleme);

        // Exécuter l'algorithme génétique pour optimiser l'affectation
        Map<String, Integer> affectation = Optimisation.algorithmeGenetique(besoinsList, salariesDict, 100);

        // Calculer le score de l'affectation générée
        int score = Optimisation.calculerScore(affectation, besoinsList, salariesDict);

        // Exporter les résultats de l'affectation dans un fichier
        Optimisation.exporterAffectation("./src/optimisation/resultat.csv", affectation, besoinsList, score);

        // Affichage du résultat de l'affectation et du score
        System.out.println("Affectation générée : " + affectation);
        System.out.println("Score obtenu : " + score);
    }
}
