composer install

Si une page g�n�re une erreur avec un controller non trouv� par Slim le fix est simple : composer dump-autoload -o

Pour g�n�rer la BDD il faut dans l'ordre executer : 

bdd.sql
bddDonnees.sql

Un compte admin est g�n�rer par d�fault avec le combo root/root , possibilit� de changer la combi dans bddDonnees.sql a la fin

la page d'acceuil est : 

[HOTE]/src/public/index.php/selectChamp


