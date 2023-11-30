<?php

if (isset($_GET['app']) && $_GET['app'] != '') {
  $redirect_app = $_GET['app'];
  if (in_array($redirect_app, $app_list)) {
    $_SESSION['active_app'] = $redirect_app;
  }
}

redirect_to('login');
