<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col text-center">
        <img class="img text-center border-radius-xl shadow-sm" src="./img/services/<?= $service ?>.jpg" alt="<?= $service ?>" height="250px">
    </div>
    <br>
    <div class="col-12">
        <div class="text-center py-2">
            <h3 class="text_default" style="font-weight: bolder;"> <?= $services_navba[$service]['short'] ?> </h3>
            <small class="m-0 alt2_color"> <?= $services_navba[$service]['long'] ?> </small>
        </div>
    </div>
    <br>
    <div class="col-12 p-3 shadow border-radius-xl bg-light">
        <div class="card-body p-3">
            <?php require_once $config['PARSERS_PATH'] . 'services' . DS . $service . '.php' ?>
        </div>
    </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>