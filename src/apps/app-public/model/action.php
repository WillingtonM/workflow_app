<?php
$date         = date('Y-m-d H:i:s');
$data         = array('error' => false, 'data' => '', 'success' => false, 'message' => '', 'url' => '');

if (isset($_GET['distroy']) && isset($_GET['mail']) && isset($_GET['unsubscribe'])) {
  $emailkey   = constant("EMAIL_KEY");
  $mail       = $_GET['mail'];

  if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

    $chck_sql = "SELECT subscription_id, subscription_name, subscription_last_name, AES_DECRYPT(subscription_email, UNHEX('$emailkey')) subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_status FROM email_subscription WHERE AES_DECRYPT(subscription_email, UNHEX('$email_key')) = ? LIMIT 1";
    $chck_dta = [$mail];

    if ($subscrpt = prep_exec($chck_sql, $chck_dta, $sql_request_data[0])) {
      if ($subscrpt['subscription_status'] == 0) {
        $data['error']      = true;
        $data['message']    = "Your email has been unsubscribed already";
      } else {
        $sql = "UPDATE email_subscription SET subscription_status = 0 WHERE subscription_id = ?";
        $dta = [$subscrpt['subscription_id']];
        if (prep_exec($sql, $dta, $sql_request_data[2])) {
          $data['success']  = true;
          $data['message']  = "You have been succesfully unsubscribed";
        }
      }
    } else {
      $data['error']        = true;
      $data['message']      = "This email is not subscribed to " . PROJECT_TITLE . "'s newsletter";
    }
  } else {
    $data['error']          = true;
    $data['message']        = "The email is incorrect";
  }
}
