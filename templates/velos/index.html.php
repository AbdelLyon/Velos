<?php foreach ($velos as $velo) : ?>
    <a class='card list' href='/?type=velo&action=show&id=<?= $velo->getId() ?>'>
        <div class='d-flex flex-column align-items-center'>
            <h5 class='fw-bold fs-6'> <?= $velo->getName() ?> </h5>
            <img height="200" src='assets/images/<?= $velo->getImage() ?>' />
        </div>
    </a>
<?php endforeach ?>