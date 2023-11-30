<?php

$practice           = ''; 
$is_admin           = is_admin_check();
$subscription       = company_subscription();
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
$practices          = get_practice_areas_by_company($company_id);
$tasks_count        = count_practice_tasks_by_company($company_id);


if(isset($_POST['practice_task'])) {
    
    $rgst_dta       = [];
    $practice_id    = $_POST['practice_task'];

    $practice       = get_practice_task_by_id($practice_id);
}


// modal variables
$modal_id           = 'practice_task';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';