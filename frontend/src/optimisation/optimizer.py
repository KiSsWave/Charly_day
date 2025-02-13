# Initialisation de la population
import random

from src.optimisation.scoring import calculer_score


def generer_population(taille_population, besoins_list, salaries_dict):
    population = []
    for _ in range(taille_population):
        affectation = {}
        salaries_disponibles = sorted(salaries_dict.keys(), key=lambda s: max(salaries_dict[s].competences.values()), reverse=True)
        random.shuffle(besoins_list)

        for besoin in besoins_list:
            meilleur_salarie = None
            meilleur_interet = -1
            for salarie in salaries_disponibles:
                if besoin.type in salaries_dict[salarie].competences:
                    interet = salaries_dict[salarie].competences[besoin.type]
                    if interet > meilleur_interet:
                        meilleur_salarie = salarie

                        meilleur_interet = interet

            if meilleur_salarie:
                affectation[meilleur_salarie] = besoin.id
                salaries_disponibles.remove(meilleur_salarie)

        population.append(affectation)

    return population


# Sélection par tournoi (évite la stagnation)
def selection(population, besoins_list, salaries_dict, top_k=10):
    scores = [(individu, calculer_score(individu, besoins_list, salaries_dict)) for individu in population]
    scores.sort(key=lambda x: x[1], reverse=True)

    total_score = sum(score for _, score in scores)
    if total_score == 0:
        return [random.choice(scores[:top_k])[0] for _ in range(top_k)]

    # Sélection pondérée (roulette wheel selection)
    selectionnes = []
    for _ in range(top_k):
        pick = random.uniform(0, total_score)
        current = 0
        for individu, score in scores:
            current += score
            if current >= pick:
                selectionnes.append(individu)
                break

    return selectionnes



# Croisement amélioré
def croisement(parent1, parent2, besoins_list, salaries_dict):
    enfant1, enfant2 = {}, {}

    for key in parent1.keys():
        if random.random() < 0.5:
            enfant1[key] = parent1[key]
            enfant2[key] = parent2.get(key, None)
        else:
            enfant1[key] = parent2.get(key, None)
            enfant2[key] = parent1[key]

    # Vérifier si le croisement améliore le score
    if calculer_score(enfant1, besoins_list, salaries_dict) < calculer_score(parent1, besoins_list, salaries_dict):
        enfant1 = parent1.copy()
    if calculer_score(enfant2, besoins_list, salaries_dict) < calculer_score(parent2, besoins_list, salaries_dict):
        enfant2 = parent2.copy()

    return enfant1, enfant2


# Mutation intelligente
def mutation(affectation, besoins_list, salaries_dict, prob=0.3):
    if random.random() < prob:
        salaries = list(affectation.keys())
        if len(salaries) > 1:
            s1, s2 = random.sample(salaries, 2)
            if s1 in affectation and s2 in affectation:
                besoin_s1 = affectation[s1]
                besoin_s2 = affectation[s2]

                type_s1 = next(b.type for b in besoins_list if b.id == besoin_s1)
                type_s2 = next(b.type for b in besoins_list if b.id == besoin_s2)

                if type_s1 in salaries_dict[s2].competences and type_s2 in salaries_dict[s1].competences:
                    nouvelle_affectation = affectation.copy()
                    nouvelle_affectation[s1], nouvelle_affectation[s2] = nouvelle_affectation[s2], nouvelle_affectation[s1]

                    if calculer_score(nouvelle_affectation, besoins_list, salaries_dict) > calculer_score(affectation, besoins_list, salaries_dict):
                        return nouvelle_affectation
    return affectation


# Algorithme génétique évolué
def algorithme_genetique(besoins_list, salaries_dict, generations=100, population_size=30):
    population = generer_population(population_size, besoins_list, salaries_dict)

    for _ in range(generations):
        selectionnes = selection(population, besoins_list, salaries_dict)
        nouvelle_population = selectionnes.copy()

        while len(nouvelle_population) < population_size:
            p1, p2 = random.sample(selectionnes, 2)
            e1, e2 = croisement(p1, p2,besoins_list, salaries_dict)
            nouvelle_population.append(mutation(e1, besoins_list, salaries_dict))
            if len(nouvelle_population) < population_size:
                nouvelle_population.append(mutation(e2, besoins_list, salaries_dict))

        population = nouvelle_population

    meilleur = selection(population, besoins_list, salaries_dict, top_k=1)[0]
    return meilleur