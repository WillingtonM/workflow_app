<?php
$is_admin       = is_admin_check();
$company_id     = get_company_id();
$subscription   = company_subscription();

$usr_sql        = "SELECT * FROM users WHERE user_status = 1 AND user_type != 'guest' AND company_id = ? ORDER BY date_created DESC";
$usr_dta        = [$company_id];
$usr_qry        = prep_exec($usr_sql, $usr_dta, $sql_request_data[1]);
