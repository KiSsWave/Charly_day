-- Adminer 4.8.1 PostgreSQL 17.2 (Debian 17.2-1.pgdg120+1) dump

DROP TABLE IF EXISTS "competences";
DROP SEQUENCE IF EXISTS competences_id_seq;
CREATE SEQUENCE competences_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."competences" (
                                        "id" integer DEFAULT nextval('competences_id_seq') NOT NULL,
                                        "nom" character varying(255) NOT NULL,
                                        "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                                        CONSTRAINT "competences_nom_key" UNIQUE ("nom"),
                                        CONSTRAINT "competences_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "needs";
CREATE TABLE "public"."needs" (
                                  "id" uuid NOT NULL,
                                  "description" text NOT NULL,
                                  "competence_type" character varying(50) NOT NULL,
                                  "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                                  "status" character varying(20) DEFAULT 'en attente',
                                  "client_name" character varying(100) NOT NULL,
                                  CONSTRAINT "needs_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "salarie_competence";
DROP SEQUENCE IF EXISTS salarie_competence_id_seq;
CREATE SEQUENCE salarie_competence_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."salarie_competence" (
                                               "id" integer DEFAULT nextval('salarie_competence_id_seq') NOT NULL,
                                               "salarie_id" uuid NOT NULL,
                                               "competence_id" integer NOT NULL,
                                               "note" integer,
                                               CONSTRAINT "salarie_competence_pkey" PRIMARY KEY ("id"),
                                               CONSTRAINT "salarie_competence_salarie_id_competence_id_key" UNIQUE ("salarie_id", "competence_id")
) WITH (oids = false);


DROP TABLE IF EXISTS "salaries";
CREATE TABLE "public"."salaries" (
                                     "id" uuid NOT NULL,
                                     "nom" character varying(255) NOT NULL,
                                     "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                                     CONSTRAINT "salaries_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "users";
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


ALTER TABLE ONLY "public"."needs" ADD CONSTRAINT "fk_needs_users" FOREIGN KEY (client_name) REFERENCES users(login) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."salarie_competence" ADD CONSTRAINT "fk_competence" FOREIGN KEY (competence_id) REFERENCES competences(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."salarie_competence" ADD CONSTRAINT "fk_salarie" FOREIGN KEY (salarie_id) REFERENCES salaries(id) ON DELETE CASCADE NOT DEFERRABLE;

