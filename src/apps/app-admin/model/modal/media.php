<?php


$media_id     = (isset($_POST['media_id'])) ? $_POST['media_id'] : NULL;
$type         = (isset($_POST['media_id']))?'edit':'add';
$media_type   = (isset($_POST['type'])) ? $_POST['type'] : '';
$req_res      = NULL;
if (isset($_POST['media_id'])) {

  $req_sql    = "SELECT * FROM media WHERE media_id = ? AND media_status = 1 LIMIT 1";
  $req_dta    = [$media_id];
  $req_res    = prep_exec($req_sql, $req_dta, $sql_request_data[0]);
}


// modal variables
$modal_id         = 'mediaModal';
$modal_title      = '';
$modal_size       = 'modal-lg';

$modal_backdrop   = true;
$modal_screen     = 'modal-fullscreen-md-down';
$modal_centered   = 'modal-dialog-centered';
$modal_scrollable = 'modal-dialog-scrollable';
