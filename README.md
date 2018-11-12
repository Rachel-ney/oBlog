# Backend :  
- ~~finir les méthodes des Models~~
- finir les méthodes des Controller
- système connexion / inscription: 
- la connexion cherche si l'utilisateur existe ou non et le connecte si enregistré dans bdd --> modifier le retour de la méthode one() dans le cas ou auteur inexistant
- l'inscription d'un user l'enregistre dans la bdd --> insert author
- la désinscription le supprime de la bdd --> delete author


# Frontend :
## Coté template : 

- Finir les template des pages : 
- + signIn
- + about us
- + contact
- + error404
- + home
- + legal mention

### Ajouter : 
- Formulaire connexion / inscription
- Lorsqu'utilisateur connecté :
- + page "Mon compte":
- + + possibilité de se désinscrire dans la page "mon compte" --> bdd delete author
- + + formulaire pour enregistrer ses infos personnel en tant qu'auteur --> bdd update author
- + + formulaire pour modifier ses info personnel --> bdd update author
-  + formulaire pour poster un article --> bdd add post
-  + possibilité de modifier un article --> bdd update post
-  + possibilité de supprimer un article --> bdd delete post

## Coté JavaScript :
### All : 
- ~~générer les href des liens à l'aide des attribut pour y inclure les id des catégories et auteurs~~

### Dans aside.js
- ~~affichage dynamique des noms d'auteur --> ajax + DOM~~
- ~~affichage dynamique des noms de category --> ajax + DOM~~

### Dans post.js
- ~~affichage dynamique d'un article entier --> ajax + DOM~~
- ~~affichage dynamique de tout les articles sans distinction --> ajax + DOM~~
- ~~affichage dynamique de tout les articles d'une catégorie --> ajax + DOM~~
- ~~affichage dynamique des articles d'un auteur --> ajax + DOM~~