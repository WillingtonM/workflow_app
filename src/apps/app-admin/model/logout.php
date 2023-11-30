<?php

if (isset($_GET['back']) && $_GET['back']) {
  $_SESSION['active_app'] = 'public';
} else {
  session_destroy();
}

redirect_to('login');
