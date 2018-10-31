<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Nom</th>
            <th scope="col">Type</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($modelInfos as $character) : ?>
        <tr>
            <td> <img src="<?= $_SERVER['BASE_URI'] . '/assets/pictures/'. $character->getPicture();?>" alt="<?=$character->getName();?>">
            </td>
            <td><?= $character->getName(); ?></td>
            <td><?= $character->type_name; ?></td>
            <td><?= $character->getDescription(); ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>