package optimisation;

import java.util.HashMap;
import java.util.Map;

/**
 * Représente un salarié avec un nom et un ensemble de compétences associées.
 * Chaque compétence a un type et un niveau d'intérêt.
 */
public class Salarie {

    // Nom du salarié
    private String nom;

    // Map associant chaque compétence à son niveau d'intérêt
    private Map<String, Integer> competences;

    /**
     * Constructeur de la classe Salarie.
     * Initialise le nom du salarié et crée une nouvelle map pour les compétences.
     *
     * @param nom Nom du salarié.
     */
    public Salarie(String nom) {
        this.nom = nom;
        this.competences = new HashMap<>();
    }

    /**
     * Ajoute une compétence avec un niveau d'intérêt à la liste des compétences du salarié.
     *
     * @param type     Le type de la compétence (par exemple, "Java", "Communication").
     * @param interet  Le niveau d'intérêt ou de maîtrise de cette compétence.
     */
    public void ajouterCompetence(String type, int interet) {
        competences.put(type, interet);
    }

    /**
     * Obtient le nom du salarié.
     *
     * @return Le nom du salarié.
     */
    public String getNom() {
        return nom;
    }

    /**
     * Définit le nom du salarié.
     *
     * @param nom Le nom du salarié.
     */
    public void setNom(String nom) {
        this.nom = nom;
    }

    /**
     * Obtient les compétences du salarié sous forme de Map.
     *
     * @return Une map associant chaque compétence à son niveau d'intérêt.
     */
    public Map<String, Integer> getCompetences() {
        return competences;
    }

    /**
     * Définit les compétences du salarié.
     *
     * @param competences Une map associant chaque compétence à son niveau d'intérêt.
     */
    public void setCompetences(Map<String, Integer> competences) {
        this.competences = competences;
    }

    /**
     * Retourne une représentation en chaîne de caractères de ce salarié.
     *
     * @return Une chaîne contenant le nom du salarié et ses compétences.
     */
    @Override
    public String toString() {
        return "Salarie [nom=" + nom + ", competences=" + competences + "]";
    }
}
