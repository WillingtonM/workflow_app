<?php
$nwsf_qry       = null;

$is_admin       = is_admin_check();
$subscription   = company_subscription();
$data           = array('error' => false);
$intval         = 9;
$artcl_count    = 1;
$array_count    = 0;
$tabbs_count    = 0;

$count          = 0;
