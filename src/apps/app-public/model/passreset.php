<?php
$data             = array( 'message' => '',  'success' => false, 'error'   => false);
$date             = date('Y-m-d H:i:s');
$is_login         = true;
$passreset        = true;

if ( isset($_GET['token']) && isset($_GET['uid']) && isset($_GET['distroy']) ) {
  $userkey        = sanitize($_GET['usrkey']);
  $user_id        = sanitize($_GET['uid']);
  $token          = sanitize($_GET['token']);
  $user_type      = sanitize($_GET['type']);

  if ($token == db_hash($user_id)) {
    
    $usr_sql      = "UPDATE users SET pass_reset_code = ? WHERE user_id = ? LIMIT 1";
    $usr_dta      = ['', $user_id];

    if (prep_exec($usr_sql, $usr_dta, $sql_request_data[2]) ) {
      $data['success']  = true;
      $data['message']  = "Your password reset has been destroyed";
    } else {
      $data['error']    = true;
      $data['message']  = "Password reset link has not been destroyed";
    }
  }

} elseif (isset($_GET['token']) && isset($_GET['uid']) && isset($_GET['usrkey'])) {
  $userkey        = sanitize($_GET['usrkey']);
  $user_id        = sanitize($_GET['uid']);
  $token          = sanitize($_GET['token']);
  $user_type      = sanitize($_GET['utype']);
  $page_type      = sanitize($_GET['type']);

  $token_succs    = false;
  $user_db        = get_user_by_id($user_id);
  $username       = ($user_db) ? $user_db['username']:'';

  if (($token === $user_db['pass_reset_code'] || $token_succs == true) && $userkey === db_hash($user_db['user_id']))
  {
    // check if user has passed 24 hours since password reset request
    $base_date    = date('Y-m-d H:i:s', strtotime(PASSWORD_RESET_TIME, strtotime($user_db['pass_reset_date'])) );

    if ($base_date > $date) {
      $data['success']  = true;
      $data['message']  = '';
    } else {
      $data['error']    = true;
      $data['message']  = "Your password reset link has expired, try to reset your password again";
    }

  } else {
    $data['error']      = true;
    $data['message']    = "Incorrect token provided for your password reset or you have already reset your password";
  }

} else{
  $data['error']        = true;
  $data['message']      = 'Incorrect link to reset your password, please ensure your use the link sent to your email';
}
