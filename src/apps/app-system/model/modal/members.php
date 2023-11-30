<?php

$usr_arr            = null;
$last_key           = null;
$is_admin           = is_admin_check();
$subscription       = company_subscription();
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';

$practice_id        = (isset($_POST['practice']) && !empty($_POST['practice'])) ? $_POST['practice'] : 1;

$practice_tasks     = get_practice_tasks_by_practice($practice_id);

$offices            = get_offices_by_company($company_id);

if (isset($_POST['member']) && $_POST['member'] !== 'add' ) :

    $user_id        = $_POST['member'];
    $usr_arr        = get_client_association_by_id($user_id);

    $name                       = (isset($usr_arr['association_name'])) ? $usr_arr['association_name'] : '';
    $name_other                 = (isset($usr_arr['association_name_other'])) ? $usr_arr['association_name_other'] : '';
    $association_description    = (isset($usr_arr['association_description'])) ? $usr_arr['association_description'] : '';
    $association_reference      = (isset($usr_arr['association_reference'])) ? $usr_arr['association_reference'] : '';
    $association_identity       = (isset($usr_arr['association_identity'])) ? $usr_arr['association_identity'] : '';

    $first_key      = get_activity_tasks_by_client_association_id($user_id);
    $last_task      = get_activity_tasks_by_client_association_id($user_id, false);
endif;

var_dump($last_key);

// modal variables
$modal_id           = 'members';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
