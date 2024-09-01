# JeGlane.be - Projet de Partage des emplacements de Glanage en Belgique

Ce projet est une application web permettant aux utilisateurs de signaler les endroits en Belgique où il est possible de glaner des légumes et des pommes de terre.

Le projet est développé en PHP avec le framework Laravel.

## Fonctionnalités

- Inscription et authentification des utilisateurs
- Ajout de nouveaux lieux de glanage avec coordonnées géographiques
- Affichage des lieux de glanage sur une carte
- Gestion des profils utilisateurs
- Possibilité de signaler un lieu de glanage comme étant faux ou non accessible
- Gestion des commentaires sur les lieux de glanage
- Gestion des photos sur les lieux de glanage
- Possibilité de tagger les lieux de glanage avec des mots-clés (utilisés pour indiquer ce qu'il y a à glaner)
- Gestion de "votes" pour les lieux de glanage

## Prérequis

- PHP >= 8.0
- Composer
- Node.js avec npm ou yarn
- MySQL ou autre base de données compatible

## Installation en local

1. Clonez le dépôt :
```bash
git clone https://github.com/mydnic/jeglane.be.git jeglane
cd jeglane
```

2. Installez les dépendances PHP :  
```bash
composer install
```

3. Installez les dépendances JavaScript :  
```bash
npm install
// or yarn
yarn install
```

4. Copiez le fichier .env.example en .env et configurez vos variables d'environnement :  
```bash  
cp .env.example .env
```

5. Générez la clé de l'application :
```bash
php artisan key:generate
```

6. Exécutez les migrations de base de données :
```bash
php artisan migrate
```

7. Lancez le serveur de développement :
```bash
php artisan serve
```

## Contribution
Les contributions sont les bienvenues ! Veuillez soumettre une pull request ou ouvrir une issue pour discuter des changements que vous souhaitez apporter.  

## Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.
