# Initialisation de la population
import random

from src.optimisation.scoring import calculer_score


def generer_population(taille_population, besoins_list, salaries_dict):
    population = []
    for _ in range(taille_population):
        affectation = {}
        salaries_disponibles = list(salaries_dict.keys())
        random.shuffle(salaries_disponibles)
        random.shuffle(besoins_list)

        for besoin in besoins_list:
            for salarie in salaries_disponibles:
                if besoin.type in salaries_dict[salarie].competences:
                    affectation[salarie] = besoin.id
                    salaries_disponibles.remove(salarie)
                    break

        population.append(affectation)

    return population

# Sélection par tournoi (évite la stagnation)
def selection(population, besoins_list, salaries_dict, top_k=10):
    scores = [(individu, calculer_score(individu, besoins_list, salaries_dict)) for individu in population]
    scores.sort(key=lambda x: x[1], reverse=True)

    # Sélection par tournoi entre les top_k meilleurs individus
    return [random.choice(scores[:top_k])[0] for _ in range(top_k)]


# Croisement amélioré
def croisement(parent1, parent2):
    enfant1, enfant2 = {}, {}

    # Sélectionner au hasard une partie des assignations de chaque parent
    for key in parent1.keys():
        if random.random() < 0.5:
            enfant1[key] = parent1[key]
            enfant2[key] = parent2.get(key, None)
        else:
            enfant1[key] = parent2.get(key, None)
            enfant2[key] = parent1[key]

    return enfant1, enfant2

# Mutation intelligente
def mutation(affectation, besoins_list, salaries_dict, prob=0.3):
    if random.random() < prob:
        salaries = list(affectation.keys())
        if len(salaries) > 1:
            s1, s2 = random.sample(salaries, 2)
            if s1 in affectation and s2 in affectation:
                # Vérification si l'échange améliore le score
                besoin_s1 = affectation[s1]
                besoin_s2 = affectation[s2]

                type_s1 = next(b.type for b in besoins_list if b.id == besoin_s1)
                type_s2 = next(b.type for b in besoins_list if b.id == besoin_s2)

                if type_s1 in salaries_dict[s2].competences and type_s2 in salaries_dict[s1].competences:
                    affectation[s1], affectation[s2] = affectation[s2], affectation[s1]
    return affectation

# Algorithme génétique évolué
def algorithme_genetique(besoins_list, salaries_dict, generations=100, population_size=30):
    population = generer_population(population_size, besoins_list, salaries_dict)

    for _ in range(generations):
        selectionnes = selection(population, besoins_list, salaries_dict)
        nouvelle_population = selectionnes.copy()

        while len(nouvelle_population) < population_size:
            p1, p2 = random.sample(selectionnes, 2)
            e1, e2 = croisement(p1, p2)
            nouvelle_population.append(mutation(e1, besoins_list, salaries_dict))
            if len(nouvelle_population) < population_size:
                nouvelle_population.append(mutation(e2, besoins_list, salaries_dict))

        population = nouvelle_population

    meilleur = selection(population, besoins_list, salaries_dict, top_k=1)[0]
    return meilleur