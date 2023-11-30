<?php

$event_type         = (isset($_POST['type'])) ? $_POST['type'] : 'booking';

// modal variables
$modal_id           = 'events';
$modal_title        = '';
$modal_size         = 'modal-lg';

$modal_backdrop     = true;
$modal_screen       = 'modal-fullscreen-md-down';
$modal_centered     = 'modal-dialog-centered';
$modal_scrollable   = 'modal-dialog-scrollable';