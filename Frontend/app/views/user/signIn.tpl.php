<div class="row all-form">
    <main class="col-12 col-md-8 col-lg-7 mx-auto p-0 d-lg-flex flex-lg-row  ">
        
        <form class="col-12 col-lg-5 m-3 border d-flex flex-column sign-in ">
            <h3 class="text-center mt-3">Se connecter</h3>
            <div class="form-group">
                <label>Adresse mail</label>
                <input type="email" class="form-control col-10 email" placeholder="example@mail.com">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" class="form-control col-10 password" placeholder="Password">
                <small class="form-text"> <a class="text-muted" href="<?=$this->router->generate('lostPass'); ?>" >Mot de passe oublié ?</a> </small>
            </div>
            <button type="submit" class="btn d-block mx-auto mt-auto mb-3">Connexion</button>
        </form>
        
        <form class="col-12 col-lg-5 m-3 border register">
            <h3 class="text-center mt-3">S'inscrire</h3>
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" class="form-control col-10 name" placeholder="Name">
            </div>
            <div class="form-group">
                <label>Adresse email</label>
                <input type="email" class="form-control col-10 email" placeholder="example@mail.com">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" class="form-control col-10 password" placeholder="Password">
            </div>
            <div class="form-group">
                <label>Confirmation du mot de passe</label>
                <input type="password" class="form-control col-10 password-confirm" placeholder="Password confirm">
                <small class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractères dont : minuscule(s), majuscule(s), chiffre(s) et au moins un caractère spécial</small>
            </div>
            <button type="submit" class="btn d-block mx-auto mb-3">Inscription</button>
        </form>
    </main>
</div>