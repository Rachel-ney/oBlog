<?php if (!empty($_SESSION['idUser'])) : ?>

<div class="row">
    <main class="col-lg-9">
        <h3>Tu es connecté</h3>
        <p>Acceder à la page <a href="<?= $this->router->generate('account');?>"> Mon compte </a></p>
    </main>
</div>

<?php else : ?>

<div class="row all-form">
    <main class="col-lg-12 d-flex flex-row ">
        
        <form class="col-5 mx-auto border d-flex flex-column sign-in ">
            <h3 class="text-center">Se connecter</h3>
            <div class="form-group">
                <label>Adresse mail</label>
                <input type="email" class="form-control email" placeholder="example@mail.com">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" class="form-control password" placeholder="Password">
            </div>
            <button type="submit" class="btn d-block mx-auto mt-auto">Connexion</button>
        </form>
        
        <form class="col-5 mx-auto border register">
            <h3 class="text-center">S'inscrire</h3>
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" class="form-control name" placeholder="Name">
            </div>
            <div class="form-group">
                <label>Adresse email</label>
                <input type="email" class="form-control email" placeholder="example@mail.com">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" class="form-control password" placeholder="Password">
                <small id="emailHelp" class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractère dont : minuscule, majuscule, chiffre et au moins un des caractères suivant _ ? . !</small>
            </div>
            <button type="submit" class="btn d-block mx-auto">Inscription</button>
        </form>
    </main>
</div>
<?php endif; ?>