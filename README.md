# Formation Symfony 5 - symfony-120922-demo1

## Pour installer l'application
```
# clonage des sources
git clone https://github.com/cdufour/symfony-120922-demo1.git

# déplacement dans le dossier applicatif
cd symfony-120922-demo1/

# installation des dépendances listées dans le fichier composer.json
composer install

# démarrage en arrière-plan d'une instance mariadb sur le port host 3336
docker run --name mariadb -d -p 3336:3306 \
    -e MARIADB_USER=stagiaire \ 
    -e MARIADB_PASSWORD=stagiaire \
    -e MARIADB_ROOT_PASSWORD=stagiaire mariadb:10.3.36

# exécutions des migrations
php bin/console doctrine:migrations:migrate

# démarrage en arrière-plan d'un serveur web de développement sur le port 8000
symfony server:start --port=8000 -d

# arrêt du serveur
symfony server:stop

```
## Liens utiles
- [How to Work with multiple Entity Managers and Connections](https://symfony.com/doc/current/doctrine/multiple_entity_managers.html)
- [https://symfony.com/doc/5.4/doctrine/reverse_engineering.html](https://symfony.com/doc/5.4/doctrine/reverse_engineering.html)
- [How to Write a custom Twig Extension](https://symfony.com/doc/5.4/templating/twig_extension.html)
- [Events and Event Listeners]()
- [How to access the entity manager (Doctrine) inside a command in Symfony 5](https://ourcodeworld.com/articles/read/1131/how-to-access-the-entity-manager-doctrine-inside-a-command-in-symfony-5)
- [Symfony Authentication Tutorial Part 7 | Symfony Voters | Permission Based Access Control]()
- [HTTP Cache](https://symfony.com/doc/5.4/http_cache.html)
- [29 - La gestion du cache avec Symfony](https://www.youtube.com/watch?v=5ER2p7SYNX8)
