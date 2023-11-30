<?php

$user_id        = null;
$user_type      = null;
$user           = null;
$req_sql        = null;
$req_res        = null;
$is_admin       = is_admin_check();
$subscription   = company_subscription();

$user_type      = (isset($_GET['usr_type']))? $_GET['usr_type']:'';
$crrnt_tab      = (isset($_GET['tab']))? $_GET['tab']:'';


$office_id      = (isset($_SESSION['office_id']) && $_SESSION['office_id'] != null)?$_SESSION['office_id']:0;
$company_id     = (isset($_SESSION['company_id']) && $_SESSION['company_id'] != null)?$_SESSION['company_id']:0;

$practices      = get_practice_areas_by_company($company_id);

$practice_count = (is_array($practices) || is_object($practices)) ? count($practices) : 0;

if ($practice_count == 1) {
    foreach ($practices as $key => $practice) {
        $practice_id = $practice['practice_area_id'];
    }
} elseif($practice_count == 0) {
    $practice_id    = 1;
}

if (isset($_GET['usr'])) {
    $user_id        = $_GET['usr'];

    if ($user_type == 'client') {
        $user       = get_user_by_id($user_id);
        $clients    = get_association_by_user_id($user_id);
    } else { 
        $user       = get_client_association_by_id($user_id);
        $clients    = get_association_user_by_client_association_id($user_id);
    }
}

// search
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search         = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';
    $req_dta        = [];

    if ($user_type == 'client') {
        $req_sql    = "SELECT * FROM client_associations WHERE association_name LIKE '%$search%' OR association_name_other LIKE '%$search%' OR association_reference LIKE '%$search%' OR association_identity LIKE '%$search%' AND company_id = ".$company_id." AND client_association_status = 1 ORDER BY association_date_created DESC LIMIT 35";
    } else {
        $req_sql    = "SELECT user_id, name, last_name, username FROM users WHERE name LIKE '%$search%' OR last_name LIKE '%$search%' OR username LIKE '%$search%' AND company_id = ".$company_id." AND user_status = 1 ORDER BY username DESC LIMIT 35";
    }

    $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
}
