<?php
$is_admin         = is_admin_check();
$subscription     = company_subscription();

$article_id       = (isset($_POST['article_id']))?$_POST['article_id']:NULL;
$type             = (isset($_POST['article_id']))?'edit':'add';
$req_res          = NULL;
if (isset($_POST['article_id'])) {

  $req_sql        = "SELECT * FROM articles WHERE article_id = ? AND article_status = 1 LIMIT 1";
  $req_dta        = [$article_id];
  $req_res        = prep_exec($req_sql, $req_dta, $sql_request_data[0]);

}

// modal variables
$modal_id         = 'articleModal';
$modal_title      = '<i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; '. (($article_id) ? 'Edit' : 'Create') . ' a Article';
$modal_size       = 'modal-lg';

$modal_backdrop   = true;
$modal_screen     = 'modal-fullscreen-md-down';
$modal_centered   = 'modal-dialog-centered';
$modal_scrollable = 'modal-dialog-scrollable';