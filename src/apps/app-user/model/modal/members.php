<?php

$last_key           = null;
$is_admin           = is_admin_check();
$subscription       = company_subscription();
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';

$offices            = get_offices_by_company($company_id);

$user_id            = (isset($_POST['user'])) ? $_POST['user'] : '';
$usr_arr            = get_user_by_id($user_id);

$users_tasks        = get_tasks_by_assigned_id($user_id);
$tasks_completed    = get_completed_tasks_by_assigned_id($user_id);
$completed_tasks    = (!empty($tasks_completed))? count($tasks_completed) : 0; 

var_dump($users_tasks);

// modal variables
$modal_id           = 'members';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
