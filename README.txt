composer install

Si une page g�n�re une erreur avec un controller non trouv� par Slim le fix est simple : composer dump-autoload -o

Pour g�n�rer la BDD il faut dans l'ordre executer : 

bdd.sql
bddDonnees.sql

Pour g�n�rer un compte admin il faut faire ceci : 

-- REQUETE COMPTE ADMIN --
-- ID: root
--MDP: root

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES (NULL, 'root', '$2y$12$4HA9hcr.5goGibfINlVUQuVSYeduIlBfSymEmJ1vuxzd70ycnz7cK');