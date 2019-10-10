# Didactic Parakeet
The platform for all the real book lovers

## Installation
### php.ini
Add the following extensions :
-   curl
-   fileinfo
-   mysqli
-   odbc
-   pdo_mysql

### MySQL
Start a MySQL server (XAMPP, WampServer, uWamp or other)

Create a file named ```.env.local``` at the root of the project and write 
```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/didactic_parakeet"
``` 
in it, where ```user``` and ```password``` are the MySQL database user and password.

### Doctrine
You'll now need to create, migrate and populate your database.
Enter the terminal at the root of the project folder and type 
```
php bin/console doctrine:database:create
``` 
to create the database.
Then type
```
php bin/console doctrine:migration:migrate
``` 
to create all the tables and keys needed.
If you want to populate the database with placeholders type
```
php bin/console doctrine:fixture:load
```

## Roadmap
#### Fonctionnalités
- [ ]	Petite bande en haut, menu à gauche (bande verticale), logo à gauche et login/inscription à droite
- [ ]	Pied de page avec nos noms ainsi que le moyen de nous contacter (didacticParakeet.contact@gmail.com)
- [ ]	Explication de l’utilité du site ainsi que les 5 derniers ouvrages ajoutés.
    - [ ]	« Bienvenue sur Didactic Parakeet, le site pour toutes et tous les vrais passionnés de lecture. Ce site a été créé par amour des livres. Mais également afin de découvrir et de faire découvrir de nouvelles œuvres. Vous pouvez également laisser une appréciation sur ces dernières. Alors n’hésitez plus et inscrivez-vous afin de profiter de l’ensemble des fonctionnalités. »
    - [ ]	Les 5 derniers ouvrages ajoutés : Via des petites cartes ? des bandes larges ?
- [ ]	Liste des livres :
    - [ ]	Vue liste, Accès libre
        - [ ]	Une page avec tous les livres (par ordre alphabétique). 
        - [ ]	Une page par catégorie, accessible via un bouton sur la page de base.
    - [ ]	Vue détaillée, accès que aux membres connectés
        -	Vue détaillée soit sur un livre soit sur une personne.
        -	Si pas connecté, redirection sur la page de connexion.
- [ ]	Une page pour ajouter des livres :
    -    Il faut être connecté.
- [ ]	Un simple form, avec les doubles checks (client et server)
