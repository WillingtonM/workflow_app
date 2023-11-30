<?php
$data         = array('error' => false);
$artcl_count  = 1;
$array_count  = 0;
$tabbs_count  = 0;

$intval       = ($key == 'appearance') ? 6 : 9;
$feed_count   = 1;

$gall_qry     = NULL;
$pggl_count   = 0;
$pggl_nmb     = 1;


// count media items
$pggl_nmb     = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
$media_tp     = (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';

$pggl_nmb     = (!empty($media_tp) && $media_tp == $key) ? $pggl_nmb : 1;

$feed_count   = (int) count_media_by_media_type($key);

$pggl_count   = ceil(($feed_count / $intval));
$sql_pg_strt  = (int)($pggl_nmb - 1) * $intval;


// query gallery media
$rgst_sql     = "SELECT * FROM media WHERE media_status = 1 AND media_type = ? ORDER BY media_publish_date DESC LIMIT $sql_pg_strt, $intval";
$rgst_dta     = [$key];
$gall_qry     = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
