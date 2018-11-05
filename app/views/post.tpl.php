      <!-- Je crée une nouvelle ligne dans ma grille virtuelle: https://getbootstrap.com/docs/4.1/layout/grid/-->
      <div class="row">

        <!-- Par défaut (= sur mobile) mon element <main> prend toutes les colonnes (=12)
        MAIS au dela d'une certaine taille, il n'en prendra plus que 9
        https://getbootstrap.com/docs/4.1/layout/grid/#grid-options -->
        <main class="col-lg-9">
          <!-- Je dispose une card: https://getbootstrap.com/docs/4.1/components/card/ -->
          <article class="card">
            <div class="card-body">
              <h2 class="card-title"> <?= $this->var['post']->getTitle() ?> </h2>
              <h3 class="card-text"><?= $this->var['post']->getResume() ?></h3>
              <p class="card-text"><?= $this->var['post']->getContent() ?></p>
              <p class="infos">
                Posté par 
                <a href="<?= $this->router->generate('author',['id' => $this->var['post']->getAuthorId()]);?>" class="card-link"><?= $this->var['post']->getAuthorName();?></a> 
                le <time><?= $this->var['post']->getCreatedAt();?></time> 
                dans <a href="<?= $this->router->generate('category',['id' => $this->var['post']->getCategoryId()]);?>" class="card-link">#<?= str_replace(' ', '', $this->var['post']->getCategoryName());?></a>
              </p>
            </div>
          </article>
        </main>

        <?php $this->include('aside') ?>
      </div><!-- /.row -->
