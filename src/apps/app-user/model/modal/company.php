<?php

$practice           = ''; 
$is_admin           = is_admin_check();
$subscription       = company_subscription();

$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
$type               = (isset($_POST['type']) && !empty($_POST['type'])) ? $_POST['type'] :'';

if ($type == 'company') {
    $company        = get_company_by_id($company_id);
    $offices        = get_offices_by_company($company_id);
}


if ($type == 'office') {
    $rgst_dta       = [];
    $office_id      = (isset($_POST['office'])) ? $_POST['office'] : '';

    $office         = get_office_by_id($office_id);
}

// modal variables
$modal_id           = 'company';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';