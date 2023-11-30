<?php

$is_admin           = is_admin_check();
$company_id         = get_company_id();
$subscription       = company_subscription();

$rgst_sql           = "SELECT * FROM users WHERE user_type != 'guest' AND user_status = 1 AND company_id = ? ORDER BY date_created DESC";
$rgst_dta           = [$company_id];
$nwsf_qry           = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);

if (is_array($nwsf_qry) || is_object($nwsf_qry)) {
    $labels         = [];
    $data           = [];
    $colors         = [];
    foreach ($nwsf_qry as $key => $value) {
        
        $cnt_sql    = "SELECT count(*) FROM notifications WHERE user_id = ?  AND notification_status = 1 AND company_id = ?";
        $cnt_dta    = [$value['user_id'], $company_id];
        $$atl_cnt   = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
        
        $col_key    = array_rand($colors_array);
        $labels[]   = $value['username'];
        $colors[]   = $colors_array[$col_key]['rgb'];
        $data[]     = $$atl_cnt;
    }
}

// modal variables
$modal_id           = 'user_activities';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';