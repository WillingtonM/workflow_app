<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div id="contactModal" class="row">

    <div id="bookingForm" class="col-12/" style="padding-top: 0; margin-top: 0;">
        <div class="rounded-0/">
            <div class="col-12/ p-0">
                <br>
                <div class="text-center py-2">
                    <h3 class="text_default" style="font-weight: bolder;"> Register Quotation </h3>
                    <small class="m-0 alt2_color" style="font-weight: 600; font-size:medium;"> You may Edit the quotation information </small>
                </div>
            </div>
            <br>
            <?php require_once $config['PARSERS_PATH'] . 'bookings' . DS . 'makequote_form.php' ?>
        </div>
    </div>

</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>
