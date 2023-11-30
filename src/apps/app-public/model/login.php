<?php
$data = array('error' => false, 'message' => '');
$pass = (isset($_GET['password']))? urldecode($_GET['password']):'';
$usnm = (isset($_GET['username']))? $_GET['username']:'';

if (($pass == $_ENV['USER_PASS'] && $usnm == 'USER_NAME') || (isset($_SESSION['tmp_user']) && $_SESSION['tmp_user'] == true)) {
    $_SESSION['tmp_user'] = 'true';
    redirect_to('login');
} elseif (isset($_GET['username']) && isset($_GET['password'])) {
    $data['error']      = true;
    $data['message']    = "Username and password combination are incorrect";
} else {
    // redirect_to('home');
}


$data       = array('message' => '',  'success' => false, 'error'   => false);
$is_login   = true;
$passreset  = (isset($_GET['passreset'])) ? true : false;

if (isset($_SESSION['tmp_user_id'])) {
  $usr_id = $_SESSION['tmp_user_id'];
  $user   = get_user_by_id($usr_id);
}
