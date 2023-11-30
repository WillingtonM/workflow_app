<?php
$is_admin           = is_admin_check();
$subscription       = company_subscription();

if(isset($_POST['usr'])) {
    
    $rgst_dta       = [];
    $notif_id       = $_POST['usr'];
    $notif_msg      = $_POST['msg'];

    $notification   = get_notification_by_id($notif_id);
    $user           = get_user_by_id($notification['user_id']);

    $database       = $notification['notification_database'];
    $dtbs_id        = $notification['notification_database_id'];
    $dtbs_ind       = $notification['notification_message_index'];
    $dtbs_alt       = $notification['notification_alt_id'];
    $dtbs_msg       = (string) $notification['notification_message'];
    $db_stmt        = substr_replace($database, "", -1) . '_id = ' . $dtbs_id;

    $notif_user     = $user['name'] . ' ' . $user['last_name'];

    $db_query       = "SELECT * FROM $database WHERE $db_stmt LIMIT 1";
    $db_qry         = prep_exec($db_query, $rgst_dta, $sql_request_data[0]);

}


// modal variables
$modal_id         = 'notification';
$modal_title      = '';
$modal_size       = 'modal-lg';

$modal_backdrop   = true;
$modal_screen     = 'modal-fullscreen-md-down';
$modal_centered   = 'modal-dialog-centered';
$modal_scrollable = 'modal-dialog-scrollable';