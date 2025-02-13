DROP TABLE IF EXISTS "users";
DROP TABLE IF EXISTS salarie_competence;
DROP TABLE IF EXISTS salaries;
DROP TABLE IF EXISTS competences;
CREATE TABLE "public"."users" (
                                  "id" uuid NOT NULL,
                                  "login" character varying(100) NOT NULL,
                                  "email" character varying(150) NOT NULL,
                                  "password" character varying(255) NOT NULL,
                                  "role" integer NOT NULL,
                                  CONSTRAINT "users_email_key" UNIQUE ("email"),
                                  CONSTRAINT "users_login_key" UNIQUE ("login"),
                                  CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


CREATE TABLE "public"."needs" (
                                          "id" uuid NOT NULL,
                                          "client_name" character varying(100) NOT NULL,
                                          "description" text NOT NULL,
                                          "competence_type" character varying(50) NOT NULL,
                                          "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                                          "status" character varying(20) DEFAULT 'en attente',
                                          CONSTRAINT "service_needs_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

-- Table des salariés
CREATE TABLE salaries (
                          id UUID PRIMARY KEY,
                          nom VARCHAR(255) NOT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des compétences
CREATE TABLE competences (
                             id SERIAL PRIMARY KEY,
                             nom VARCHAR(255) UNIQUE NOT NULL,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table de liaison salarie_competence
CREATE TABLE salarie_competence (
                                    id SERIAL PRIMARY KEY,
                                    salarie_id UUID NOT NULL,
                                    competence_id INT NOT NULL,
                                    note INT CHECK (note BETWEEN 1 AND 10),

    -- Clés étrangères
                                    CONSTRAINT fk_salarie FOREIGN KEY (salarie_id) REFERENCES salaries(id) ON DELETE CASCADE,
                                    CONSTRAINT fk_competence FOREIGN KEY (competence_id) REFERENCES competences(id) ON DELETE CASCADE,

    -- Un salarié ne peut avoir une compétence qu'une seule fois
                                    UNIQUE (salarie_id, competence_id)
);
