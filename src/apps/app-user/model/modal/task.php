<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();

$task_id            = (isset($_POST['task_id']))?sanitize($_POST['task_id']):'';

$task               = get_task_by_id($task_id);
$task_categories    = get_categories();

if ($task) {
    $user           = get_user_by_id($task['user_id']);
    $date           = DateTime::createFromFormat('Y-m-d H:i:s', time());
    $deadline       = DateTime::createFromFormat('Y-m-d H:i:s', $task['task_deadline']);
    $task_date      = DateTime::createFromFormat('Y-m-d H:i:s', $task['task_date_created']);
    $category       = get_category_by_id($task['category_id']);
    $state          = ((isset($task['task_completed']) && $task['task_completed'] == 1) ? true : false);
    $is_due         = (($date >= $deadline) ? true : false);
}

// modal variables
$modal_id           = 'task';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
