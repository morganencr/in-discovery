IN:DISCOVERY. est un site web dédié à la découverte de groupes et d'artistes émergents dans 
les scènes punk, rock, metal et hardcore. Notre objectif est de mettre en lumière les talents 
moins connus et de leur offrir une plateforme pour se faire entendre.

## Fonctionnalités :

- Catalogue de Groupes et Artistes : Découvrez des groupes classés par genre musical (punk, rock, metal, hardcore).

- Soumission de Suggestions : Les visiteurs peuvent soumettre leurs propres découvertes de groupes via un formulaire de suggestions. Chaque soumission peut inclure le nom du groupe, un lien pour écouter leur musique et un commentaire optionnel.

- Calendrier des Concerts : Consultez les prochains concerts et événements liés aux groupes présentés.

- Back Office : Gestion des contenus via une interface admin accessible grâce à un konami code, facilitée par des frameworks tels que Bootstrap pour une expérience utilisateur améliorée.

## Technologies Utilisées :

- Frontend : HTML, CSS, JavaScript (possiblement avec des frameworks comme Bootstrap pour le design et l'interaction utilisateur).

- Backend : PHP, gestion des bases de données avec MySQL.

- Gestion de la Base de Données : phpMyAdmin pour une gestion simplifiée.

- Conteneurisation : Utilisation de Docker pour l'environnement de développement (PHP, MySQL, phpMyAdmin).

## Prérequis :

- Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :

→ Docker
→ Docker Compose

## Installation :

1 Clonez le dépôt du projet : 

git clone https://github.com/morganencr/in-discovery.git
cd in-discovery

2 Lancez les conteneurs Docker : 

- Utilisez Docker Compose pour construire et lancer les conteneurs nécessaires :

docker-compose up  --build

Cela démarrera les conteneurs pour PHP, MySQL et phpMyAdmin.

3 Accédez à l'application :

Une fois les conteneurs lancés, vous pouvez accéder au site en ouvrant votre navigateur et en naviguant vers http://localhost:8019.

## Utilisation : 

- Navigation : Parcourez les différentes sections du site pour découvrir des groupes et consulter les événements à venir.

- Soumettre une Découverte : Utilisez le formulaire de suggestions pour soumettre des groupes que vous souhaitez voir figurer sur le site.

- Administration : Connectez-vous à l'interface admin (back office) pour gérer les contenus, les groupes, et les événements. (Accès réservé aux administrateurs.)

## Contribution

Les contributions sont les bienvenues. Si vous souhaitez contribuer à IN:DISCOVERY., 
veuillez suivre ces étapes :

- Forkez le projet.

- Créez une branche pour votre fonctionnalité (git checkout -b ma-nouvelle-fonctionnalite).

- Faites vos modifications et commitez-les (git commit -m 'Ajouter une nouvelle fonctionnalité').

- Poussez vos modifications (git push origin ma-nouvelle-fonctionnalite).

- Ouvrez une Pull Request.

## Remerciements : 

Merci à tous les contributeurs et à tous ceux qui soutiennent la scène musicale underground !