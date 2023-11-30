<?php $b_form_usr = ((isset($page) && $page == 'bookings') ? 'booking_form_user_pg' : 'booking_form_user') ?>
<?php $b_form_pne = ((isset($page) && $page == 'bookings') ? 'tab_pane_pg' : 'tab_pane') ?>
<?php $b_form_msg = ((isset($page) && $page == 'bookings') ? 'booking_form_message_pg' : 'booking_form_message') ?>
<?php $bookng_msg = ((isset($page) && $page == 'bookings') ? 'message_booking_pg' : 'message_booking') ?>

<div class="card-body p-3">

    <hr class="horizontal dark mt-0">

    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="notif_tab">
                <?php $array_count = 0; ?>
                <?php foreach ($courier_portal_navba as $key => $nav) : ?>

                    <?php $array_count++; ?>
                    <?php if (isset($_SESSION['user_id']) && isset($event_type) && $key != $event_type) continue ?>

                    <form class="<?= $b_form_pne ?> tab-pane fade <?= (((isset($event_type) && $event_type == $key) || (!isset($event_type) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
                        <div class="row notif_content">
                            <div class="col-12 shadow bg-white border-radius-xl p-3">
                                <?php require $config['PARSERS_PATH'] . 'bookings' . DS . $nav['path'] . '.php' ?>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 

</div>