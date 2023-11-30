<?php
$is_admin           = is_admin_check();
$subscription       = company_subscription();

$req_res            = NULL;
$tabbs_count        = 0;
$allowed_db         = array('associations', 'client_associations');


$intval             = 25;
$page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

$company_id         = get_company_id();
$subscription       = company_subscription();

// search
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $search         = (isset($_GET['name'])) ? urldecode($_GET['name']) : '';

    $req_sql        = "SELECT * FROM task_history th INNER JOIN tasks ts ON ts.task_id = th.task_id WHERE ts.task_name LIKE '%$search%' OR th.details LIKE '%$search%' OR ts.task_text LIKE '%$search%' OR ts.task_priority LIKE '%$search%' AND ts.company_id = ? AND ts.task_status = 1 ORDER BY th.history_date_created DESC LIMIT 35";
    $req_dta        = [$company_id];
    $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
} else {
    $task_history   = get_task_histories_long();
    $artcl_count    = (is_array($task_history)) ? count($task_history) : 0; 
    
    $page_count     = ceil(($artcl_count / $intval));
    $sql_pg_strt    = (int)($page_nmb - 1) * $intval;
    
    
    $task_history   = get_task_histories_long(0, $intval, $sql_pg_strt);
}
