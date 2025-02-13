from models import Besoin, Salarie
from scoring import calculer_score
from optimizer import algorithme_genetique

# Charger les fichiers CSV
def charger_donnees(fichier_besoins, fichier_competences):
    with open(fichier_besoins, "r", encoding="utf-8") as file:
        lines = file.readlines()

    besoins_section = []
    competences_section = []
    current_section = None

    for line in lines:
        line = line.strip()
        if "besoins" in line.lower():
            current_section = "besoins"
            continue
        elif "competences" in line.lower():
            current_section = "competences"
            continue
        elif line == "":
            current_section = None
            continue

        if current_section == "besoins":
            besoins_section.append(line.split(";"))
        elif current_section == "competences":
            competences_section.append(line.split(";"))

    besoins_list = [Besoin(*row[:3]) for row in besoins_section]
    salaries_dict = {}
    for row in competences_section:
        id_salarie, nom, competence, interet = row[:4]
        if nom in salaries_dict:
            salaries_dict[nom].ajouter_competence(competence, interet)
        else:
            salaries_dict[nom] = Salarie(id_salarie, nom, competence, interet)

    return besoins_list, salaries_dict

# Charger les données
besoins_list, salaries_dict = charger_donnees("csv_2025/etudiant/02_pb_complexes/Probleme_10_nbSalaries_26_nbClients_26_nbTaches_3.csv",
                                              "csv_2025/etudiant/02_pb_complexes/Probleme_10_nbSalaries_26_nbClients_26_nbTaches_3.csv")

# Exécuter l'algorithme optimisé
affectation = algorithme_genetique(besoins_list, salaries_dict)

# Calculer et afficher le score
score = calculer_score(affectation, besoins_list, salaries_dict)

print("Affectation générée :", affectation)
print("Score obtenu :", score)
