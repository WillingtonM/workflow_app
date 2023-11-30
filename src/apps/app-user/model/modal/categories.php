<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$office_id          = (isset($_SESSION['office_id']) && $_SESSION['office_id'] != null)?$_SESSION['office_id']:0;
$company_id         = (isset($_SESSION['company_id']) && $_SESSION['company_id'] != null)?$_SESSION['company_id']:0;

$usrt_qry           = get_categories();
$category_id        = (isset($_POST['category_uid'])) ? $_POST['category_uid'] : '';

$req_res            = get_category_by_id($category_id);
$user_tab           = (!empty($req_res)) ? 'add_category' : '';

// modal variables
$modal_id           = 'categories';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
