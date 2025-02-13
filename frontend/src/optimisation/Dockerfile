# Utilise OpenJDK
FROM openjdk:17-slim

# Installation de findutils
RUN apt-get update && apt-get install -y findutils

# Définit le dossier de travail
WORKDIR /app

# Copie tout le code source dans le conteneur
COPY . /app

# Crée le dossier de compilation
RUN mkdir -p /app/classes

# Compile tout en respectant les packages
RUN find /app -name "*.java" > sources.txt && javac -d /app/classes @sources.txt

# Se positionner dans le dossier des classes compilées
WORKDIR /app/classes

# Exécuter l'application avec le bon package
CMD ["java", "optimisation.Main"]