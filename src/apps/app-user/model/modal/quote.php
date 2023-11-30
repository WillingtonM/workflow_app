<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$event_id           = (isset($_POST['event_id']))?sanitize($_POST['event_id']):'';

$event              = get_event_by_id($event_id);

$event_type         = (isset($_POST['type'])) ? $_POST['type'] : $event['event_type'];

$order              = get_order_by_event_id($event_id);               

if ($order) {
    
    $track_code     = $order['order_track_code'];
} else {
    $order_code     = generateRandomString(4, true);
    $event_prov     = (isset($provinces[$event['event_province']]['abrv'])) ? $provinces[$event['event_province']]['abrv'] : '';
    $name_start     = substr($event['event_user_name'], 0, 1) . substr($event['event_last_name'], 0, 1);
    $track_code     = $event_prov . '-' . $order_code . '-' . strtoupper($name_start);
    while (get_order_by_code($track_code)) {
        $track_code = generateRandomString();
    }
}

// modal variables
$modal_id         = 'quote';
$modal_title      = '';
$modal_size       = 'modal-lg';

$modal_backdrop   = true;
$modal_screen     = 'modal-fullscreen-md-down';
$modal_centered   = 'modal-dialog-centered';
$modal_scrollable = 'modal-dialog-scrollable';
