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
                <small class="form-text"> <a class="text-muted" href="<?=$this->router->generate('lostPass'); ?>" >Mot de passe oublié ?</a> </small>
            </div>
            <button type="submit" class="btn d-block mx-auto mt-auto">Connexion</button>
        <?php if(isset($_SESSION['error']['connectionFail'])) : ?>
            <div class="bg-danger text-light rounded p-2 mt-2 mb-2" ><?=$_SESSION['error']['connectionFail'];?></div>
        <?php endif ; ?>
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
            </div>
            <div class="form-group">
                <label>Confirmation du mot de passe</label>
                <input type="password" class="form-control password-confirm" placeholder="Password confirm">
                <small class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractères dont : minuscule(s), majuscule(s), chiffre(s) et au moins un des caractères suivant _ ? . !</small>
            </div>
            <button type="submit" class="btn d-block mx-auto">Inscription</button>
            <?php if(isset($_SESSION['error']['registerFail'])) : ?>
            <div class="bg-danger text-light rounded p-2 mt-2 mb-2" ><?=$_SESSION['error']['registerFail'];?></div>
            <?php endif ; ?>
        </form>
    </main>
</div>

<?php 
// J'attends la fin du chargement pour remettre à 0 mes erreurs / success en session : 

unset($_SESSION['error']);

?>