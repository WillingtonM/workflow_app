<?php
$is_admin           = is_admin_check();
$subscription       = company_subscription();

$req_res            = NULL;
$tabbs_count        = 0;
$allowed_db         = array('associations', 'client_associations');

$user_id            = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';

$intval             = 25;
$page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

$company_id         = get_company_id();
$subscription       = company_subscription();

// search
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search         = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';

    $req_sql        = "SELECT * FROM task_history th INNER JOIN tasks ts ON ts.task_id = th.task_id WHERE th.user_id = ? AND ts.task_name LIKE '%$search%' OR th.details LIKE '%$search%' OR ts.task_text LIKE '%$search%' OR ts.task_priority LIKE '%$search%' AND ts.company_id = ? AND ts.task_status = 1 ORDER BY th.history_date_created DESC LIMIT 35";
    $req_dta        = [$user_id, $company_id];
    $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
}

$user_activities    = get_task_histories_long($user_id);
$artcl_count        = count($user_activities); 

$page_count         = ceil(($artcl_count / $intval));
$sql_pg_strt        = (int)($page_nmb - 1) * $intval;

$task_history       = get_task_histories_long($user_id, $intval, $sql_pg_strt);
