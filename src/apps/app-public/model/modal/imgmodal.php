<?php

$media_id           = $_POST['media'];

$value              = get_media_by_id($media_id);
$media_src          = $_POST['media_src'];
$media_img          = $_POST['media_img'];
$image_dir          = 'mediacontent' . DS . 'gallery' . DS . $media_src . DS . $media_img;
// $media           = get_media_by_id($media_id);

$img_dir = ABS_GALLERY . $value['media_image'] . DS;

$img_output         = global_imgs($img_dir, 'col-12 p-3', 24, 'carousel', $value['media_image'], $media_img);

// var_dump($media_img);

$dir_url            = '';
$imgs               = glob($img_dir . "*.{jpg,png,gif}", GLOB_BRACE);
$output             = '';
$count              = 0;
$global_count       = count($imgs);

// modal variables
$modal_id         = 'imgModal';
$modal_title      = '';
$modal_size       = 'modal-fullscreen';

$modal_backdrop   = false;
$modal_screen     = 'modal-fullscreen-md-down';
$modal_centered   = 'modal-dialog-centered';
$modal_scrollable = 'modal-dialog-scrollable';
