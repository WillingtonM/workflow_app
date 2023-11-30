<?php

$practice           = ''; 
$is_admin           = is_admin_check();
$subscription       = company_subscription();
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';


if(isset($_POST['user_id'])) {
    $rgst_dta       = [];
    $user_id        = $_POST['user_id'];

    $practice       = get_user_by_id($user_id);
}


// modal variables
$modal_id           = 'practice_task';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';