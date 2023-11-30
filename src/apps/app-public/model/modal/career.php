<?php

$career_id          = (isset($_POST['career'])) ? sanitize($_POST['career']) : '';

$career             = get_career_by_id($career_id);

// modal variables
$modal_id           = 'career';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';
