<?php
$nwsf_qry     = null;

$is_admin     = is_admin_check();
$subscription = company_subscription();
$data         = array('error' => false);
$intval       = 9;
$artcl_count  = 1;
$array_count  = 0;
$tabbs_count  = 0;

$count        = 0;

// $req_res_bl = get_article_by_type($article_types[0]);
// $req_res_ar = get_article_by_type($article_types[1]);
// $req_res_ex = get_article_by_type($article_types[2]);
