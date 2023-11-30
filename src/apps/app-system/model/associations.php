<?php

$req_res        = null;
$is_admin       = is_admin_check();
$subscription   = company_subscription();

$company_id     = (isset($_SESSION['company_id']) && $_SESSION['company_id'] != null)?$_SESSION['company_id']:0;
$office_id      = (isset($_SESSION['office_id']) && $_SESSION['office_id'] != null)?$_SESSION['office_id']:0;

// search
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search     = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';

    $req_sql    = "SELECT * FROM client_associations WHERE association_name LIKE '%$search%' OR association_name_other LIKE '%$search%' OR association_reference LIKE '%$search%' OR association_identity LIKE '%$search%' AND company_id = ".$company_id." AND client_association_status = 1 ORDER BY association_date_created DESC LIMIT 35";
    $req_dta    = [];
    $req_res    = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
}
