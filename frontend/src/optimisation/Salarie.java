package optimisation;

import java.util.HashMap;
import java.util.Map;

public class Salarie {
    String nom;
    Map<String, Integer> competences;

    public Salarie(String nom) {
        this.nom = nom;
        this.competences = new HashMap<>();
    }

    public void ajouterCompetence(String type, int interet) {
        competences.put(type, interet);
    }
}