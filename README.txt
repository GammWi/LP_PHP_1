composer install

Si une page génère une erreur avec un controller non trouvé par Slim le fix est simple : composer dump-autoload -o

Pour générer la BDD il faut dans l'ordre executer : 

bdd.sql
bddDonnees.sql

Un compte admin est générer par défault avec le combo root/root , possibilité de changer la combi dans bddDonnees.sql a la fin

la page d'acceuil est : 

[HOTE]/src/public/index.php/selectChamp


