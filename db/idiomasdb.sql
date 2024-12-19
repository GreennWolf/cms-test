----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 6:10pm on December 10, 2024 (UTC)
-- database file: ../db/idiomasdb
----
BEGIN TRANSACTION;

----
-- Table structure for idiomas
----
CREATE TABLE idiomas (idioma TEXT, estado TEXT, predeterminado TEXT, cabeceras TEXT);

----
-- Data dump for idiomas, a total of 7 rows
----
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('es','on',NULL,'es-ES,es_ES,');
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('en','on',NULL,',en-US,en-GB,');
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('ca','on',NULL,',ca,ca-ES,ca_ES,');
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('gall','on',NULL,'ga,ga-ES,ga_ES');
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('fr','on',NULL,'fr,fr_FR,fr-FR,');
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('ch','on',NULL,'zh-CN');
INSERT INTO "idiomas" ("idioma","estado","predeterminado","cabeceras") VALUES ('eu','on',NULL,'eu,eu_ES,eu-ES,');
COMMIT;
