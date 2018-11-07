<div class="row">
    <main class="col-lg-9">
        <?php if (isset($this->var['postFromCategory'])) : ?>

            <h3>Tout les articles de la catégorie <?=$this->var['postFromCategory'][0]->getCategoryName(); ?></h3>

            <?php foreach ($this->getVar('postFromCategory') as $currentPost) : ?>
                <!-- Je dispose une card: https://getbootstrap.com/docs/4.1/components/card/ -->
                <article class="card">
                    <div class="card-body">
                    <h2 class="card-title"><?= $currentPost->getTitle() ?></h2>
                    <p class="card-text"><?= $currentPost->getResume() ?></p>
                    <p class="infos">
                        Posté par 
                        <a href="<?= $this->router->generate('author', ['id'=> $currentPost->getAuthorId()]); ?>" class="card-link"><?= $currentPost->getAuthorName() ?></a> le <time><?= $currentPost->getCreatedAt() ?></time> 
                        dans <a href="<?= $this->router->generate('category', ['id'=> $currentPost->getCategoryId()]); ?>" class="card-link">#<?= str_replace(' ', '', $currentPost->getCategoryName()) ?></a>
                    </p>
                    </div>
                </article>
            <?php endforeach; ?>
            
        <?php else : ?>
        <h3>Cette catégorie n'a pas encore été utilisé par nos auteurs</h3>
        <?php endif; ?>
    </main>
<?php $this->include('aside') ?>
</div>