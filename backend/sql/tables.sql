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


CREATE TABLE "public"."needs" (
                                          "id" uuid NOT NULL,
                                          "client_name" character varying(100) NOT NULL,
                                          "description" text NOT NULL,
                                          "competence_type" character varying(50) NOT NULL,
                                          "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                                          "status" character varying(20) DEFAULT 'en attente',
                                          CONSTRAINT "service_needs_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


