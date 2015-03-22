UFR Sciences et Techniques - Nantes
L3 MIAGE
Projet de Développement IHM/Client-serveur
========================

#1. Environnement de développement

##1.1. Serveur
###1.1.1. Windows
Installer la plateforme de développement [Wamp](http://www.wampserver.com/).
Pour profiter de symfony, il est nécessaire de pouvoir executer des commandes PHP dans l'invite de commande de Windows.
Pour cela, il faut la variable d'environnement pour y ajouter PHP :
- Panneau de configuration
- Système et sécurité
- Système
- Paramètres système avancés
- Variables d'environnement...
- Dans la rubrique *Variables système*, double cliquer sur la variable *Path*
- Dans le champ Valeur de la variable, ajouter tout à la fin `;C:\wamp\www\bin\php\php5.5.12`
###1.1.2. Ubuntu
Sur Ubuntu, il faut installer [XAMPP](https://www.apachefriends.org/fr/index.html).

##1.2 Composer
###1.2.1. Installer Composer (Windows uniquement)
En installant le [Windows Installer](https://getcomposer.org/download/), il suffira par la suite d'utiliser la commande `composer`pour utiliser les commandes de Composer.
###1.2.2. Utiliser Composer.phar
Composer est un outil qui permet de gérer les dépendances dans un projet PHP.
Pour l'installer, se placer dans le dossier où l'on souhaite l'installer (par exemple *C:\wamp\www* sous Windows).
Puis, executer `php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"`

###1.2.3. Mettre à jour Composer
Executer `php composer.phar self-update`

##1.3. Git
Composeur a besoin de Git pour pouvoir récupérer certaines bibliothèques.
###1.3.1. Windows
Télécharger et installer [GIT for windows](http://msysgit.github.io/). Lors de l'installation, faites attention à bien cocher la case permettant d'executer les commandes GIT dans la console de Windows.
Changer la variable d'environnement pour pouvoir executer les commandes Git dans l'invite de commande de Windows :
- Panneau de configuration
- Système et sécurité
- Système
- Paramètres système avancés
- Variables d'environnement...
- Dans la rubrique *Variables système*, double cliquer sur la variable *Path*
- Dans le champ Valeur de la variable, ajouter tout à la fin `;C:\Program Files\Git\bin`
###1.3.2. Ubuntu
Il suffit d'executer la commande `apt-get install git` suivante dans un terminal.apt-get install git

#2. Installation du projet

##2.1. Clone du projet
###2.1.1. Avec GIT
- Ouvrir l'invite de commande
- Se déplacer jusqu'au dossier où télécharger le projet (par exemple *C:\wamp\www* sous Windows avec Wamp)
- Taper la commande `git clone https://github.com/St4rCommand/machambredhotel.git`

###2.1.2. Depuis l'interface de GitHub (Windows uniquement)
- Depuis l'interface GitHub, cliquer sur le *+* en haut à gauche de la fenêtre
- Cliquer ensuite sur *Clone*
- Cliquer sur le projet *machambredhotel*
- Choisissez le dossier où vous voulez cloner votre projet (par exemple *C:\wamp\www*)


##2.2. Déploiement du projet
###2.2.1 Mise à jour de symfony
Il est nécessaire de télécharger les bibliothèques de Symfony afin que le projet fonctionne sur votre ordinateur.
Pour cela, il faut se placer dans le dossier de votre projet et executer la commande `php ..\composer.phar install` (dans le cas où composer est installé sur une branche plus haute que le projet).
###2.2.2 Création de la base
Il faut ensuite générer la base de données. Le nom de la base est données dans le fichier *app\config\parameters.yml*, à la ligne *database_name*.
Voici la commande à executer (depuis la racine du projet) : `php app/console doctrine:database:create`
###2.2.3 Création des tables
Pour générer les tables de la base de données, il faut executer la commande `php app/console doctrine:schema:update --force`
###2.2.4 Insertion de données pour les tests
Afin de faciliter la première utilisation et les tests, nous avons utilisé le bundle fixtures permettant d'insérer des données dans la base grâce à la commande `php app/console doctrine:fixtures:load`.
En executant cette commande, des hôtels, de chambres, des réservations ainsi que trois comptes utilisateurs sont créés : 
- admin/admin : compte disposant des droits d'administrateur, possédant un hôtel
- customer/customer : compte disposant des droits clients, avec des réservations
- hotelkeeper/hotelkeeper : compte disposant des droits de gérant d'hôtel, possédant trois hôtels
Il n'est pas possible d'ajouter d'autres compte gérant d'hôtel car le formulaire n'a pas été créé.
