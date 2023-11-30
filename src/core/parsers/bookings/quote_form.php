<?php $b_form_usr   = ((isset($page) && $page == 'bookings') ? 'booking_form_user_pg' : 'booking_form_user') ?>
<?php $b_form_pne   = ((isset($page) && $page == 'bookings') ? 'tab_pane_pg' : 'tab_pane') ?>
<?php $b_form_msg   = ((isset($page) && $page == 'bookings') ? 'booking_form_message_pg' : 'booking_form_message') ?>
<?php $bookng_msg   = ((isset($page) && $page == 'bookings') ? 'message_booking_pg' : 'message_booking') ?>

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
        <input type="hidden" name="form_type" value="quotation_form">
        <input type="hidden" name="booking_type" value="quotation">
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
        <?php if (isset($_SESSION['active_app']) && $_SESSION['active_app'] != 'consulting') : ?>
            <div class="col-12">
                <div class="input-group mb-2">
                    <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-building input_color"></i></span>
                    <input type="text" class="form-control shadow-none" name="event_company_name" value="<?= (isset($event['event_company_name'])) ? $event['event_company_name'] : '' ?>" placeholder="Company name">
                </div>
            </div>
        <?php endif; ?>

    </form>

    <hr class="horizontal dark mt-0">

    <form id="<?= $b_form_msg ?>" class="form-group mt-3 bg-white border-radius-xl py-3">
        <h6 class="text-dark mb-3 px-3">
            Collection & Delivery Details
        </h6>

        <div class="col-auto mb-3">
            <label for="" class="px-2 text-secondary">Delivery date</label>
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

        <div class="form-floating mb-2 has-validation">
            <textarea id="mytextarea/" class="form-control shadow-none border-radius-none" name="event_description" rows="4" cols="100" value="" placeholder="Parcel Description" style=""><?= ((isset($event['event_description'])) ? htmlspecialchars($event['event_description']) : '') ?></textarea>
            <label for="event_description"> Parcel Description </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span> Parcel Description</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Event Description">
        </div>

        <div class="form-floating mb-2 has-validation">
            <textarea id="mytextarea/" class="form-control shadow-none border-radius-none" name="collection_addresss" rows="4" cols="100" value="" placeholder="Collection Address" style=""><?= ((isset($event['collection_addresss'])) ? htmlspecialchars($event['collection_addresss']) : '') ?></textarea>
            <label for="collection_addresss"> Collection Address </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span> Collection Address</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Event Description">
        </div>

        <div class="form-floating mb-2 has-validation">
            <textarea id="mytextarea/" class="form-control shadow-none border-radius-none" name="delivery_address" rows="4" cols="100" value="" placeholder="Event Description" style=""><?= ((isset($event['delivery_address'])) ? htmlspecialchars($event['delivery_address']) : '') ?></textarea>
            <label for="delivery_address"> Delivery Address </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span> Delivery Address</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Event Description">
        </div>

        <div class="form-floating mb-2 has-validation">
            <select class="form-select shadow-none" id="event_province" name="event_province" placeholder="Select Country"">
                <option value=""> Select Province </option>
                <?php foreach ($provinces AS $province_key => $province): ?>
                    <option value="<?= $province_key ?>" <?= (isset($event['event_province']) && $event['event_province'] == $province_key ) ? 'selected':'' ?>> <?= $province['name'] ?> </option>
                <?php endforeach ; ?>
            </select>
            <label for="event_province"> Province </label>
            <div id="event_provinceFeedback" class="valid-feedback ps-3 mt-0">
                <span> Province</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Province">
        </div>

        <div class="form-floating mb-2 has-validation">
            <select class="form-select shadow-none" id="event_country" name="event_country" placeholder="Select Country"">
                <?php foreach ($countries_array AS $country_key => $country): ?>
                    <option value="<?= $country_key ?>" <?= (($country_key == "ZA" && !isset($event['event_country'])) || (isset($event['event_country']) && $event['event_country'] == $country_key ) ) ? 'selected':'' ?>> <?= $country ?> </option>
                <?php endforeach ; ?>
            </select>
            <label for="event_province"> Coutry </label>
            <div id="event_provinceFeedback" class="valid-feedback ps-3 mt-0">
                <span> Coutry</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Coutry">
        </div>

        <?php if (isset($_SESSION['user_id']) && isset($event)) : ?>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" name="booking_complete" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?= ($event['event_processed'] == 1) ? 'checked' : '' ?> <label class="form-check-label" for="flexSwitchCheckChecked">Mark as Complete</label>
            </div>
        <?php endif; ?>
    </form>

    <div class="mt-3">
        <div id="<?= $bookng_msg ?>" class=""></div>
    </div>

    <div class="col-12 py-3">
        
        <button type="button" class="btn btn-secondary btn-sm/ col-12" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('<?= $bookng_msg ?>', $('#<?= $b_form_usr ?>').serialize() + '&' + $('#<?= $b_form_msg ?>').serialize() + '&' + $('.<?= $b_form_pne ?>.tab-pane.active').serialize(), 0, true);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= (isset($_SESSION['user_id']) ? 'Submit Booking' : 'Request Quotation') ?> </button>
    
        <?php if (isset($_SESSION['user_id'])) : ?>
            <a type="button" class="btn btn-sm/ btn-warning shadow-none article_nav article_active float-end/" onclick="requestModal(post_modal[18], post_modal[18], {'type':'<?= $key ?>', 'event_id':<?= $event_id ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-calendar-check me-2"></i> <span> <?= ($order) ? 'Edit': 'Register' ?> Quotation </span> </a>
        <?php endif ?>
    </div>

    <br>

    <div class="col-12 text-center">
        <small style="color: #999; font-size: .8rem;">
            Please note that any collected identifying information will be encrypted and stored in a password protected electronic format, thus you can rest assured that your identifying information will be securely stored
        </small>
    </div>
    <br>

</div>