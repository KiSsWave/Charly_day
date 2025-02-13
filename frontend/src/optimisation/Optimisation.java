package optimisation;

import java.io.*;
import java.util.*;

/**
 * Classe d'optimisation pour l'affectation des salariés aux besoins.
 * Cette classe gère le chargement des données, le calcul des scores, l'export des résultats
 * et l'application d'un algorithme génétique pour maximiser la performance de l'affectation.
 */
public class Optimisation {

    /**
     * Charge les besoins depuis un fichier texte et les stocke dans une liste.
     * Le fichier doit être au format suivant :
     * [id; client; type]
     *
     * @param fichier Le chemin vers le fichier contenant les besoins.
     * @return Une liste de besoins chargée depuis le fichier.
     */
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

    /**
     * Charge les compétences des salariés depuis un fichier texte et les stocke dans une map.
     * Le fichier doit être au format suivant :
     * [id; nom; competence; interet]
     *
     * @param fichier Le chemin vers le fichier contenant les compétences des salariés.
     * @return Une map avec le nom du salarié comme clé et l'objet Salarie comme valeur.
     */
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

    /**
     * Calcule un score pour une affectation donnée, en prenant en compte l'intérêt des salariés
     * pour les besoins et en appliquant des malus pour les clients non servis ou les salariés non affectés.
     *
     * @param affectation Une map représentant l'affectation des salariés aux besoins.
     * @param besoins Une liste des besoins.
     * @param salaries Une map des salariés avec leurs compétences.
     * @return Le score calculé pour cette affectation.
     */
    public static int calculerScore(Map<String, Integer> affectation, List<Besoin> besoins, Map<String, Salarie> salaries) {
        int score = 0;
        Map<String, Integer> clientBesoinsCount = new HashMap<>();
        Set<String> salariesAffectes = new HashSet<>();
        Set<String> clientsServis = new HashSet<>();

        for (Map.Entry<String, Integer> entry : affectation.entrySet()) {
            String salarie = entry.getKey();
            int idBesoin = entry.getValue();

            Besoin besoin = besoins.stream().filter(b -> b.getId() == idBesoin).findFirst().orElse(null);
            if (besoin != null) {
                int interet = salaries.get(salarie).getCompetences().getOrDefault(besoin.getType(), 0);
                int malus = clientBesoinsCount.getOrDefault(besoin.getClient(), 0);
                score += Math.max(1, interet - malus);

                clientBesoinsCount.put(besoin.getClient(), malus + 1);
                clientsServis.add(besoin.getClient());
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

    /**
     * Exporte l'affectation des salariés aux besoins dans un fichier texte.
     * Le fichier contient le score total en première ligne, puis les affectations ligne par ligne.
     *
     * @param fichier Le chemin vers le fichier de sortie.
     * @param affectation Une map représentant l'affectation des salariés aux besoins.
     * @param besoins Une liste des besoins.
     * @param score Le score calculé pour cette affectation.
     */
    public static void exporterAffectation(String fichier, Map<String, Integer> affectation, List<Besoin> besoins, int score) {
        try (BufferedWriter writer = new BufferedWriter(new FileWriter(fichier))) {
            writer.write(score + "\n"); // Première ligne avec le score
            for (Map.Entry<String, Integer> entry : affectation.entrySet()) {
                String salarie = entry.getKey();
                int idBesoin = entry.getValue();
                Besoin besoin = besoins.stream().filter(b -> b.getId() == idBesoin).findFirst().orElse(null);
                if (besoin != null) {
                    writer.write(salarie + ";" + besoin.getType() + ";" + besoin.getClient() + "\n");
                }
            }
            System.out.println("Résultat exporté dans : " + fichier);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    /**
     * Applique un algorithme génétique pour trouver la meilleure affectation possible en un certain nombre de générations.
     *
     * @param besoins La liste des besoins.
     * @param salaries La map des salariés avec leurs compétences.
     * @param generations Le nombre de générations à simuler.
     * @return La meilleure affectation trouvée pendant les générations.
     */
    public static Map<String, Integer> algorithmeGenetique(List<Besoin> besoins, Map<String, Salarie> salaries, int generations) {
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

    /**
     * Génère une affectation aléatoire des salariés aux besoins, en fonction des compétences.
     *
     * @param besoins La liste des besoins.
     * @param salaries La map des salariés avec leurs compétences.
     * @return Une map représentant l'affectation des salariés aux besoins.
     */
    private static Map<String, Integer> genererAffectation(List<Besoin> besoins, Map<String, Salarie> salaries) {
        Map<String, Integer> affectation = new HashMap<>();
        List<String> salariesDispo = new ArrayList<>(salaries.keySet()); // Liste des salariés disponibles
        Set<String> salariesNonAffectes = new HashSet<>(salaries.keySet()); // Liste des salariés non affectés

        for (Besoin besoin : besoins) {
            String meilleurSalarie = null;
            int meilleurInteret = -1;

            for (String salarie : salariesDispo) {
                if (salaries.get(salarie).getCompetences().containsKey(besoin.getType())) {
                    int interet = salaries.get(salarie).getCompetences().get(besoin.getType());
                    if (interet > meilleurInteret) {
                        meilleurInteret = interet;
                        meilleurSalarie = salarie;
                    }
                }
            }

            if (meilleurSalarie != null) {
                affectation.put(meilleurSalarie, besoin.getId());
                salariesDispo.remove(meilleurSalarie);
                salariesNonAffectes.remove(meilleurSalarie); // Retirer de la liste des non-affectés
            }
        }

        // Appliquer le malus aux salariés sans affectation
        for (String salarie : salariesNonAffectes) {
            affectation.put(salarie, -1); // Affectation fictive pour signaler le malus
        }

        return affectation;
    }
}
