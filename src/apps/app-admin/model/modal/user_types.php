<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$office_id          = (isset($_SESSION['office_id']) && $_SESSION['office_id'] != null)?$_SESSION['office_id']:0;
$company_id         = (isset($_SESSION['company_id']) && $_SESSION['company_id'] != null)?$_SESSION['company_id']:0;

$usrt_qry           = get_user_types();
$user_type_id       = (isset($_POST['user_type_uid'])) ? $_POST['user_type_uid'] : '';

$req_res            = get_user_type_by_id($user_type_id);
$user_tab           = (!empty($req_res)) ? 'add_user_type' : '';

$dft_user_type      = (isset($_POST['user_type']))? $_POST['user_type']:'';

$user_id            = (isset($_POST['id'])) ? $_POST['id'] : ((isset($_POST['user_id'])) ? $_POST['user_id'] : '');

$usr_arr            = get_user_by_id($user_id);

// modal variables
$modal_id           = 'user_types';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
