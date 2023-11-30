<?php

$req_res            = null;
$is_admin           = is_admin_check();
$subscription       = company_subscription();

$intval             = 25;
$article_type       = 'guest';
$page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
$user_id            = (isset($_SESSION['user_id'])) ? $_SESSION['user_id']:'';

$user_sql           = (!$is_admin) ? "AND reg.registry_user_id = " . $user_id : '';
$regs_sql           = (!$is_admin) ? "AND registry_user_id = " . $user_id : '';

// registry search 
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search         = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';

    $req_sql        = "SELECT * FROM registry reg INNER JOIN users  u ON reg.registry_user_id = u.user_id WHERE u.name LIKE '%$search%' OR u.last_name LIKE '%$search%' OR reg.registry_comment LIKE '%$search%' OR u.username LIKE '%$search%' AND reg.registry_status = 1 ". $user_sql ." ORDER BY reg.registry_date_created DESC LIMIT 50";

    $req_dta        = [];
    $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
}
