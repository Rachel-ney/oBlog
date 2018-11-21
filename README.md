# TODO : 

# Frontend :
- router et ajouter au UserController les page lostPassword et resetPassword

## Coté template : 

- Finir les templates des pages : 
  + lostPassword
  + resetPassword
  + about us
  + contact
  + error404
  + legal mention

## Faire le JS + ajax : 
- du formulaire pour modifier ses info personnel --> bdd update author
- du formulaire pour poster un article --> bdd add post
- de la possibilité de modifier un article --> bdd update post
- de la possibilité de supprimer un article --> bdd delete post
  - penser à mettre une fenêtre de confirmation pour la supression

# Backend :  

- ajouter fonction delete() dans le PostController
- ajouter un champ "status" (1 = inscrit, 0 si désinscription) sur les auteurs
  - modifier le modèle Author en conséquence
- gérer la désinscription d'un membre (auteur) 
  - status 1 --> 0
  - modifier la fonction connexion() de AuthorController pour vérifier le status à la connexion
- gérer la perte de mot de passe
  - avec mail + token