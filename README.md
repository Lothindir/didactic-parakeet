# Didactic Parakeet
The platform for all the real book lovers

## Installation
#### Prerequisites
In order to launch the application you need to install a few tools :

##### Using Chocolatey
If you have chocolatey installed just run these commands :
```
choco install php
```
```
choco install composer
```
```
choco install nodejs
```
##### Installing programs
Install the latest version of php : [php.net](https://www.php.net/downloads.php)
Install the latest version of composer : [getcomposer.org](https://getcomposer.org/download/)
Install the latest version of NodeJS : [nodejs.org](https://nodejs.org/en/download/)

#### Setup the repo
Clone or download the [repository](https://github.com/Lothindir/didactic-parakeet.git). Open the folder with your favorite text editor (VS Code, Atom, PHPStorm, ...).
Open a terminal window and type
```
composer install
```
and 
```
npm install
```
to setup all the required packages.

#### php.ini
Edit your php.ini file (usually located in ```C:/tools/php*```)
Uncomment the following extensions :
-   curl
-   fileinfo
-   mysqli
-   odbc
-   pdo_mysql

#### MySQL
Start a MySQL/MariaDB server (XAMPP, WampServer, uWamp or other)

Create a file named ```.env.local``` at the root of the project and write 
```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/didactic_parakeet"
``` 
where ```user``` and ```password``` are the MySQL database user and password.

#### Doctrine
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

## Run the website
In order to run the website you'll need to start a few services.
In a terminal window located at the root of your project type
```
symfony server:start
```
to start the web server.
To compile the CSS and JavaScript you'll need to run `webpack` :
```
npm run dev
```
will compile all the assets for you, or
```
npm run watch
```
will compile and watch any changes in your files, and re-complies when needed.

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
- Pages :
  -  [ ] Homepage
  -  [ ] Vue générale des livres (classé par ordre alphabétique)
  -  [ ] Vue par catégorie
  -  [ ] Vue détaillée par livre
  -  [ ] Page ajout de livre
  -  [ ] Vue détaillée utilisateur
