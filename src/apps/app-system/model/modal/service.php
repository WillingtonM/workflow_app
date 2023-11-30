<?php

$key                = 'charter';

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$service_id         = (isset($_POST['service']))? $_POST['service']:'';
$service            = get_service_by_id($service_id);

$hour               = date('H');
$minute             = (date('i') > 30) ? '60' : '30';
$time_round         = "$hour:$minute";

$date_norm          = date("Y-m-d");

$min_date           = date(DATE_FORMAT, strtotime($date_norm . ' + 9 hours'));
$max_date           = date(DATE_FORMAT, strtotime($date_norm . ' + 16 hours'));

$current_date       = date("Y-m-d H");
// $current_date   = date(DATE_FORMAT, strtotime($current_date . ' + ' . $minute . ' minute'));
$current_date       = date(DATE_FORMAT, strtotime($date_norm . ' ' . $time_round));
$date_check         = ($min_date <= $current_date && $current_date <= $max_date) ? false : true;



// modal variables
$modal_id           = 'service';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';