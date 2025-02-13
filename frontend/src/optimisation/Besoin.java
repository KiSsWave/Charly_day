package optimisation;

/**
 * Représente un besoin spécifique d'un client.
 * Chaque besoin a un identifiant unique, un client associé et un type de besoin.
 */
public class Besoin {

    // Identifiant unique pour chaque besoin
    private int id;

    // Client associé à ce besoin
    private String client;

    // Type de besoin (ex: urgent, normal, etc.)
    private String type;

    /**
     * Constructeur de la classe Besoin.
     *
     * @param id     Identifiant unique du besoin.
     * @param client Nom du client associé à ce besoin.
     * @param type   Type du besoin (ex: urgent, normal).
     */
    public Besoin(int id, String client, String type) {
        this.id = id;
        this.client = client;
        this.type = type;
    }

    /**
     * Obtient l'identifiant du besoin.
     *
     * @return L'identifiant du besoin.
     */
    public int getId() {
        return id;
    }

    /**
     * Définit l'identifiant du besoin.
     *
     * @param id L'identifiant du besoin.
     */
    public void setId(int id) {
        this.id = id;
    }

    /**
     * Obtient le client associé à ce besoin.
     *
     * @return Le nom du client.
     */
    public String getClient() {
        return client;
    }

    /**
     * Définit le client associé à ce besoin.
     *
     * @param client Le nom du client.
     */
    public void setClient(String client) {
        this.client = client;
    }

    /**
     * Obtient le type de besoin.
     *
     * @return Le type du besoin.
     */
    public String getType() {
        return type;
    }

    /**
     * Définit le type de besoin.
     *
     * @param type Le type du besoin.
     */
    public void setType(String type) {
        this.type = type;
    }

    /**
     * Retourne une représentation en chaîne de caractères de ce besoin.
     *
     * @return Une chaîne contenant les détails du besoin (id, client, type).
     */
    @Override
    public String toString() {
        return "Besoin [id=" + id + ", client=" + client + ", type=" + type + "]";
    }
}
