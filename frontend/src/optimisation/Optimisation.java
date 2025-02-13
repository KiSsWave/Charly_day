package optimisation;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.*;

public class Optimisation {
    public static List<Besoin> chargerBesoins(String fichier) {
        List<Besoin> besoins = new ArrayList<>();
        try (BufferedReader br = new BufferedReader(new FileReader(fichier))) {
            String line;
            while ((line = br.readLine()) != null) {
                String[] parts = line.split(";");
                besoins.add(new Besoin(Integer.parseInt(parts[0]), parts[1], parts[2]));
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return besoins;
    }

    public static Map<String, Salarie> chargerCompetences(String fichier) {
        Map<String, Salarie> salaries = new HashMap<>();
        try (BufferedReader br = new BufferedReader(new FileReader(fichier))) {
            String line;
            while ((line = br.readLine()) != null) {
                String[] parts = line.split(";");
                String nom = parts[0];
                String competence = parts[1];
                int interet = Integer.parseInt(parts[2]);

                salaries.putIfAbsent(nom, new Salarie(nom));
                salaries.get(nom).ajouterCompetence(competence, interet);
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return salaries;
    }

    public static int calculerScore(Map<String, Integer> affectation, List<Besoin> besoins, Map<String, Salarie> salaries) {
        int score = 0;
        for (Map.Entry<String, Integer> entry : affectation.entrySet()) {
            String salarie = entry.getKey();
            int idBesoin = entry.getValue();

            Besoin besoin = besoins.stream().filter(b -> b.id == idBesoin).findFirst().orElse(null);
            if (besoin != null && salaries.get(salarie).competences.containsKey(besoin.type)) {
                score += salaries.get(salarie).competences.get(besoin.type);
            }
        }
        return score;
    }

    public static Map<String, Integer> algorithmeGenetique(List<Besoin> besoins, Map<String, Salarie> salaries, int generations, int populationSize) {
        Map<String, Integer> meilleureAffectation = new HashMap<>();
        int meilleurScore = Integer.MIN_VALUE;

        for (int i = 0; i < generations; i++) {
            Map<String, Integer> affectation = genererAffectation(besoins, salaries);
            int score = calculerScore(affectation, besoins, salaries);

            if (score > meilleurScore) {
                meilleurScore = score;
                meilleureAffectation = new HashMap<>(affectation);
            }
        }
        return meilleureAffectation;
    }

    private static Map<String, Integer> genererAffectation(List<Besoin> besoins, Map<String, Salarie> salaries) {
        Map<String, Integer> affectation = new HashMap<>();
        List<String> salariesDispo = new ArrayList<>(salaries.keySet());
        Collections.shuffle(salariesDispo);

        for (Besoin besoin : besoins) {
            for (String salarie : salariesDispo) {
                if (salaries.get(salarie).competences.containsKey(besoin.type)) {
                    affectation.put(salarie, besoin.id);
                    salariesDispo.remove(salarie);
                    break;
                }
            }
        }
        return affectation;
    }
}
