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
        <input type="hidden" name="form_type" value="register_form">
        <input type="hidden" name="event" value="<?= ((isset($event['event_id'])) ? $event['event_id'] : '') ?>">
        <input type="hidden" name="order" value="<?= ((isset($order['order_id'])) ? $order['order_id'] : '') ?>">

        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
                <input type="text" class="form-control shadow-none" name="name" value="<?= (isset($event['event_user_name'])) ? $event['event_user_name'] : '' ?>" placeholder="Name" disabled>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
                <input type="text" class="form-control shadow-none" name="last_name" value="<?= (isset($event['event_last_name'])) ? $event['event_last_name'] : '' ?>" placeholder="Last Name" disabled>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-envelope input_color"></i></span>
                <input type="email" class="form-control shadow-none" name="booking_email" value="<?= (isset($event['event_user_email'])) ? $event['event_user_email'] : '' ?>" placeholder="Email" disabled>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-2">
                <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-phone input_color"></i></span>
                <input type="tel" class="form-control shadow-none" name="booking_phone" value="<?= (isset($event['event_user_phone'])) ? $event['event_user_phone'] : '' ?>" placeholder="Contact number" disabled>
            </div>
        </div>
        <?php if (isset($_SESSION['active_app']) && $_SESSION['active_app'] != 'consulting') : ?>
            <div class="col-12">
                <div class="input-group mb-2">
                    <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-building input_color"></i></span>
                    <input type="text" class="form-control shadow-none" name="event_company_name" value="<?= (isset($event['event_company_name'])) ? $event['event_company_name'] : '' ?>" placeholder="Company name" disabled>
                </div>
            </div>
        <?php endif; ?>

    </form>

    <hr class="horizontal dark mt-0">

    <form id="<?= $b_form_msg ?>" class="form-group mt-3">

        <div class="form-floating mb-3">
            <input type="text" name="order_amount" class="form-control shadow-none" id="order_amount" value="<?= (isset($order['order_amount'])) ? $order['order_amount'] : '' ?>" placeholder="Order Amount">
            <label for="floatingInput"> Order Amount </label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="track_code" class="form-control shadow-none disabled" id="track_code" value="<?= $track_code ?>" placeholder="Tracking Code">
            <label for="floatingInput"> Tracking Code </label>
        </div>

        <h6 class="text-dark mb-3 px-3">
            Delivery Status
        </h6>

        <fieldset id="delivery_status" class="mb-3">
        <?php $count = 0 ?>
        <?php foreach ($courier_track as $key => $value) : ?>
            <?php $count ++ ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input delivery_state" name="<?= $key ?>" type="checkbox" id="inlineCheckbox<?= $count ?>" value="<?= $count ?>" <?= (isset($order['order_' . $key]) && $order['order_' . $key] ) ? 'checked' : '' ?>>
                <label class="form-check-label" for="inlineCheckbox<?= $count ?>"><?= $value['short'] ?></label>
            </div>
        <?php endforeach; ?>
        </fieldset>

        <div class="form-floating mb-3 has-validation">
            <textarea id="" class="form-control shadow-none border-radius-none" name="order_message" rows="4" cols="100" value="" placeholder="Message"><?= ((isset($order['order_message'])) ? htmlspecialchars($order['order_message']) : '') ?></textarea>
            <label for="order_message"> Message </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                <span> Message </span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid message">
        </div>

    </form>

    <div id="<?= $bookng_msg ?>" class="my-3"></div>

    <button type="button" class="btn btn-secondary col-12" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('<?= $bookng_msg ?>', $('#<?= $b_form_usr ?>').serialize() + '&' + $('#<?= $b_form_msg ?>').serialize() + '&' + $('.<?= $b_form_pne ?>.tab-pane.active').serialize(), 0, true);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= (isset($_SESSION['user_id']) && !empty($order) ) ? 'Update Quotation' : 'Register Quotation' ?> </button>
    <br>

    <div class="col-12 text-center">
        <small style="color: #999; font-size: .8rem;">
            Please note that any collected identifying information will be encrypted and stored in a password protected electronic format, thus you can rest assured that your identifying information will be securely stored
        </small>
    </div>
    <br>

</div>


<script>

    $('.delivery_state').on('click', function(){
        var del_id  = $(this).attr("id");
        var del_val = parseInt($('#'+del_id).val());

        $('.delivery_state').prop('checked', false);
        console.log(del_val);
        var indexed = 0;
        for (let index = 0; index < del_val; index++) {
            console.log(index);
            indexed = index + 1;
            $('#inlineCheckbox'+indexed).prop('checked', true);
        }

    });

</script>
