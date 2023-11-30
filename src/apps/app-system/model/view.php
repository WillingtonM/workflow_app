<?php
$member             = null;
$is_admin           = is_admin_check();
$subscription       = company_subscription();

// practice areas
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
$practices          = get_practice_areas_by_company($company_id);

$user_type          = (isset($_GET['usr_type']))? $_GET['usr_type']:'';

if (isset($_GET['usr']) && isset($_SESSION['user_id'])) {
    $member_id      = $_GET['usr'];

    $member         = get_client_association_by_id($member_id);
    $clients        = get_association_user_by_client_association_id($member_id);

    $office         = get_office_by_id((isset($member['office_id'])) ? $member['office_id'] : '');
}
