<?php

$data               = [];
// modal variables
$modal_id           = 'modal_alert';
$modal_title        = '';
$modal_size         = '';

$modal_backdrop     = false;
// $modal_screen     = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
// $modal_scrollable = 'modal-dialog-scrollable';

$modal_type         = (isset($_POST['modal_type'])) ? $_POST['modal_type'] : '';

$data['alert']      = (isset($_POST['modal_err']) && $_POST['modal_err']) ? 'alert_warning' : 'alert_success';
$data['message']    = (isset($_POST['modal_msg']) && !empty($_POST['modal_msg'])) ? $_POST['modal_msg'] : '';
