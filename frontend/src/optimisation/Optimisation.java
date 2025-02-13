package optimisation;

import java.io.*;
import java.util.*;

public class Optimisation {
    public static List<Besoin> chargerBesoins(String fichier) {
        List<Besoin> besoins = new ArrayList<>();
        try (BufferedReader br = new BufferedReader(new FileReader(fichier))) {
            String line;
            boolean lireBesoins = false;

            while ((line = br.readLine()) != null) {
                if (line.contains("besoins")) {
                    lireBesoins = true;
                    continue;
                }
                if (line.isEmpty()) break; // Ligne vide = fin des besoins

                if (lireBesoins) {
                    String[] parts = line.split(";");
                    if (parts.length < 3) continue;
                    besoins.add(new Besoin(Integer.parseInt(parts[0]), parts[1], parts[2]));
                }
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
            boolean lireCompetences = false;

            while ((line = br.readLine()) != null) {
                if (line.contains("competences")) {
                    lireCompetences = true;
                    continue;
                }
                if (!lireCompetences) continue;

                String[] parts = line.split(";");
                if (parts.length < 4) continue;
                String nom = parts[1];
                String competence = parts[2];
                int interet = Integer.parseInt(parts[3]);

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
        Map<String, Integer> clientBesoinsCount = new HashMap<>();
        Set<String> salariesAffectes = new HashSet<>();
        Set<String> clientsServis = new HashSet<>();

        for (Map.Entry<String, Integer> entry : affectation.entrySet()) {
            String salarie = entry.getKey();
            int idBesoin = entry.getValue();

            Besoin besoin = besoins.stream().filter(b -> b.id == idBesoin).findFirst().orElse(null);
            if (besoin != null) {
                int interet = salaries.get(salarie).competences.getOrDefault(besoin.type, 0);
                int malus = clientBesoinsCount.getOrDefault(besoin.client, 0);
                score += Math.max(1, interet - malus);

                clientBesoinsCount.put(besoin.client, malus + 1);
                clientsServis.add(besoin.client);
                salariesAffectes.add(salarie);
            }
        }

        // Appliquer les malus après l'affectation
        for (String client : clientBesoinsCount.keySet()) {
            if (!clientsServis.contains(client)) {
                score -= 10;
            }
        }

        for (String salarie : salaries.keySet()) {
            if (!salariesAffectes.contains(salarie)) {
                score -= 10;
            }
        }

        return score;
    }



    public static void exporterAffectation(String fichier, Map<String, Integer> affectation, List<Besoin> besoins, int score) {
        try (BufferedWriter writer = new BufferedWriter(new FileWriter(fichier))) {
            writer.write(score + "\n"); // Première ligne avec le score
            for (Map.Entry<String, Integer> entry : affectation.entrySet()) {
                String salarie = entry.getKey();
                int idBesoin = entry.getValue();
                Besoin besoin = besoins.stream().filter(b -> b.id == idBesoin).findFirst().orElse(null);
                if (besoin != null) {
                    writer.write(salarie + ";" + besoin.type + ";" + besoin.client + "\n");
                }
            }
            System.out.println("Résultat exporté dans : " + fichier);
        } catch (IOException e) {
            e.printStackTrace();
        }
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

        for (Besoin besoin : besoins) {
            String meilleurSalarie = null;
            int meilleurInteret = -1;

            for (String salarie : salariesDispo) {
                if (salaries.get(salarie).competences.containsKey(besoin.type)) {
                    int interet = salaries.get(salarie).competences.get(besoin.type);
                    if (interet > meilleurInteret) {
                        meilleurInteret = interet;
                        meilleurSalarie = salarie;
                    }
                }
            }

            if (meilleurSalarie != null) {
                affectation.put(meilleurSalarie, besoin.id);
                salariesDispo.remove(meilleurSalarie); // Un salarié ne peut être affecté qu'à un besoin
            }
        }
        return affectation;
    }

}
