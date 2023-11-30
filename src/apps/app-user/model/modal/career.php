<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$career_id          = (isset($_POST['career'])) ? sanitize($_POST['career']) : '';
$type               = (isset($_POST['type'])) ? $_POST['type'] : '';

$vacancy            = ($type == 'vacancy') ? get_career_application_by_id($career_id): null;
$career             = (is_array($vacancy)) ? get_career_by_id($vacancy['career_id']) : get_career_by_id($career_id);

$mmodel_file        = (!empty($type) && $type == 'vacancy') ? 'vacancy' : 'career';

// modal variables
$modal_id           = 'career';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
