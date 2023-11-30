<?php

$is_admin           = is_admin_check();
$subscription       = company_subscription();

$article_title      = (isset($_POST['article_title']) ? $_POST['article_title'] : '');
$article_post       = (isset($_POST['article_content']) ? $_POST['article_content'] : '');
$article_type       = (isset($_POST['article_type'])) ? $_POST['article_type'] : false;
$article_id         = (isset($_POST['article_id'])) ? $_POST['article_id'] : false;
$article_link       = (isset($_POST['article_link'])) ? $_POST['article_link'] : '';
$article_publisher  = (isset($_POST['article_publisher'])) ? $_POST['article_publisher'] : '';
$article_author     = (isset($_POST['article_author'])) ? $_POST['article_author'] : '';
$article_source     = (isset($_POST['article_source'])) ? $_POST['article_source'] : '';


$pub_dob            = (isset($_POST['publication_day'])) ? $_POST['publication_day'] : '';
$pub_mob            = (isset($_POST['publication_month'])) ? $_POST['publication_month'] : '';
$pub_yob            = (isset($_POST['publication_year'])) ? $_POST['publication_year'] : '';
$article_pubdate    = (!empty($pub_dob) && !empty($pub_mob) && !empty($pub_yob)) ? date("Y-m-d H:i:s", strtotime($pub_yob . '/' . $pub_mob . '/' . $pub_dob)) : '';

$artcl_date         = DateTime::createFromFormat('Y-m-d H:i:s', $article_pubdate);

$file_content       = (isset($_POST['file_content'])) ? $_POST['file_content'] : '';

// echo $file_content;

// modal variables
$modal_id           = 'article_view';
$modal_title        = '<i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Article View';
$modal_size         = 'modal-xl';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
