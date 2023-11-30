<?php $b_form_usr = ((isset($page) && $page == 'bookings') ? 'booking_form_user_pg' : 'booking_form_user') ?>
<?php $b_form_pne = ((isset($page) && $page == 'bookings') ? 'tab_pane_pg' : 'tab_pane') ?>
<?php $b_form_msg = ((isset($page) && $page == 'bookings') ? 'booking_form_message_pg' : 'booking_form_message') ?>
<?php $bookng_msg = ((isset($page) && $page == 'bookings') ? 'message_booking_pg' : 'message_booking') ?>

<div class="card-body p-3">

    <?php
    $hour           = date('H');
    $minute         = (date('i') > 30) ? '60' : '30';
    $time_round     = "$hour:$minute";

    $date_norm      = date("Y-m-d");

    $min_date       = date(DATE_FORMAT, strtotime($date_norm . ' + 9 hours'));
    $max_date       = date(DATE_FORMAT, strtotime($date_norm . ' + 16 hours'));

    $current_date   = date("Y-m-d H");
    // $current_date   = date(DATE_FORMAT, strtotime($current_date . ' + ' . $minute . ' minute'));
    $current_date   = date(DATE_FORMAT, strtotime($date_norm . ' ' . $time_round));
    $date_check     = ($min_date <= $current_date && $current_date <= $max_date) ? false : true;

    ?>

    <form id="<?= $b_form_usr ?>" class="form-row align-items-center">
        <input type="hidden" name="form_type" value="booking_form">
        <input type="hidden" name="event" value="<?= ((isset($event['event_id'])) ? $event['event_id'] : '') ?>">

        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
                <input type="text" class="form-control shadow-none" name="name" value="<?= (isset($event['event_user_name'])) ? $event['event_user_name'] : '' ?>" placeholder="Name" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
                <input type="text" class="form-control shadow-none" name="last_name" value="<?= (isset($event['event_last_name'])) ? $event['event_last_name'] : '' ?>" placeholder="Last Name" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-envelope input_color"></i></span>
                <input type="email" class="form-control shadow-none" name="booking_email" value="<?= (isset($event['event_user_email'])) ? $event['event_user_email'] : '' ?>" placeholder="Email" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-phone input_color"></i></span>
                <input type="tel" class="form-control shadow-none" name="booking_phone" value="<?= (isset($event['event_user_phone'])) ? $event['event_user_phone'] : '' ?>" placeholder="Contact number">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-building input_color"></i></span>
                <input type="text" class="form-control shadow-none" name="event_company_name" value="<?= (isset($event['event_company_name'])) ? $event['event_company_name'] : '' ?>" placeholder="Company name">
            </div>
        </div>

        <input type="hidden" name="event_type" value="enquiry">
    </form>

    <hr class="horizontal dark mt-0">

    <form id="<?= $b_form_msg ?>" class="form-group mt-3">
        <div class="input-group mb-3">
            <span class="input-group-text text-warning" style="border-right: none;"><i class="far fa-comment-dots input_color"></i></span>
            <textarea class="form-control shadow-none" id="booking_message" name="booking_message" placeholder="Message ..." rows="4" required><?= ((isset($event['event_message'])) ? $event['event_message'] : '') ?></textarea>
        </div>
        <?php if (isset($_SESSION['user_id']) && isset($event)) : ?>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" name="booking_complete" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?= ($event['event_processed'] == 1) ? 'checked' : '' ?> <label class="form-check-label" for="flexSwitchCheckChecked">Mark as Complete</label>
            </div>
        <?php endif; ?>
    </form>

    <div id="<?= $bookng_msg ?>" class="mt-3"></div>
    <button type="button" class="btn btn-dark col-12" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('<?= $bookng_msg ?>', $('#<?= $b_form_usr ?>').serialize() + '&' + $('#<?= $b_form_msg ?>').serialize() + '&' + $('.<?= $b_form_pne ?>.tab-pane.active').serialize(), 0, true);"> <?= (isset($_SESSION['user_id']) ? 'Submit Enquiry Changes' : 'Submit Enquiry Form') ?> </button>
    <br>

    <div class="col-12 text-center">
        <small style="color: #999; font-size: .8rem;">
            Please note that any collected identifying information will be encrypted and stored in a password protected electronic format, thus you can rest assured that your identifying information will be securely stored
        </small>
    </div>
    <br>

</div>