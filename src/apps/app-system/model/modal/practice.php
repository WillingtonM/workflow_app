<?php

$practice           = ''; 
$is_admin           = is_admin_check();
$subscription       = company_subscription();

if(isset($_POST['practice'])) {
    
    $rgst_dta       = [];
    $practice_id    = $_POST['practice'];

    $practice       = get_practice_area_by_id($practice_id);

}


// modal variables
$modal_id           = 'practice';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';