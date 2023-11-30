<?php
$user_id            = null;
$user_type          = null;
$user               = null;
$req_sql            = null;
$req_res            = null;
$usr_arr            = null;
$last_key           = null;

$user_type          = (isset($_GET['usr_type']))? $_GET['usr_type']:'';
$crrnt_tab          = (isset($_GET['tab']))? $_GET['tab']:'';


$office_id          = (isset($_SESSION['office_id']) && $_SESSION['office_id'] != null)?$_SESSION['office_id']:0;
$company_id         = (isset($_SESSION['company_id']) && $_SESSION['company_id'] != null)?$_SESSION['company_id']:0;

$practices          = get_practice_areas_by_company($company_id);

$practice_count     = (is_array($practices) || is_object($practices)) ? count($practices) : 0;


$is_admin           = is_admin_check();
$subscription       = company_subscription();
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';

$practice_id        = (isset($_GET['practice']) && !empty($_GET['practice'])) ? $_GET['practice'] : 1;

$practice_tasks     = get_practice_tasks_by_practice($practice_id);

$offices            = get_offices_by_company($company_id);




if (isset($_GET['member']) && $_GET['member'] !== 'add' ) :

    $user_id        = $_GET['member'];
    $usr_arr        = get_client_association_by_id($user_id);

    $name                       = (isset($usr_arr['association_name'])) ? $usr_arr['association_name'] : '';
    $name_other                 = (isset($usr_arr['association_name_other'])) ? $usr_arr['association_name_other'] : '';
    $association_description    = (isset($usr_arr['association_description'])) ? $usr_arr['association_description'] : '';
    $association_reference      = (isset($usr_arr['association_reference'])) ? $usr_arr['association_reference'] : '';
    $association_identity       = (isset($usr_arr['association_identity'])) ? $usr_arr['association_identity'] : '';

    $first_key      = get_activity_tasks_by_client_association_id($user_id);
    $last_task      = get_activity_tasks_by_client_association_id($user_id, false);
endif;
