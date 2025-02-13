package optimisation;

import java.util.List;
import java.util.Map;

public class Main {
    public static void main(String[] args) {
        String fichierBesoins = "besoins.csv";
        String fichierCompetences = "competences.csv";

        List<Besoin> besoinsList = Optimisation.chargerBesoins(fichierBesoins);
        Map<String, Salarie> salariesDict = Optimisation.chargerCompetences(fichierCompetences);

        Map<String, Integer> affectation = Optimisation.algorithmeGenetique(besoinsList, salariesDict, 100, 30);
        int score = Optimisation.calculerScore(affectation, besoinsList, salariesDict);

        System.out.println("Affectation générée : " + affectation);
        System.out.println("Score obtenu : " + score);
    }
}
