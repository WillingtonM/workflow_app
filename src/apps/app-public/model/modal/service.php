<?php

$service = (isset($_POST['service']) && !empty($_POST['service'])) ? $_POST['service'] : '';

if (array_key_exists($service, $services_navba)) {
    
}


// modal variables
$modal_id         = 'service';
$modal_title      = '';
$modal_size       = 'modal-lg';

$modal_backdrop   = false;
$modal_screen     = 'modal-fullscreen-md-down';
$modal_centered   = 'modal-dialog-centered';
$modal_scrollable = 'modal-dialog-scrollable';
