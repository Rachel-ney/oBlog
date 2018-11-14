<?php if (!isset($_SESSION['idUser'])) : ?>
<div class="row">
    <main class="col-lg-9">
        <h3>Ou vas tu petit malin ?</h3>
        <p>Il faut être inscrit pour avoir accès à la page mon compte</p>
        <p>Tu peux t'inscrire <a href="<?= $this->router->generate('signIn');?>"> ici </a></p>
        
    </main>
</div>
<?php $this->includeOne('aside') ?>
<?php else : ?>
<div class="row">
    <main class="col-lg-9">
        <h3>Mon compte</h3>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sapiente, neque odit eveniet et earum culpa voluptatem voluptatum, laborum maxime praesentium, omnis aut. Temporibus consectetur corrupti accusamus, laboriosam iusto porro similique maxime eligendi, placeat suscipit recusandae provident in aperiam, inventore praesentium voluptatibus explicabo officia reprehenderit sed. Maiores vel numquam ullam libero?</p>
        
    </main>
<?php $this->includeOne('aside') ?>
</div>
<?php endif; ?>