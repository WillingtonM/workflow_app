<?php

// practice areas
$is_admin       = is_admin_check();
$company_id     = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
$subscription   = company_subscription();

if (isset($_GET['stage']) && !empty($_GET['stage'])) {
    $_SESSION['setup_stage'] = (int) $_GET['stage'];
}
$_SESSION['setup_stage'] = 1;
$stage          = (isset($_SESSION['setup_stage'])) ? $_SESSION['setup_stage'] : NULL;

if (isset($_GET['setup']) && $_GET['setup'] == 'complete') {
    $sql        = "UPDATE companies SET company_complete = 1 WHERE company_id = ? LIMIT 1";
    $dta        = [$company_id]; 
    if (prep_exec($sql, $dta, $sql_request_data[2])) {
        unset($_SESSION['setup_stage']);
        unset($_SESSION['company_setup']);

        redirect_to('associations');
    }
}

if(!isset($_SESSION['is_admin']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == FALSE)):
    redirect_to('home');
endif;

$practices      = NULL;
$practice_tasks = NULL;

$company        = get_company_by_id($company_id);
if ($company) {
    $offices    = get_offices_by_company($company['company_id']);
}


$usr_sql        = "SELECT * FROM users WHERE user_status = 1 AND user_type != 'guest' AND company_id = ? ORDER BY date_created DESC";
$usr_dta        = [$company_id];
$usr_qry        = prep_exec($usr_sql, $usr_dta, $sql_request_data[1]);
