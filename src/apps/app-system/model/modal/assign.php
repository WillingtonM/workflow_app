<?php

$user_id            = (isset($_POST['user'])) ? $_POST['user'] : '';
$member_id          = (isset($_POST['member'])) ? $_POST['member'] : '';
$user_type          = (isset($_POST['user_type'])) ? $_POST['user_type'] : '';

$is_admin           = is_admin_check();
$subscription       = company_subscription();

$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
$practices          = get_practice_areas_by_company($company_id);

$practice_count     = (is_array($practices) || is_object($practices)) ? count($practices) : 0;

if ($practice_count == 1) {
    foreach ($practices as $key => $practice) {
        $practice_id = $practice['practice_area_id'];
    }
} elseif($practice_count == 0) {
    $practice_id    = 1;
}

if ($user_type == 'member') {
    $user           = get_user_by_id($user_id);
    $member         = get_client_association_by_id($member_id);
} else { 
    $user           = get_client_association_by_id($member_id);
    $member         = get_user_by_id($user_id);
}

// modal variables
$modal_id           = 'assign';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
