<?php

$req_res            = null;
$is_admin           = is_admin_check();
$company_id         = get_company_id();
$subscription       = company_subscription();

// search
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search         = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';
    $req_sql        = "SELECT user_id, name, last_name, username FROM users WHERE name LIKE '%$search%' OR last_name LIKE '%$search%' OR username LIKE '%$search%' AND user_status = 1 AND company_id = ? ORDER BY date_created DESC LIMIT 35";
    $req_dta        = [$company_id];
    $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
}
