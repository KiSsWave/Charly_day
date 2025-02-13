class Besoin:
    """Représente un besoin exprimé par un client."""
    def __init__(self, id_besoin, client, type_besoin):
        self.id = int(id_besoin)
        self.client = client
        self.type = type_besoin

    def __repr__(self):
        return f"Besoin({self.id}, Client: {self.client}, Type: {self.type})"


class Salarie:
    """Représente un salarié et ses compétences."""
    def __init__(self, id_salarie, nom, competence, interet):
        self.id = int(id_salarie)
        self.nom = nom
        self.competences = {competence: int(interet)}

    def ajouter_competence(self, competence, interet):
        """Ajoute une compétence et son intérêt."""
        self.competences[competence] = int(interet)

    def __repr__(self):
        return f"Salarie({self.nom}, Compétences: {self.competences})"
