<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div id="contactModal" class="row">

    <div id="bookingForm" class="col-12/" style="padding-top: 0; margin-top: 0;">
        <div class="rounded-0/">
            <div class="col-12">
                <div class="text-center py-2">
                    <h3 class="text_default" style="font-weight: bolder;">
                        <?= $booking_types[$event_type]['short'] ?>
                    </h3>
                    <small class="m-0 alt2_color">
                        <?= $booking_types[$event_type]['long'] ?>
                    </small>
                </div>
            </div>
            <br>
            <?php require_once $config['PARSERS_PATH'] . 'bookings' . DS . $event_type . '_form.php' ?>

            <!-- <?php require_once $config['PARSERS_PATH'] . 'bookings' . DS . 'booking_form.php' ?> -->
        </div>
    </div>

</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>