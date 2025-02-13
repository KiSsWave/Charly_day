package optimisation;

import java.util.List;
import java.util.Map;

public class Main {
    public static void main(String[] args) {
        String fichierProbleme = "./src/optimisation/csv_2025/etudiant/02_pb_complexes/Probleme_1_nbSalaries_10_nbClients_10_nbTaches_3.csv";
        String fichierSortie = "./src/optimisation/csv_2025/etudiant/02_pb_complexes/Probleme_1_nbSalaries_10_nbClients_10_nbTaches_3_Sol.csv";

        // Charger besoins et compétences depuis un seul fichier
        List<Besoin> besoinsList = Optimisation.chargerBesoins(fichierProbleme);
        Map<String, Salarie> salariesDict = Optimisation.chargerCompetences(fichierProbleme);

        // Exécuter l'algorithme d'optimisation
        Map<String, Integer> affectation = Optimisation.algorithmeGenetique(besoinsList, salariesDict, 100, 30);
        int score = Optimisation.calculerScore(affectation, besoinsList, salariesDict);

        // Affichage et sauvegarde
        System.out.println("Affectation générée : " + affectation);
        System.out.println("Score obtenu : " + score);
        Optimisation.exporterAffectation(fichierSortie, affectation, besoinsList, score);
    }
}
