<?php foreach($modelInfos as $creator) : ?>
<div class="creator">
    <h3><?= $creator['name'] ?></h3>
    <h4>Bio :</h4>
    <p><?= $creator['bio']?></p>
    <h4>Mais encore... :</h4>
    <p><?= $creator['description']?></p>
</div>
<?php endforeach; ?>