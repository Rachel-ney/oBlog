# Backend :  
- finir les méthodes des Models
- finir les méthodes des Controller
- système connexion / inscription: 
- la connexion cherche si l'utilisateur existe ou non et le connecte si enregistré dans bdd --> modifier le retour de la méthode one() dans le cas ou auteur inexistant
- l'inscription d'un user l'enregistre dans la bdd


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
- + + formulaire pour enregistrer ses infos personnel en tant qu'auteur --> bdd update author
- + + formulaire pour modifier ses info personnel --> bdd update author
-  + formulaire pour poster un article --> bdd add post
-  + possibilité de modifier un article --> bdd update post

## Coté JavaScript :
### All : 
- générer les href des liens à l'aide des attribut pour y inclure les id des catégories et auteurs
- + jquery : http://api.jquery.com/attr/
- + vanilla : https://developer.mozilla.org/fr/docs/Web/API/Element/setAttribute

### Dans aside.js
- affichage dynamique des noms d'auteur --> ajax + DOM
- affichage dynamique des noms de category --> ajax + DOM
  
### Dans author.js
- affichage dynamique des articles d'un auteur --> ajax + DOM
  
### Dans blog.js
- affichage dynamique de tout les articles --> ajax + DOM
  
### Dans category.js
- affichage dynamique de tout les articles d'une catégorie --> ajax + DOM

### Dans post.js
- affichage dynamique d'un article entier --> ajax + DOM

