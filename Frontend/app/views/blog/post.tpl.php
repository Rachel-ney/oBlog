      <!-- Je crée une nouvelle ligne dans ma grille virtuelle: https://getbootstrap.com/docs/4.1/layout/grid/-->
      <div class="row">
      <?php if(isset($this->var['id'])) : ?>
        <main class="col-12 col-md-8 col-lg-7 mx-auto" data-<?=$this->getVar('type');?>="<?= $this->getVar('id');?>">
      <?php else : ?>
      <main class="col-12">
      <?php endif; ?>
          <!-- Je dispose une card: https://getbootstrap.com/docs/4.1/components/card/ -->
          <article class="card d-none">
            <div class="card-body">
              <h2 class="card-title"> <a href="">Titre</a> </h2>
              <p class="card-text">Resume</p>
              <p class="infos">
                Posté par 
                <a href="" class="card-link">Auteur</a>
                le <time>date</time> 
                dans <a href="" class="card-link">#Category</a>
              </p>
            </div>
          </article>
        </main>

        <?php $this->includeOne('/layout/aside') ?>
      </div><!-- /.row -->