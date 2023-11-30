<div class="card-body p-3">
    <?php

    // use Cocur\Slugify\Slugify;

    $b_form_usr     = ((isset($page) && $page == 'bookings') ? 'booking_form_user_pg' : 'booking_form_user');
    $b_form_pne     = ((isset($page) && $page == 'bookings') ? 'tab_pane_pg' : 'tab_pane');
    $b_form_msg     = ((isset($page) && $page == 'bookings') ? 'booking_form_message_pg' : 'booking_form_message');
    $bookng_msg     = ((isset($page) && $page == 'bookings') ? 'message_booking_pg' : 'message_booking');
    $user_event     = get_user_by_email($event['event_user_email']);
    $rand_passw     = (!$user_event) ? generateRandomString() : '';
    $username       = (isset($user_event['username']) ) ? $slugify->slugify($user_event['username']) : $slugify->slugify($event['event_user_name']);

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
        <input type="hidden" name="form_type" value="create_user">
        <!-- <input type="hidden" name="user" value="<?= (isset($user_event)) ? $user_event['user_id'] : '' ?>"> -->
        <!-- <input type="hidden" name="company_id" value="<?= (isset($user_event)) ? $user_event['company_id'] : '' ?>"> -->
        <input type="hidden" name="event" value="<?= ((isset($event['event_id'])) ? $event['event_id'] : '') ?>">

        <?php require_once $config['PARSERS_PATH'] . 'forms' . DS . 'create_account.php' ?>

        <input type="hidden" name="event_type" value="enquiry">
    </form>

    <hr class="horizontal dark mt-0">

    <form id="<?= $b_form_msg ?>" class="form-group mt-3">
        <h5 class="text-warning text-center px-3 mb-3"> Manage account request </h5>

        <div class="form-floating mb-2 has-validation">
            <input id="username" type="text" name="username" value="<?= $username ?>" class="form-control shadow-none" autocomplete="username" placeholder="Username" required>
            <label for="username">Username</label>
            <div id="usernameFeedback" class="invalid-feedback ps-3 mt-0">
                Invalid username format
            </div>
        </div>
        <div class="form-floating mb-3 has-validation">
            <input id="create_password" type="text" name="password" value="<?= $rand_passw ?>" class="form-control shadow-none" placeholder="User password" required>
            <label for="create_password">User password</label>
            <div id="passwordFeedback" class="invalid-feedback ps-3 mt-0">
                Invalid user password format
            </div>
        </div>
        <!-- <div class="input-group mb-3">
            <span class="input-group-text text-warning" style="border-right: none;"><i class="far fa-comment-dots input_color"></i></span>
            <textarea class="form-control shadow-none" id="booking_message" name="booking_message" placeholder="Message ..." rows="4" required><?= ((isset($event['event_message'])) ? $event['event_message'] : '') ?></textarea>
        </div> -->
        <?php if (isset($_SESSION['user_id']) && isset($event)) : ?>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" name="booking_complete" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?= ($event['event_processed'] == 1) ? 'checked' : '' ?> <label class="form-check-label" for="flexSwitchCheckChecked">Mark as Complete</label>
            </div>
        <?php endif; ?>
    </form>

    <div id="<?= $bookng_msg ?>" class="mt-3"></div>
    <button type="button" class="btn btn-dark col-12" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('<?= $bookng_msg ?>', $('#<?= $b_form_usr ?>').serialize() + '&' + $('#<?= $b_form_msg ?>').serialize() + '&' + $('.<?= $b_form_pne ?>.tab-pane.active').serialize(), 0, true);"> <?= (isset($_SESSION['user_id']) ? 'Submit Enquiry Changes' : 'Submit Enquiry Form') ?> </button>

    <br>

</div>

