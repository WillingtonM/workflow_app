<?php
$is_admin       = is_admin_check();
$subscription   = company_subscription();

$cnt_sql        = "SELECT subscription_id, subscription_name, subscription_last_name, subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_edit, subscription_status FROM email_subscription";
$cnt_dta        = [];
$cnt_res        = prep_exec($cnt_sql, $cnt_dta, $sql_request_data[1]);

if (isset($_GET['subs']) && $_GET['subs'] == 'all') {
    $req_sql    = "SELECT subscription_id, subscription_name, subscription_last_name, subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_edit, subscription_status FROM email_subscription";
} else {
    $req_sql    = "SELECT * FROM (SELECT subscription_id, subscription_name, subscription_last_name, subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_edit, subscription_status FROM email_subscription ORDER BY subscription_id DESC LIMIT 50) email_subscription ORDER BY subscription_id ASC";
}
$req_dta        = [];

$subscribers    = prep_exec($req_sql, $req_dta, $sql_request_data[1]);
$count          = 1;

// foreach ($subscribers as $value) {
//     $id = $value['subscription_id'];
//     $em = $value['subscription_email'];
//     $sql  = "UPDATE email_subscription SET subscription_email = ? WHERE subscription_id = ? LIMIT 1";
//     $dta  = [$em, $id];

//     if (prep_exec($sql, $dta, $sql_request_data[2])) {
//         echo $em . ' ' . $id;
//     }
// }
