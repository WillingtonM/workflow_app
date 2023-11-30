<?php

$is_admin           = is_admin_check();
$user_id            = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
$company_id         = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
$subscription       = company_subscription();

$task_history       = get_recent_task_history($user_id);

$interval           = 5;

// active orders
$orders             = get_tasks_by_assigned_id($user_id, 0, $interval);
$order_qry          = get_tasks_by_assigned_id($user_id, 0);
$notif_count        = (($order_qry != null) ? count($order_qry) : 0);

// sales
$interval           = 15;
$com_orders         = get_tasks_by_assigned_id($user_id, 1, $interval);
$notif_qry          = get_tasks_by_assigned_id($user_id, 1);
$sales_count        = (int) (($notif_qry != null) ? count($notif_qry) : 0);


$cnt_month          = null;
$today_date         = date('Y-m-d');
$label_start        = date('Y-m-d', strtotime("-8 months", strtotime($today_date)));
$label_month        = $label_start;
$labels_data        = [];

$sales_labels       = [];
$sales_data         = [];
$order_data         = [];

for ($i = 0; $i < 8; $i++) {
    $label_month    = date('Y-m-d', strtotime('+1 months', strtotime($label_month)));
    $labels_data[]  = date('M', strtotime($label_month));
}

// Sales data
if (is_array($notif_qry) || is_object($notif_qry)) {
    $sales_count    = 0;
    $month_sales    = 0;

    $order_labels   = $labels_data;
    $sales_data     = [0, 0, 0, 0, 0, 0, 0, 0];

    $count          = 0;
    foreach ($notif_qry as $sales) {

        $count++;
        $bill_date  = $sales['task_date_created'];
        $bill_month = date('M', strtotime($bill_date));

        // graph data implimentation
        if ($bill_date >= $label_start) {
            // find position of the month on $labels_data
            $key_pos = array_search($bill_month, $labels_data);
            $sales_data[$key_pos]++;
        } else {
            continue;
        }
    }

}

$sales_labels       = json_encode($labels_data, true);
$sales_data         = json_encode($sales_data, true);

// Order data
if (is_array($order_qry) || is_object($order_qry)) {
    $month_sales    = 0;
    $cnt_month      = null;

    $label_month    = $label_start;
    $order_data     = [0, 0, 0, 0, 0, 0, 0, 0];

    $count = 0;
    foreach ($order_qry as $order) {
        $count++;
        $bill_date  = $order['task_date_created'];
        $bill_month = date('M', strtotime($bill_date));

        $cnt_month  = ($count == 1) ? $bill_month : $cnt_month;

        if ($bill_date >= $label_start) {
            // find position of the month on $labels_data
            $key_pos                = array_search($bill_month, $labels_data);
            $order_data[$key_pos] ++;
        } else {
            continue;
        }
    }
}

$order_data     = json_encode($order_data, true);

// var_dump($order_qry);