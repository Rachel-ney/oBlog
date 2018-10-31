# Le Parcours :fire: Architecture

Cette fois, pas de petits exercices indépendants, pas de "Yeah !" et pas de "Nope".  
Vous allez avoir un petit projet à mettre en place.

## Au programme

- classes
- propriétés
- méthodes
- héritage
- routes
- _Controllers_
- _Views_
- _Models_
- **Pull Request**
- ...

Bon courage :muscle:

## Sujet : Après Mario, voici Sonic :tada:

On souhaite mettre en place un petit site sur **Sonic**, contenant 2 pages :

- page d'accueil avec tous les personnages de l'univers **Sonic**, par ordre alphabétique
- page sur les 3 créateurs du premier jeu **Sonic**

Mais on ne souhaite pas le faire n'importe comment.  
Vous avez appris cette saison à bien structurer/organiser votre code et vos fichiers.  
Il va falloir appliquer cela sur ce projet.

:chicken: En plus, il va falloir coder dans une branche à part, car, à la fin, il faudra créer une **Pull Request** du code pour ce parcours.

### Base de données

La modélisation de la base de données est fournie :

- [dictionnaire de données](docs/dictionnaire-de-donnees.md)
- [MCD](docs/S05-parcours-MCD-draw.io.png)

La base de données est fournie aussi : [fichier à importer](docs/sonic.sql)

:warning: Attention, le nom des tables sont des mots-clés réservés du langage SQL.  
Pour éviter les erreurs dans les requêtes SQL, il faut entourer le nom par 1 backtick `` ` ``  
Exemple : ``SELECT * FROM `matable` ``

### Structure du projet

La structure du projet étant similaire au projet de la saison, vous pouvez, si vous le souhaitez, en récupérer les sources pour les modifier pour correspondre au parcours.  
:warning: Attention, tout le code présent dans vos sources doit être utile au projet. **Il ne doit rester aucun code supperflu**.

La qualité du code est encore plus importante dans ce parcours :
- nom de classes, méthodes, variables claires
- indentation
- commentaires
- **aucun "groupe de code" en doublon**
- application des règles et conventions vues en cours

### Aspect visuel

- pas d'intégration HTML/CSS demandée
- vous pouvez utiliser **Bootstrap** si vous le souhaitez
- **le plus important, c'est le code, pas la cosmétique** dans ce parcours

### Layout

- en haut de chaque page, on trouvera une navigation contenant des liens vers la page d'accueil et la page des créateurs du jeu.

### Page d'accueil

- récupérer les données sur les personnages et leur type depuis la base de données
- afficher les personnages (image, nom, type, description) dans un `<table>`, par ordre alphabétique

### Les créateurs

- pour chaque créateur, afficher un titre de niveau 3 et un beau `lorem ipsum` des familles :sunglasses:
- liste des créateurs :
    - [Hirokazu Yasuhara](https://fr.wikipedia.org/wiki/Hirokazu_Yasuhara)
    - [Yuji Naka](https://fr.wikipedia.org/wiki/Yuji_Naka)
    - [Naoto Ōshima](https://fr.wikipedia.org/wiki/Naoto_%C5%8Cshima)

### Bonus

- vous pouvez vous amusez à rendre votre site assez joli avec CSS
- vous pouvez ajouter des pages, laissez parler votre créativité :bulb:

### :chicken:

- penser à la **Pull Request** :wink:
