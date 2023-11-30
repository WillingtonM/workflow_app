<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$event_id           = (isset($_POST['event']))?sanitize($_POST['event']):'';

$event              = get_event_by_id($event_id);

$event_type         = (isset($_POST['type'])) ? $_POST['type'] : $event['event_type'];

// modal variables
$modal_id           = 'events';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
