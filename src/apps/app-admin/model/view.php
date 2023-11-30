<?php
$member             = null;
$is_admin           = is_admin_check();
$subscription       = company_subscription();

// practice areas
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';

$user_type          = (isset($_GET['usr_type']))? $_GET['usr_type']:'';

$task_id            = (isset($_GET['task']))? $_GET['task'] : '';
$task               = get_task_by_id($task_id);
$task_history       = get_task_histories($task_id);
$category           = get_category_by_id($task['category_id']);

