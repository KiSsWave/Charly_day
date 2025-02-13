import random

def affectation_optimisee(besoins_list, salaries_dict):
    """
    Algorithme amélioré avec phase de correction :
    - Fait une affectation initiale gloutonne.
    - Réajuste en explorant des échanges pour maximiser le score.
    """

    # Initialisation
    random.shuffle(besoins_list)  # Mélange pour tester différentes configurations
    affectation = {}
    client_besoins_count = {}  # Suivi du nombre de besoins satisfaits par client
    salaries_disponibles = set(salaries_dict.keys())

    # PHASE 1 : Affectation Gloutonne
    for besoin in besoins_list:
        meilleur_salarie = None
        meilleur_interet = -1

        for salarie_nom in salaries_disponibles:
            salarie = salaries_dict[salarie_nom]
            if besoin.type in salarie.competences:
                interet = salarie.competences[besoin.type]

                # Appliquer malus dégressif
                malus = client_besoins_count.get(besoin.client, 0)
                score_potentiel = interet - malus

                if score_potentiel > meilleur_interet:
                    meilleur_salarie = salarie_nom
                    meilleur_interet = score_potentiel

        if meilleur_salarie:
            affectation[meilleur_salarie] = besoin.id
            salaries_disponibles.remove(meilleur_salarie)
            client_besoins_count[besoin.client] = client_besoins_count.get(besoin.client, 0) + 1

    # PHASE 2 : Amélioration de l'affectation (Échanges pour améliorer le score)
    amelioration = True
    while amelioration:
        amelioration = False
        for s1 in affectation:
            for s2 in affectation:
                if s1 != s2:
                    # Tester un échange
                    besoin_s1 = affectation[s1]
                    besoin_s2 = affectation[s2]

                    if besoin_s1 in [b.id for b in besoins_list] and besoin_s2 in [b.id for b in besoins_list]:
                        type_s1 = next(b.type for b in besoins_list if b.id == besoin_s1)
                        type_s2 = next(b.type for b in besoins_list if b.id == besoin_s2)

                        if type_s1 in salaries_dict[s2].competences and type_s2 in salaries_dict[s1].competences:
                            # Vérifier si l'échange améliore le score
                            interet_s1 = salaries_dict[s1].competences[type_s2]
                            interet_s2 = salaries_dict[s2].competences[type_s1]

                            malus_s1 = client_besoins_count.get(next(b.client for b in besoins_list if b.id == besoin_s1), 0)
                            malus_s2 = client_besoins_count.get(next(b.client for b in besoins_list if b.id == besoin_s2), 0)

                            score_avant = salaries_dict[s1].competences[type_s1] - malus_s1 + salaries_dict[s2].competences[type_s2] - malus_s2
                            score_apres = interet_s1 - malus_s1 + interet_s2 - malus_s2

                            if score_apres > score_avant:
                                # Faire l'échange
                                affectation[s1], affectation[s2] = affectation[s2], affectation[s1]
                                amelioration = True

    return affectation
