<?php

$user 				= null;
$is_admin           = is_admin_check();
$subscription       = company_subscription();
$subscription_id 	= (isset($_POST['subscrb_id']) && $_POST['subscrb_id'] != '')? $_POST['subscrb_id'] : null;

if ($subscription_id != null ) {
	$user 			= get_subscriber_by_id($subscription_id);
}

// modal variables
$modal_id         	= 'subscription';
$modal_title      	= '';
$modal_size       	= 'modal-lg';

$modal_backdrop   	= true;
$modal_screen     	= 'modal-fullscreen-md-down';
$modal_centered   	= 'modal-dialog-centered';
$modal_scrollable 	= 'modal-dialog-scrollable';
