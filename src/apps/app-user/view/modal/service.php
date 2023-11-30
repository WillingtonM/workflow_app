<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<form action="" id="routeForm">
    <div class="row">
        <div class="col-12 shadow-xl text-center mb-3">
            <h5 class="text-dark"> <i class="fas fa-map-marked-alt me-2"></i> Add Route </h5>
        </div>

        <div class="col-12">
            <?php require_once $config['PARSERS_PATH'] . 'bookings' . DS . 'charter.php' ?>
        </div>

        <div class="col-12" id="form_message"></div>

        <div class="col-12 py-3">
            <input type="hidden" name="form_type" value="route_form">
            <?php if (isset($service_id) && !empty($service_id)) : ?>
                <input type="hidden" name="service" value="<?=$service_id?>">
            <?php endif; ?>
            <a type="button" class="col-12 btn btn-dark border-radius-xl" onclick="postCheck('form_message', $('#routeForm').serialize(), 0, true)" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Add Route </a>

        </div>
    </div>
</form>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>