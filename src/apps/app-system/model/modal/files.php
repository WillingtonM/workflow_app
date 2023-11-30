<?php
unset($_SESSION['media_id']);

$is_admin           = is_admin_check();
$subscription       = company_subscription();
$media_id 			= (isset($_POST['media_id']))?$_POST['media_id']:0;

$media_res 			= null;
if (!empty($media_id)) {
	$media_res 		= get_media_by_id($media_id);

	$dir_url  		= 'mediacontent' . DS .'gallery' . DS . $media_res['media_image'] . DS;
}

// modal variables
$modal_id         	= 'fileModal';
$modal_title      	= ($media_id) ? '<i class="fa fa-edit"></i> Document | <i class="text-danger">' . $media_res['media_title'] . '</i>' : '<i class="fa fa-plus"></i> Add Document';
$modal_size       	= 'modal-lg';

$modal_backdrop   	= true;
$modal_screen     	= 'modal-fullscreen-md-down';
$modal_centered   	= 'modal-dialog-centered';
$modal_scrollable 	= 'modal-dialog-scrollable';
