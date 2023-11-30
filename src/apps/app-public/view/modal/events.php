<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col text-center">
        <img class="img text-center" src="<?= PROJECT_LOGO_SMALL ?>" alt="<?= PROJECT_TITLE ?> Logo" height="150px">
    </div>
    <br>
    <div class="col-12">
        <div class="text-center py-2">
            <h3 class="text_default" style="font-weight: bolder;">
                <?= $booking_types[$event_type]['short'] ?>
            </h3>
            <small class="m-0 alt2_color"> <?= $booking_types[$event_type]['long'] ?> </small>
        </div>
    </div>
    <br>
    <div class="col-12 p-3 shadow border-radius-xl bg-light">
        <?php require_once $config['PARSERS_PATH'] . 'bookings' . DS . $event_type . '_form.php' ?>
    </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script>
    $('.nav-modal').on('click', function() {
        change_bg()
    });
</script>