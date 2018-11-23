      <!-- Je crée une nouvelle ligne dans ma grille virtuelle: https://getbootstrap.com/docs/4.1/layout/grid/-->
      <div class="row">
      <?php if(isset($this->var['id'])) : ?>
        <main class="col-lg-9" data-<?=$this->getVar('type');?>="<?= $this->getVar('id');?>">
      <?php else : ?>
      <main class="col-lg-9">
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

          <!-- Je met un element de navigation: https://getbootstrap.com/docs/4.1/components/pagination/ -->
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-between">
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-arrow-left"></i> Previous</a></li>
              <li class="page-item"><a class="page-link" href="#">Next <i class="fas fa-arrow-right"></i></a></li>
            </ul>
          </nav>

        </main>

        <?php $this->includeOne('/layout/aside') ?>
      </div><!-- /.row -->