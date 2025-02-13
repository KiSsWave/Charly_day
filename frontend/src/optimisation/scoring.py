def calculer_score(affectation, besoins_list, salaries_dict):
    """
    Calcule le score total d'une affectation.
    """
    score = 0
    client_besoins_count = {}  # Nombre de besoins satisfaits par client
    salaries_affectes = set()
    clients_servis = set()

    for salarie, id_besoin in affectation.items():
        besoin = next((b for b in besoins_list if b.id == id_besoin), None)
        if not besoin:
            continue

        if besoin.type in salaries_dict[salarie].competences:
            interet = salaries_dict[salarie].competences[besoin.type]
            client = besoin.client

            # Malus dégressif
            malus = client_besoins_count.get(client, 0)
            points = max(1, interet - malus)
            score += points

            client_besoins_count[client] = client_besoins_count.get(client, 0) + 1
            clients_servis.add(client)
            salaries_affectes.add(salarie)

    # Pénalité pour les salariés non affectés (-10)
    for salarie in salaries_dict.keys():
        if salarie not in salaries_affectes:
            score -= 10

    # Pénalité pour les clients non servis (-10)
    for besoin in besoins_list:
        if besoin.client not in clients_servis:
            score -= 10

    return score
