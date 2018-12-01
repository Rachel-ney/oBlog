<div class="data" data-id="<?=$_GET['id']?>" data-token="<?=$_GET['token']?>">
    <h1 class="text-center">Réinitialiser le mot de passe</h1>
    <!-- TODO : ajouter formulaire de changement de mdp -->

    <form class="col-5 mx-auto reset-password">
        <div class="form-group">
            <label>Nouveau mot de passe</label>
            <input type="password" class="form-control password" placeholder="Password">
        </div>
        <div class="form-group">
            <label>Confirmation du mot de passe</label>
            <input type="password" class="form-control password-confirm" placeholder="Password confirm">
            <small class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractères dont : minuscule(s), majuscule(s), chiffre(s) et au moins un des caractères suivant _ ? . !</small>
        </div>
        <button type="submit" class="btn d-block mx-auto">Envoyer</button>
    </form>
</div>