<?php

$req_res            = null;
$is_admin           = is_admin_check();
$company_id         = get_company_id();
$subscription       = company_subscription();

// search
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search         = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';
    $req_sql        = "SELECT * FROM tasks WHERE task_name LIKE '%$search%' OR task_text LIKE '%$search%' OR task_priority LIKE '%$search%' AND task_status = 1 AND company_id = ? ORDER BY task_date_updated DESC LIMIT 35";
    $req_dta        = [$company_id];
    $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
}