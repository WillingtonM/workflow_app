<?php
$is_admin       = is_admin_check();
$subscription   = company_subscription();
$data           = array('error' => false, 'success' => false, 'message' => '');

$token          = (isset($_GET['token']))?$_GET['token']:null;
$usr_k          = (isset($_GET['usrkey']))?$_GET['usrkey']:null;
$user_id        = (isset($_GET['uid']))?$_GET['uid']:null;
// echo db_hash($user_id) . '<br>';
// echo $usr_k;

if(db_hash($user_id) == $usr_k && $usr_k != null) {
  $cnf_sql      = "SELECT * FROM users WHERE email_confirm_code = ? AND user_id = ? LIMIT 1";
  $cnf_dta      = [$token, $user_id];

  if ($user = prep_exec($cnf_sql, $cnf_dta, $sql_request_data[0])) {

    if (!$user['email_confirm']) {
      $sql      = "UPDATE users SET email_confirm = 1 WHERE user_id = ? LIMIT 1";
      $dta      = [$user['user_id']];
      if (prep_exec($sql, $dta, $sql_request_data[2])) {
        $_SESSION['email_confirm']  = true;
        $_SESSION['user_id']        = $user_id;
        $_SESSION['message']        = "Your email has been confirmed";
        redirect_to('home');
      }
    } else {
      $data['error']    = true;
      $data['message']  = "Your email has already been confirmed";
    }

  }else {
    $data['error'] = true;
    $data['message'] = "The link provided seems not to be valid";
  }
} else {

  $data['error'] = true;
  $data['message'] = "The link provided seems not to be valid";
}
// var_dump($_GET);
