![Build Status](https://github.com/Fredkiss3/portolio/workflows/CI_CD/badge.svg?branch=main)

# portolio
Mon portfolio personnel


## I- Pré-requis

Pour lancer le projet il faut :
- avoir `composer` installé
- avoir `php >= 7.4` installé
- avoir `MySQL >= 5.0` installé

## II- Comment lancer le projet ?

Pour lancer l'application il faut : 

1- installer les dépendances :

```bash
composer install 
```

2- Mettre en place la base de données :

Modifier le fichier `.env` pour correspondre à votre base de données 

```dotenv
DATABASE_URL="mysql://{utitisateur}:{mot_de_passe}@127.0.0.1:3306/{base_de_données}"
```

Installer la Base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

3- Lancer le serveur :

```bash
php -S localhost:8000 -t public
```

4- Ouvrir le navigateur à l'adresse http://localhost:8000

### Tests

Ce projet a été conçu en suivant le modèle du Test First.
Vous pouvez lancer les tests avec la commande :

```bash
php bin/phpunit
```