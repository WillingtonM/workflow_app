<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col text-center mb-3">
        <img class="img text-center" src="<?= PROJECT_LOGO_SMALL ?>" alt="<?= PROJECT_TITLE ?> Logo" width="150px" height="150px">
    </div>

    <div class="text-center text-dark mb-1">
        <p class="font-weight-bolder fs-5">Request a demo account </p>
    </div>

    <div class="col-12 bg-light border-radius-xl p-3">
        <?php require $config['PARSERS_PATH'] . 'forms' . DS . 'signup.php' ?>
    </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script defer src="./js/custom/login.js"></script>
