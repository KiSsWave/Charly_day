def calculer_score(affectation, besoins_list, salaries_dict):
    score = 0
    client_besoins_count = {}
    salaries_affectes = set()
    clients_servis = set()

    for salarie, id_besoin in affectation.items():
        besoin = next((b for b in besoins_list if b.id == id_besoin), None)
        if not besoin:
            continue

        if besoin.type in salaries_dict[salarie].competences:
            interet = salaries_dict[salarie].competences[besoin.type]
            client = besoin.client

            malus = client_besoins_count.get(client, 0)
            points = max(1, interet - malus)
            score += points

            client_besoins_count[client] = client_besoins_count.get(client, 0) + 1
            clients_servis.add(client)
            salaries_affectes.add(salarie)

    return score

