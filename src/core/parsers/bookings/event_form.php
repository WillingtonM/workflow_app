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
        <input type="hidden" name="form_type" value="events_form">
        <input type="hidden" name="event_type" value="<?= $event_type ?>">
        <input type="hidden" name="event" value="<?= ((isset($event['event_id'])) ? $event['event_id'] : '') ?>">

        <div class="form-floating mb-2 has-validation">
            <input type="text" name="event_title" value="<?= ((isset($event['event_title'])) ? $event['event_title'] : '') ?>" class="form-control shadow-none" id="event_title" placeholder="Event Title" required>
            <label for="event_title"> Event Title </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span>Invalid Event Title</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Event Title">
        </div>

        <div class="form-floating mb-2 has-validation">
            <input type="text" name="event_venue" value="<?= ((isset($event['event_venue'])) ? $event['event_venue'] : '') ?>" class="form-control shadow-none" id="event_venue" placeholder="Event Venue" required>
            <label for="event_venue"> Event Venue </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span>Invalid Event Venue</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Event Venue">
        </div>

        <div class="form-floating mb-2 has-validation">
            <textarea id="mytextarea/" class="form-control shadow-none border-radius-none" name="event_description" rows="4" cols="100" value="" placeholder="Event Description" style=""><?= ((isset($event['event_description'])) ? htmlspecialchars($event['event_description']) : '') ?></textarea>
            <label for="event_description"> Event Description </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span>Invalid Event Description</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Event Description">
        </div>

        <div class="col-auto mb-3">
            <label for="" class="px-2 text-secondary">Event date</label>
            <div class="row g-3 mb-0">
                <div class="col-4 col-md-2/">
                    <div class="input-group">
                        <span class="input-group-text"> <i class="fas fa-calendar-day"></i> </span>
                        <?php $date_days = range(1, 31, 1) ?>
                        <select class="form-control shadow-none" name="dob">
                            <?php foreach ($date_days as $value) : ?>
                                <option value="<?= $value ?>" <?= ((isset($event['event_host_date']) && (int) date('d', strtotime($event['event_host_date'])) == $value) ? 'selected' : ((!isset($event['event_host_date']) && empty($event['event_host_date']) && $value == (int)date('d')) ? 'selected' : '')) ?>> <?= $value ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-4 col-md-2/">
                    <select class="form-control shadow-none" name="mob">
                        <?php foreach ($date_months as $val => $month) : ?>
                            <option value="<?= $val ?>" <?= ((isset($event['event_host_date']) && (int) date('m', strtotime($event['event_host_date'])) == $val) ? 'selected' : ((!isset($event['event_host_date']) && empty($event['event_host_date']) && $val == (int)date("m")) ? 'selected' : '')) ?>> <?= $month ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-4 col-md-2/">
                    <?php $date_days = range(date("Y"), 2090, -1) ?>
                    <select class="form-control shadow-none" name="yob">
                        <?php foreach ($date_days as $value) : ?>
                            <option value="<?= $value ?>" <?= ((isset($event['event_host_date']) && (int) date('Y', strtotime($event['event_host_date'])) == $value) ? 'selected' : ((!isset($event['event_host_date']) && empty($event['event_host_date']) && $value == date("Y")) ? 'selected' : '')) ?>> <?= $value ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </div>

        <div class="col-auto mb-3">
            <label for="" class="px-2 text-secondary">Event time</label>
            <div class="row g-3 mb-0">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"> <i class="fas fa-calendar-day me-2"></i> Start</span>
                        <?php $date_days = range(1, 24, 1) ?>
                        <select class="form-control shadow-none" name="start_hour">
                            <?php foreach ($date_days as $value) : ?>
                                <option value="<?= $value ?>" <?= ((isset($req_res['article_cronjob_date']) && (int) date('d', strtotime($req_res['article_cronjob_date'])) == $value) ? 'selected' : ((!isset($req_res['article_cronjob_date']) && empty($req_res['article_cronjob_date']) && $value == 6) ? 'selected' : '')) ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"> <i class="fas fa-calendar-day me-2"></i> End</span>
                        <?php $date_days = range(1, 24, 1) ?>
                        <select class="form-control shadow-none" name="end_hour">
                            <?php foreach ($date_days as $value) : ?>
                                <option value="<?= $value ?>" <?= ((isset($req_res['article_cronjob_date']) && (int) date('d', strtotime($req_res['article_cronjob_date'])) == $value) ? 'selected' : ((!isset($req_res['article_cronjob_date']) && empty($req_res['article_cronjob_date']) && $value == 6) ? 'selected' : '')) ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>

    </form>

    <hr class="horizontal dark mt-0">

    <?php if (isset($_SESSION['active_app']) && $_SESSION['active_app'] == 'cleaning') : ?>
        <label for=""> Select Cleaning Service Type</label>
        <br>
        <?php foreach ($cleaning_services_navba as $key => $tabs) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="service_type" id="service_type<?= $key ?>" value="<?= $key ?>">
                <label class="form-check-label" for="service_type<?= $key ?>"><?= $tabs['short'] ?></label>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <div id="<?= $bookng_msg ?>" class="mt-3"></div>
    <button type="button" class="btn btn-secondary me-3" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('<?= $bookng_msg ?>', $('#<?= $b_form_usr ?>').serialize() + '&' + $('#<?= $b_form_msg ?>').serialize() + '&' + $('.<?= $b_form_pne ?>.tab-pane.active').serialize(), 0, true);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= (isset($_SESSION['user_id']) ? 'Submit Event' : 'Submit Event') ?> </button>
    <?php if(isset($event_id) && !empty($event_id)): ?>
        <button type="button" class="btn btn-danger" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('<?= $bookng_msg ?>', {'form_type':'event_remove','event':<?= $event_id ?>}, 0);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Remove Event </button>
    <?php endif; ?>
    
    <br>

</div>