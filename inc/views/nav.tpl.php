    <!-- NAV -->
    <nav class="navbar navbar-expand-md navbar-light">
        <!--
        Nous sommes en mobile first : par défaut notre menu est masqué !
        Je souhaite qu'il s'affiche au dela (= à partir de) d'une certainne largeur.
        navbar-expand-xxx permet d'afficher le menu en entier.
        xxx correspond à une taille (media-query) définie dans Bootstrap.
          sm => 576px
          md => 768px
          lg => 992px
          xl => 1200px
        -->
        <a class="navbar-brand" href="#">A la dérive</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            Menu <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Cette partie va automatique être masquée en version mobile -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ">
                <?php foreach ($this->getVar('categories') as $categoryName) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= $categoryName ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>