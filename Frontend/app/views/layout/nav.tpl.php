    <!-- NAV 
        Nous sommes en mobile first : par défaut notre menu est masqué !-->
    <nav class="navbar navbar-expand-md navbar-light mx-0">

        <a class="navbar-brand" href="<?= $this->router->generate('home');?>">A la dérive</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            Menu <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Cette partie va automatique être masquée en version mobile -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('home');?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('blog');?>">Le blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('memory');?>">Jeu</a>
                </li>
                <?php if (isset($_SESSION['user'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('account');?>">Mon compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('signIn');?>?disconnect=1">Deconnexion</a>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->router->generate('signIn');?>">Connexion / Inscription</a>
                </li>
                <?php endif ; ?>
            </ul>
        </div>
    </nav>