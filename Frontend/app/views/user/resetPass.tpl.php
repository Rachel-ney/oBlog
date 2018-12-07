<div class="col-12 col-lg-6 my-3 mx-auto data" data-id="<?=$_GET['id']?>" data-token="<?=$_GET['token']?>">
    <p class="h3 mx-auto mb-4 text-center">Réinitialiser le mot de passe</p>

    <form class="col-12 col-md-7 col-lg-8 mb-5 reset-password">
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