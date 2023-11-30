<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();

$task_id            = (isset($_GET['task_id']))?sanitize($_GET['task_id']):'';

$users              = get_all_user();
$checkers           = get_all_checkers();
$admins             = get_all_admins();

$task               = get_task_by_id($task_id);
$task_categories    = get_categories();


// date time
$hour               = date('H');
$minute             = (date('i') > 30) ? '60' : '30';
$time_round         = "$hour:$minute";

$date_norm          = date("Y-m-d");

$min_date           = date(DATE_FORMAT, strtotime($date_norm . ' + 9 hours'));
$max_date           = date(DATE_FORMAT, strtotime($date_norm . ' + 16 hours'));

$current_date       = date("Y-m-d H");
// $current_date   = date(DATE_FORMAT, strtotime($current_date . ' + ' . $minute . ' minute'));
$current_date       = date(DATE_FORMAT, strtotime($date_norm . ' ' . $time_round));
$date_check         = ($min_date <= $current_date && $current_date <= $max_date) ? false : true;
