UFR Sciences et Techniques - Nantes
L3 MIAGE
Projet de Développement IHM/Client-serveur
========================

#Installation du projet

##1. PHP, MySQL et Apache
###1.1. Windows
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

##2. Composer
###2.1. Installer Composer
En installant le [Windows Installer](https://getcomposer.org/download/), il suffira par la suite d'utiliser la commande `composer`pour utiliser les commandes de Composer.
###2.2. Utiliser Composer.phar
Composer est un outil qui permet de gérer les dépendances dans un projet PHP.
Pour l'installer, se placer dans le dossier où l'on souhaite l'installer (par exemple *C:\wamp\www* sous Windows).
Puis, executer `php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"`

###Mettre à jour Composer
Executer `php composer.phar self-update`

##3. Git
Composeur a besoin de Git pour pouvoir récupérer certaines bibliothèques.
###3.1. Windows
Télécharger et installer [GIT for windows](http://msysgit.github.io/)
Changer la variable d'environnement pour pouvoir executer les commandes Git dans l'invite de commande de Windows :
- Panneau de configuration
- Système et sécurité
- Système
- Paramètres système avancés
- Variables d'environnement...
- Dans la rubrique *Variables système*, double cliquer sur la variable *Path*
- Dans le champ Valeur de la variable, ajouter tout à la fin `;C:\Program Files\Git\bin`

##4. Clone du projet
###4.1. Avec GIT
- Ouvrir l'invite de commande
- Se déplacer jusqu'au dossier où télécharger le projet (par exemple *C:\wamp\www*)
- Taper la commande `git clone https://github.com/St4rCommand/machambredhotel.git`

###4.2. Depuis l'interface de GitHub (pour collaborateurs du projet)
- Depuis l'interface GitHub, cliquer sur le *+* en haut à gauche de la fenêtre
- Cliquer ensuite sur *Clone*
- Cliquer sur le projet *machambredhotel*
- Choisissez le dossier où vous voulez cloner votre projet (par exemple *C:\wamp\www*)


##5. Mettre à jour symfony
Il est nécessaire de télécharger les bibliothèques de Symfony afin que le projet fonctionne sur votre ordinateur.
Pour cela, il faut se placer dans le dossier de votre projet et executer la commande `php ..\composer.phar install` (dans le cas où composer est installer une branche plus haut que le projet).
