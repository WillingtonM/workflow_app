<?php

use Abraham\TwitterOAuth\TwitterOAuth;

if(isset($_POST)) {
  $date     = date('Y-m-d H:i:s');
  $data     = array('error' => '','data' => '', 'success' => false,'message' => '', 'url' => '');
  $user_id  = (isset($_SESSION['user_id']) && $_SESSION['user_id'] != null)?$_SESSION['user_id']:null;

  $emailkey = constant("EMAIL_KEY");

  // feedback form
  if (isset($_POST['form_type']) &&  $_POST['form_type'] == 'feedback_form') {
    $name       = (isset($_POST['name'])) ? $_POST['name'] : '';
    $last_name  = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $message    = (isset($_POST['message'])) ? $_POST['message'] : '';
    $email      = (isset($_POST['email'])) ? $_POST['email'] : '';
    $full_name  = $name . ' ' . $last_name;

    if (!$data['error'] && empty($name)) {
      $data['error']    = true;
      $data['message']  = "Please provide your full name";
    }

    if (!$data['error'] && empty($message)) {
      $data['error']    = true;
      $data['message']  = "Please write your message";
    }

    if (!$data['error'] && empty($email)) {
      $data['error']    = true;
      $data['message']  = "Please provide your email";
    }

    // email validity
    if (!$data['error'] && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $data['error']    = true;
      $data['message']  = "Incorect email format";
    }

    if (empty($data['error'])) {
      $Feedbacks_sql = "INSERT INTO feedback (feedback_name, feedback_last_name, feedback_email, feedback_message) VALUES (?, ?, ?, ?)";
      $Feedbacks_dta = [$name, $last_name, $email, $message];
      $Feedbacks_qry = prep_exec($Feedbacks_sql, $Feedbacks_dta, $sql_request_data[2]);

      if ($Feedbacks_qry) {

        // Send email preparation
        $client_ifo   = array(
          "name"      => $full_name,
          "email"     => $email,
          "message"   => $message,
        );

        // Prepare to send email *************************************************

        $to_usrs      = array(
          "name"      => $full_name,
          "email"     => $email
        );

        $subject      = "Feedback Message Captured";
        $html         =  user_feedback($full_name, $client_ifo);

        if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {

          $subject    = "New Feedback Message";

          if (isset($admin_emails) && !empty($admin_emails)) {
            foreach ($admin_emails as $key => $mail_user) {
              
              $to_usrs = array(
                "name"    => $mail_user['name'],
                "email"   => $mail_user['mail']
              );
              
              $html = user_feedback_notifify($mail_user['name'], $client_ifo);
              
              $mailer->mail->clearAllRecipients();
              if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                $data['success'] = true;
              }
              
            }
          } else {
            $to_usrs   = array(
              "name"    => $_ENV['MAIL_USER'],
              "email"   => $_ENV['MAIL_MAIL'],
            );

            $html = user_feedback_notifify($_ENV["MAIL_USER"], $client_ifo);

            $mailer->mail->clearAllRecipients();
            if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
              $data['success'] = true;
            }

          }

          $data['success'] = true;
          $data['message'] = "Your message has been sent";

        } else {
          // $data['error'] = true;
          // $data['message'] = 'Your message was not sent';
        }

      } else {
        $data['error']   = true;
        $data['message']  = 'Your message was not sent';
      }

    }
  }

  // email subscription
  if (isset($_POST['signup_email'])) {
    $name               = $_POST['name'];
    $last_name          = $_POST['last_name'];
    $signup_email       = $_POST['signup_email'];
    $full_name          = $name . ' ' . $last_name;

    // name validity
    if (!$data['error'] && empty($last_name)) {
      $data['error']    = true;
      $data['message']  = 'Please provide your name';
    }

    // last name validity
    if (!$data['error'] && empty($last_name)) {
      $data['error']    = true;
      $data['message']  = 'Please provide your last name';
    }

    // email validity
    if (!$data['error'] && empty($signup_email)) {
      $data['error']    = true;
      $data['message']  = 'Please provide your email';
    }

    // email validity
    if (!$data['error'] && !filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {
      $data['error']    = true;
      $data['message']  = 'Incorect email format';
    }

    if (!$data['error']) {

      // check subcription if exists
      $chck_sql = "SELECT subscription_id, subscription_name, subscription_last_name, subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_status FROM email_subscription WHERE subscription_email = ? LIMIT 1";
      $chck_dta = [$signup_email];
      $chck_qry = prep_exec($chck_sql, $chck_dta, $sql_request_data[0]);

      if ($chck_qry && $chck_qry['subscription_status'] == 1) {
        $data['error'] = true;
        $data['message'] = 'You have already subscribed to ' . PROJECT_TITLE . '\'s newsletter.';
      }

      if (!$data['error']) {
        if ($chck_qry && $chck_qry['subscription_status'] == 0) {
          $sbscrp_sql   = "UPDATE email_subscription SET subscription_status = 1 WHERE subscription_id = ? LIMIT 1";
          $sbscrp_dta   = [$chck_qry['subscription_id']];
        } else {
          $sbscrp_sql   = "INSERT INTO email_subscription (subscription_name, subscription_last_name, subscription_email, subscription_date_created) VALUES (?,?,?,?)";
          $sbscrp_dta   = [$name, $last_name, $signup_email, $date];
        }

        if ($sbscrp_qry = prep_exec($sbscrp_sql, $sbscrp_dta, $sql_request_data[2])) {

          $last_id      = $connect->lastInsertId();
          $token        = db_hash($last_id);
          $token_url    = "/action?distroy=true&id=" . $last_id . "&token=" . $token . '&mail=' . $signup_email;

          $upd_sql      = "UPDATE email_subscription SET subscription_token = ? WHERE subscription_id = ? LIMIT 1";
          $upd_dta      = [$token, $last_id];
          if ($sql_res  = prep_exec($upd_sql, $upd_dta, $sql_request_data[2])) {
            $data['modal']    = 'close';
            $data['modal_id'] = 'subscription';
            $data['success']  = true;
            $data['delayed']  = true;
            $data['seconds']  = 9000;
            $data['message']  = "You have been subscribed, please check your email inbox for confirmation";
          }

          // Prepare to send email
          $token_url    = "/action?distroy=true&mail=" . $signup_email;

          $to_usrs      = array(
            "name"      => $name,
            "last_name" => $last_name,
            "full_name" => $full_name,
            "email"     => $signup_email,
            "url_reset" => host_url($token_url)
          );

          $client_ifo         = $to_usrs;
          $client_ifo["url"]  = $token_url;

          $subject      = "Email Subscription";
          $html         =  email_subscription($to_usrs["name"], $client_ifo);

          if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
            $subject    = "New Email Subscription";

            if (isset($admin_emails) && !empty($admin_emails)) {
              foreach ($admin_emails as $key => $mail_user) {

                $to_usrs = array(
                  "name"    => $mail_user['name'],
                  "email"   => $mail_user['mail']
                );

                $html       =  email_subscription_notify($mail_user['name'], $client_ifo);
                
                $mailer->mail->clearAllRecipients();
                if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                  $data['success'] = true;
                }
                
              }
            } else {
              $to_usrs   = array(
                "name"    => $_ENV['MAIL_USER'],
                "email"   => $_ENV['MAIL_MAIL'],
              );

              $html       =  email_subscription_notify($_ENV['MAIL_USER'], $client_ifo);

              $mailer->mail->clearAllRecipients();
              if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                $data['success'] = true;
              }

            }
            
          }

          if ($data['success'] == true) {
            $data['error'] = '';
          } else {
            $data['success'] == false;
          }
        }
      }
    }
  }

  // unsubscription
  if (isset($_POST["subscribe_token"])) {
    $id       = $_POST["id"];
    $token    = $_POST["subscribe_token"];

    $chck_sql = "SELECT subscription_id, subscription_name, subscription_last_name, subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_status FROM email_subscription WHERE subscription_id = ? AND subscription_token = ? LIMIT 1";
    $chck_dta = [$id, $token];
    if ($chck_qry = prep_exec($chck_sql, $chck_dta, $sql_request_data[0])) {
      $sql    = "UPDATE email_subscription SET subscription_status = 0 WHERE subscription_id = ? AND subscription_token = ? LIMIT 1";
      $dta    = [$id, $token];

      if ($qry = prep_exec($sql, $dta, $sql_request_data[2])) {
        $data['success']  = true;
        $data['message']  = 'You have been unsubscribed from ' . PROJECT_TITLE . ' mailing list';
      } else {
        $data['success']  = false;
        $data['message']  = 'There was a problem with unsubscribing you from ' . PROJECT_TITLE . ' mailing list';
      }
    } else {
      $data['success']    = false;
      $data['message']    = 'You have never subscribed with us, or you have provided us with incorrect token';
    }
  }

  // twitter signin attempt
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'twitter_signin') {
    $user_id        = '';
    $username       = (isset($_POST['username'])) ? $_POST['username'] : '';

    if ($user = get_user_by_username($username)) {
      $user_id      = $user['user_id'];
    }

    $api_user       = get_api_by_user_id($user_id);

    if (empty($username)) {
      $data['error']    = true;
      $data['message']  = "Please provide your admin username";
    }

    if (!$data['error'] && $user && $api_user) {
      $oauth_token        = $api_user['oauth_token'];
      $oauth_token_secret = $api_user['oauth_token_secret'];
    } elseif (!$data['error'] && $user) {
      $api_user           = $user;
    } elseif (!$data['error']) {
      $data['error']      = true;
      $data['message']    = 'You are not allowed to perform the task, please provide the correct username or contact the website administrator';
    }

    if (!$data['error'] && $api_user) {
      // $data['error']  = false;
      $twi_connect      = new TwitterOAuth($_ENV['TWEET_API_KEY'], $_ENV['TWEET_API_KEY_SECRET']);
      $request_token    = $twi_connect->oauth("oauth/request_token", ["oauth_callback" => $_ENV['TWEET_CALLBACK_URL']]);

      if ($twi_connect->getLastHttpCode() == 200) {

        // get twitter oauth url
        $oauth_token          = $request_token['oauth_token'];
        $oauth_token_secret   = $request_token['oauth_token_secret'];

        $oauthUrl             = $twi_connect->url("oauth/authorize", ["oauth_token" => $oauth_token]);

        $data['success']      = true;
        $data['url']          = filter_var($oauthUrl, FILTER_SANITIZE_URL);

        $_SESSION['TWT_URL']  = $data['url'];
        $_SESSION['user_token'] = $oauth_token;
        $_SESSION['user_token_secret'] = $oauth_token_secret;
        $_SESSION['TMP_USER_ID'] = $user_id;
      } else {
        $data['error']    = true;
        $data['message']  = 'Error connecting to twitter!, Try again later !';
      }
    }
  }

  // create email reset --------------------------------------------------------
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'passreset' && isset($_POST['email'])) {
    $email    = $_POST['email'];

    // email validity
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $data['error'] = true;
      $data['message'] = "Incorect email format";
    }

    if (!empty($email) && empty($data['error'])) {
      $user_type    = 'user';
      
      if ($user = get_user_by_email($email)) {
        
        $user_url       = '';
        $full_name      = $user['name'] . " " . $user['last_name'];

        // send account creation email confirmation
        $to             = [array("name"   => $full_name, "email" => $email)];

        $url_title      = "Password reset confirmation";
        $message        = "Please click the link below to confirm your password reset request";
        $url_msg        = 'Confirm Password Reset';

        $token          = db_hash(rand(1, 1000));
        $url            = '/passreset?token=' . $token . '&type=password_reset&uid=' . $user['user_id'] . '&utype=' . $user_type .  $user_url . '&usrkey=' . db_hash($user['user_id']);
        $url_reset      = $url . '&distroy=true';
        $passreset_link = host_url('/login?passreset=true');
        $mail_data      = array(
          "name"        => $full_name,
          "email"       => $email,
          "url_info"    => array(
            "url_title"     => $url_title,
            "url_link"      => host_url($url),
            "url_reset"     => host_url($url_reset),
            "url_message"   => $url_msg,
          ),
          "message"         => $message,
          "msg_welcome"     => "Hi " . $full_name . ",",
          "msg_intro"       => "You have recently requested to reset your " . PROJECT_TITLE . " Account password.",
          "msg_top_body"    => "Use the button below to reset your password:",
          "msg_paragraph_1" => 'You should use this link within 3 hours. To get a new password reset link, visit: <a href="' . $passreset_link . '">' . $passreset_link . '</a>',
          "msg_end_reason"  => "You’re receiving this email because you recently requested a password reset for your " . PROJECT_TITLE . " account. If this wasn’t you, please ignore this email.",
        );

        // $mail_data['msg_paragraph_1']    = htmlspecialchars($mail_data['msg_intro'], ENT_QUOTES, "UTF-8");
        $subject            = $url_title . " | " . PROJECT_TITLE;
        $html               = account_notification_mail($mail_data);
        $from               = MAIL_NOREPLY;
        // $from['name']       = $_ENV['MAIL_USER_NOREPLY'];

        if ($mailer->mail($to, $subject, $html, $from)) {
          $data['success']  = true;
          $data['message']  = "A password reset link was sent to your email, check your email and follow the instructions";
        }

        if ($data['success'] == true) {
          
          $sql              = "UPDATE users SET pass_reset_code = ?, pass_reset_date = ? WHERE user_id = ?";
          $dta              = [$token, $date, $user['user_id']];
          prep_exec($sql, $dta, $sql_request_data[2]);
        }
      } else {
        $data['error']      = TRUE;
        $data['message']    = "The email address provided is not registered as a " . PROJECT_TITLE . " account";
      }
    } else {
      $data['error']        = TRUE;
      $data['message']      = "Email address field is empty";
    }
  }

  // account password reset ---------------------------------------------------------------
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'passreset_confirm' && isset($_POST['password']) && isset($_POST['username'])) {

    $username           = (isset($_POST['username'])) ? sanitize($_POST['username']) : '';
    $password           = (isset($_POST['password'])) ? sanitize($_POST['password']) : '';
    $token              = (isset($_POST['reset_code'])) ? sanitize($_POST['reset_code']) : '';
    // $pass_confirm     = (isset($_POST['password_confirm'])) ? sanitize($_POST['password_confirm']) : '';
    $userkey            = (isset($_POST['userkey'])) ? sanitize($_POST['userkey']) : '';
    $user_type          = (isset($_POST['user_type'])) ? sanitize($_POST['user_type']) : '';

    // $username     = $user_db['username'];
    // $permission        = null;
    $token_succs        = false;
   
    $user_db            = get_user_by_username($username);

    if (!$user_db) {
      $data['error']    = true;
      $data['message']  = "This user account does not exists";
    } else {
      $user_id          = $user_db['user_id'];
      $user_token       = $user_db['pass_reset_code'];
      $reset_date       = $user_db['pass_reset_date'];
      $token_succs      = ($user_token == $token) ? true : false;
    }

    $required_fields    = array("username", "userkey");
    $errors['error']    = validate_presences($required_fields);
    if (!$data['error'] && !empty($errors['error'])) {
      $data['error']    = true;
      $data['message']  = $errors['error'];
    }

    // password check
    // validate password
    if (!$data['error'] && empty($password)) {
      $data['error']        = true;
      $data['form_check']   = true;
      $data['form_id']      = 'loginPasswordFeedback';
      $data['form_input']   = 'login_password';
      $data['message']      = 'Invalid password';
    }

    if (!$data['error']) {
      $pass_check = is_valid_password($password);
      if ($pass_check !== true) {
        $data['error']      = true;
        $data['message']    = $pass_check;
      }
    }

    if ($data['error'] != true) {
      // check date
      if (($token_succs == true) && $userkey === db_hash($user_id)) {
        // check if user has passed 24 hours since password reset request
        $base_date          = date('Y-m-d H:i:s', strtotime(PASSWORD_RESET_TIME, strtotime($reset_date)));

        if ($base_date <= $date) {
          $data['error']    = true;
          $data['message']  = "Incorrect token provided for your password reset or you have already reset your password";
        }
      } else {
        $data['error']      = true;
        $data['message']    = "Incorrect password reset link, use the correct link sent to your email";
      }

      if (!$data['error']) {

        // update password
        $h_password         = password_hashing($password);
        
        $usr_sql            = "UPDATE users SET password = ?, pass_reset_code = '', pass_reset_date = ?, last_seen = ? WHERE user_id = ? LIMIT 1";
        $usr_dta            = [$h_password, $date, $date, $user_id];

        if (prep_exec($usr_sql, $usr_dta, $sql_request_data[2])) {
          $data['success']  = true;
          $data['url']      = true;
          $data['message']  = 'Password updated successfully';

          $data['delayed']  = true;
          $data['seconds']  = 9000;

          if($found_user    = try_login($username, $password)) {
            $user_id        = $user_db['user_id'];
            $usr_sql        = "UPDATE users SET last_seen = ? WHERE user_id = ? LIMIT 1";
            $usr_dta        = [$date, $user_id];

            prep_exec($usr_sql, $usr_dta, $sql_request_data[2]);

            $utype_id       = $found_user['user_type_id'];
            $user_type      = get_user_type_by_id($utype_id);
            $company_id     = (isset($found_user['company_id']) && !empty($found_user['company_id'])) ? $found_user['company_id'] : '';
            $company        = get_company_by_id($company_id);

            // check if user is guest
            $active_app               = ($user_type['user_type_admin'] == 1 && $user_db['user_type'] != 'sys_admin') ? 'admin' : (($user_db['user_type'] == 'sys_admin') ? 'system' : 'user');
            $_SESSION['tmp_user']     = 'true';
            $_SESSION['admin_id']     = $user_id;
            $_SESSION['user_id']      = $user_id;
            $_SESSION['company_id']   = $company_id;
            $_SESSION['office_id']    = (isset($found_user['office_id']) && !empty($found_user['office_id'])) ? $found_user['office_id'] : '';
            $_SESSION['user_type']    = (isset($utype_id) && !empty($utype_id)) ? $utype_id : '';
            // permissiooins
            $_SESSION['is_admin']     = (!empty($user_type) && $user_type['user_type_admin']) ? TRUE : FALSE;
            $_SESSION['is_execute']   = (!empty($user_type) && $user_type['permission_execute']) ? TRUE : FALSE;
            $_SESSION['is_write']     = (!empty($user_type) && $user_type['permission_write']) ? TRUE : FALSE;
            $_SESSION['is_read']      = (!empty($user_type) && $user_type['permission_read']) ? TRUE : FALSE;

            $_SESSION['permissions']  = array(
              'execute' => ($_SESSION['is_execute'] || $_SESSION['is_admin']) ? TRUE : FALSE,
              'write'   => $_SESSION['is_write'],
              'read'    => $_SESSION['is_read'],
            );

            $_SESSION['active_app']   = $active_app;

            if($company && $company['company_complete'] == 0) {
              $_SESSION['company_setup']  = true;
              $_SESSION['setup_stage']    = 1;
            }

            $data['success']          = true;
            $data['message']          = "User succesfully logged-in";
            $data['url']              = "home";
          } else {
            $data['error']            = true;
            $data['message']          = "Your username and or password is incorrect";
          }

          if (isset($_SESSION['page_redirect']) && $_SESSION['page_redirect'] !== true) {
            $data['url']              = host_url($_SESSION['page_redirect']);
            unset($_SESSION['page_redirect']);
          } else {
            $data['url']              = 'home';
          }

        }
      }
    }
  }

  // user login
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'login_form' && isset($_POST["login_password"]) && isset($_POST["login_username"])) {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];

    if(empty($password)){
      $data['error']    = true;
      $data['message']  = "Password field is empty";
    } elseif (empty($username)) {
      $data['error']    = true;
      $data['message']  = "Username field is empty";
    }

    if (!$data['error']) {
      if( $usr_res      = get_user_by_username($username) ) {
        $found_user     = try_login($username, $password);

        if($found_user) {
          $user_id      = $usr_res['user_id'];
          $usr_sql      = "UPDATE users SET last_seen = ? WHERE user_id = ? LIMIT 1";
          $usr_dta      = [$date, $user_id];
          prep_exec($usr_sql, $usr_dta, $sql_request_data[2]);

          $utype_id     = $found_user['user_type_id'];

          $user_type    = get_user_type_by_id($utype_id);

          $company_id   = (isset($found_user['company_id']) && !empty($found_user['company_id'])) ? $found_user['company_id'] : '';
          $company      = get_company_by_id($company_id);

          if ($found_user['user_type'] == 'sys_admin') {
            $_SESSION['COMPANY_ACTIVE']         = TRUE;
            $_SESSION['SUBSCRIPTION_ACTIVE']    = TRUE;
          } elseif ($company && $company['company_subscription'] && $company['company_status']) {
            $_SESSION['COMPANY_ACTIVE'] = TRUE;
            $sub_date   = $company['company_subscription_active_date'];
            $val_date   = date('Y-m-d H:i:s', strtotime($sub_date . "+" . SUBSCRIPTION_PERIOD));

            if ($company['company_status'] && ($val_date < $date || !$company['company_subscription_active'])) {
              $_SESSION['SUBSCRIPTION_ACTIVE']  = FALSE;
            } else {
              $_SESSION['SUBSCRIPTION_ACTIVE']  = TRUE;
            }

            if ($val_date < $date && $company['company_subscription_active']) {
              // subscription_activation($company_id, 0);
            }
            
          } elseif($company['company_status']) {
            $_SESSION['COMPANY_ACTIVE']         = TRUE;
          } else {
            $_SESSION['COMPANY_ACTIVE']         = FALSE;
            $_SESSION['SUBSCRIPTION_ACTIVE']    = FALSE;
          }

          // check if user is guest
          $active_app               = ($user_type['user_type_admin'] == 1 && $found_user['user_type'] != 'sys_admin') ? 'admin' : (($found_user['user_type'] == 'sys_admin') ? 'system' : 'user');

          $_SESSION['tmp_user']     = 'true';
          $_SESSION['admin_id']     = $user_id;
          $_SESSION['user_id']      = $user_id;
          $_SESSION['company_id']   = $company_id;
          $_SESSION['office_id']    = (isset($found_user['office_id']) && !empty($found_user['office_id'])) ? $found_user['office_id'] : '';
          $_SESSION['user_type']    = (isset($utype_id) && !empty($utype_id)) ? $utype_id : '';
          // permissiooins
          $_SESSION['is_admin']     = (!empty($user_type) && $user_type['user_type_admin']) ? TRUE : FALSE;
          $_SESSION['is_execute']   = (!empty($user_type) && $user_type['permission_execute']) ? TRUE : FALSE;
          $_SESSION['is_write']     = (!empty($user_type) && $user_type['permission_write']) ? TRUE : FALSE;
          $_SESSION['is_read']      = (!empty($user_type) && $user_type['permission_read']) ? TRUE : FALSE;

          $_SESSION['permissions']  = array(
            'execute' => ($_SESSION['is_execute'] || $_SESSION['is_admin']) ? TRUE : FALSE,
            'write'   => $_SESSION['is_write'],
            'read'    => $_SESSION['is_read'],
          );

          $_SESSION['active_app']   = $active_app;
          
          if($company && $company['company_complete'] == 0) {
            $_SESSION['company_setup']  = true;
            $_SESSION['setup_stage']    = 1;
          }

          $data['success']          = true;
          $data['message']          = "User succesfully logged-in";
          $data['url']              = "home";
        } else {
          $data['error']            = true;
          $data['message']          = "Your username and/ or password is incorrect";
        }
      } else {
        $data['error']              = true;
        $data['message']            = "This username may not exists";
      }
    }
  }

  // create account
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'sign_up') {
    $booking_email  = (isset($_POST['email']) ) ? $_POST['email'] : '';
    $name           = (isset($_POST['name']) ) ? $_POST['name'] : '';
    $last_name      = (isset($_POST['last_name']) ) ? $_POST['last_name'] : '';
    $company_name   = (isset($_POST['company']) ) ? $_POST['company'] : '';
    $booking_phone  = (isset($_POST['contact']) ) ? $_POST['contact'] : '';
    $event_type     = 'request';

    // validate name
    // echo strlen($name);

    if (!$data['error']) {
      $valid_text   = validate_text($name);
      if ($valid_text !== true) {
        $data['error']      = true;
        $data['form_check'] = true;
        $data['form_id']    = 'nameFeedback';
        $data['message']    = $valid_text;
      }
    }

    // validate last name
    if (!$data['error']) {
      $valid_text = validate_text($last_name);
      if ($valid_text !== true) {
        $data['error']      = true;
        $data['form_check'] = true;
        $data['form_id']    = 'lastnameFeedback';
        $data['message']    = $valid_text;
      }
    }

    // email validity
    if (!$data['error'] && !filter_var($booking_email, FILTER_VALIDATE_EMAIL)) {
      $data['error']      = true;
      $data['form_check'] = true;
      $data['form_id']    = 'emailFeedback';
      $data['message']    = 'Incorect email format';
    }

    if (!$data['error'] && get_user_by_email($booking_email)) {
      $data['error']      = true;
      $data['message']    = "User with this email already exists, consider using a different email, or contact us";
    }

    if (!$data['error'] && empty($booking_email)) {
      $data['error']      = true;
      $data['form_check'] = true;
      $data['form_id']    = 'emailFeedback';
      $data['message']    = 'Please provide your email';
    }

    $time_interval    = 5;

    if ($event_check  = get_event_by_email($booking_email)) {
      $check_date     = date('Y-m-d H:i:s', strtotime($event_check['event_date_updated'] . "+" . $time_interval . "minutes"));
      // if ($event_check['event_user_email'] == $booking_email && ($check_date > $date) ) {
      //   $data['error']    = true;
      //   $data['message']  = "This enquiry has been submitted in the last " . $time_interval . ' minutes.';
      // }

      if (!$data['error'] && $event_check['event_processed']) {
        $data['error']    = true;
        $data['message']  = "Account with this email already exists, try to login or reset your password";
      } elseif (!$data['error']) {
        $data['error']    = true;
        $data['message']  = "You have already requested an account";
      }
    }

    // validate contact number
    // $contact_number = validate_phone_number($booking_phone);
    // if (!$data['error'] && !$contact_number) {
    //   $data['error']      = true;
    //   $data['form_check'] = true;
    //   $data['form_id']    = 'contactFeedback';
    //   $data['message']    = 'Invalid phone number';
    // }

    if (!$data['error']) {

      if (!empty($event_id)) {
        $events_sql = "UPDATE events SET event_user_name = ?, event_last_name = ?, event_user_email = ?, event_user_phone = ?, event_type = ?, event_processed = ?, event_company_name = ? WHERE event_id = ? LIMIT 1";
        $events_dta = [$name, $last_name, $booking_email, $booking_phone, $event_type, $complete, $company_name, $event_id,];
      } else {
        $events_sql = "INSERT INTO events (event_user_name, event_last_name, event_user_email, event_user_phone, event_type, event_company_name) VALUES (?, ?, ?, ?, ?, ?)";
        $events_dta = [$name, $last_name, $booking_email, $booking_phone, $event_type, $company_name];
      }

      if (prep_exec($events_sql, $events_dta, $sql_request_data[2])) {

        $full_name  = $name . ' ' . $last_name;

        // Send email preparation
        $client_ifo = array(
          "name"              => $full_name,
          "email"             => $booking_email,
          "contact"           => $booking_phone,
          "company"           => $company_name,
          "event_type"        => '',
          "message_type"      => 'public',
          "message_text_1"    => 'We would like to kindly inform you that we have received your online request; we will get in touch with you soon.',
          "message_text_2"    => '',
        );

        // Prepare to send email *************************************************
        $to_usrs    = array(
          "name"    => $full_name,
          "email"   => $booking_email
        );

        $subject      = "Request Recieved";
        $html         = event_notification($client_ifo);

        if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
          $subject    = "New Request";

          $client_ifo['message_type']   = 'admin';
          $client_ifo['message_text_1'] = 'You have a new online account request from '. PROJECT_TITLE .' website';
          $client_ifo['message_text_2'] = 'Here are the details,';

          if (isset($admin_emails) && !empty($admin_emails)) {
            foreach ($admin_emails as $key => $mail_user) {
              $html    = event_notification($client_ifo);

              $to_usrs    = array(
                "name"    => $mail_user['name'],
                "email"   => $mail_user['mail']
              );

              $mailer->mail->clearAllRecipients();
              if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                $data['success'] = true;
              }
              
            }
          } else {
            $to_usrs    = array(
              "name"    => $_ENV['MAIL_USER'],
              "email"   => $_ENV['MAIL_MAIL'],
            );

            $html       = event_notification($client_ifo);

            $mailer->mail->clearAllRecipients();
            if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
              $data['success'] = true;
            }

          }
        }

        $message        = (!empty($event_id)) ? 'updated' : 'created';
        $data['success'] = true;
        
        $data['message'] = (!isset($_SESSION['user_id'])) ? 'Your details have been successfully submitted' : 'Your details have been ' . $message;
      } else {
        $data['error']   = true;
        $data['message'] = 'Your request was not succssfully submitted';
      }
    }
    
  }

  // article comments user check
  if (isset($_POST['user_username']) && isset($_POST['user_email'])) {

    $user_id      = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';
    $username     = $_POST['user_username'];
    $email        = $_POST['user_email'];
    $comment      = $_POST['comment'];
    $article_id   = $_POST['article'];

    if(!$data['error'] && empty($username)){
      $data['error']    = true;
      $data['message']  = "Please provide your name";
    }
    
    if(!$data['error'] && empty($email)) {
      $data['error']    = true;
      $data['message']  = "Please provide your email";
    }

    // email validity
    if (!$data['error'] && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $data['error']    = true;
      $data['message']  = 'Incorect email format';
    }

    if (!$data['error']) {

      if ($user   = get_user_by_email($email)) {
        $user_id  = $user['user_id'];
      } else {

        if ($user = get_user_by_username($username)) {
          if (!get_user_by_email($email)) {
            $data['error']    = true;
            $data['message']  = "This username is already in use, please choose a different username";
          } else {
            $user_id = $user['user_id'];
          }
        } else {
          $req_sql = "INSERT INTO users (username, email, password, user_type, date_created, date_updated, last_seen) VALUES (?,?,?,?,?,?,?)";
          $req_dta = [$username, $email, 'pass', 0, $date, $date, $date];

          if ($user = prep_exec($req_sql, $req_dta, $sql_request_data[2])) {
            $user_id = $connect->lastInsertId();
          } else {
            $data['error']    = true;
            $data['message']  = "User creation was not successful";
          }
        }
      }

      $_SESSION['uid']      = $user_id;
      $data['success']      = true;
      $data['message']      = 'User successfully modified';
      $data['url']          = 'refresh';

      if (!$data['error']) {

        if (!empty($comment)) {
          $cmnt_sql = "INSERT INTO article_comments (article_id, user_id, article_comment, article_comment_date_created, article_comment_date_updated) VALUES (?,?,?,?,?)";
          $cmnt_dta = [$article_id, $user_id, $comment, $date, $date];

          if (prep_exec($cmnt_sql, $cmnt_dta, $sql_request_data[2])) {
            $data['success']      = true;
            $data['message']      = "Comment was succesfully created";

            $article              = get_article_by_id($article_id);
            $user                 = get_user_by_id($user_id);
            $article_title        = $article['article_title'];
            $article_type         = $article['article_type'];
            $article_image        = $article['article_image'];
            $article_pubdat       = $article['article_publish_date'];
            $article_author       = $article['article_author'];

            $article_date         = DateTime::createFromFormat('Y-m-d H:i:s', $article['article_publish_date']);
            $article_slg          = $slugify->slugify($article_title);

            $url                  = '/article?article=' . $article_slg . '&slgid=' . $article_id . '&type=' . $article_type;

            // Prepare to send email *************************************************

            $subject              = "New Article Comment";

            $client_ifo           = array(
              "name"              => '',
              "email"             => '',
              "title"             => htmlspecialchars($article_title, ENT_QUOTES, "UTF-8"),
              "author"            => $article_author,
              "date"              => $article_date->format('F jS, Y'),
              "message_text_1"    => "There is a new comment on the article that was published on ". $article_date->format('F jS, Y') .", titled: <b>". htmlspecialchars($article_title, ENT_QUOTES, "UTF-8") ."</b>",
              "message_text_2"    => 'Here is the link to the article: <a href="'. host_url($url) .'">'. host_url($url) .'</a>',
              "message_type"      => 'admin',
              "message"           => 'Article comment by <b> ' . $user['username'] . '</b>: ' . $comment,
            );

            if (isset($admin_emails) && !empty($admin_emails)) {
              foreach ($admin_emails as $key => $mail_user) {

                $to_usrs = array(
                  "name"    => $mail_user['name'],
                  "email"   => $mail_user['mail']
                );

                $html       =  main_general_mail($client_ifo);
                $mailer->mail->clearAllRecipients();
                if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                  $data['success'] = true;
                }
                
              }
            } else {
               $to_usrs   = array(
                "name"    => $_ENV['MAIL_USER'],
                "email"   => $_ENV['MAIL_MAIL'],
              );

              $html       =  main_general_mail($client_ifo);

              $mailer->mail->clearAllRecipients();
              if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                $data['success'] = true;
              }

            }
            
          }
          
        }
        
      }

      setcookie("ism_user", $date, time() + 86400*365);
    }
  }

  // article comments
  if (isset($_POST['comment']) && isset($_POST['islogged']) && isset($_SESSION['uid'])) {

    $user_id      = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';
    $comment      = $_POST['comment'];
    $comment_id   = (isset($_POST['comment_id']) && $_POST['comment_id'] != '')?$_POST['comment_id']:0;
    $article_id   = $_POST['article_id'];
    $comment_type = (isset($_POST['type']) && $_POST['type'] == 'reply')?1:0;

    if(empty($comment)){
      $data['error']          = true;
      $data['message']        = "Comment field is empty";
    } elseif (empty($article_id)) {
      $dataarticle_['error']  = true;
      $data['message']        = "Something went wrong, try to refresh the page";
    }

    if ($comment_type) {
      $usr_id                 = $_POST['user'];
      $user                   = get_user_by_id($usr_id);
      $comment                = '<a class="text-info">@' . $user['username'] . '</a>&nbsp; ' . $comment;
    }

    if (!$data['error']) {
      $cmnt_sql = "INSERT INTO article_comments (article_id, user_id, article_comment, article_comment_type, comment_id, article_comment_date_created) VALUES (?,?,?,?,?,?)";
      $cmnt_dta = [$article_id, $user_id, $comment, $comment_type, $comment_id, $date];

      if (prep_exec($cmnt_sql, $cmnt_dta, $sql_request_data[2])) {
        $data['success']      = true;
        $data['message']      = "Comment was succesfully created";
        $data['url']          = "comments_div".$article_id;

        $_SESSION['comment']  = '';

        $article              = get_article_by_id($article_id);
        $user                 = get_user_by_id($user_id);
        $article_title        = $article['article_title'];
        $article_type         = $article['article_type'];
        $article_image        = $article['article_image'];
        $article_pubdat       = $article['article_publish_date'];
        $article_author       = $article['article_author'];

        $article_date         = DateTime::createFromFormat('Y-m-d H:i:s', $article['article_publish_date']);
        $article_slg          = $slugify->slugify($article_title);

        $url                  = '/article?article=' . $article_slg . '&slgid=' . $article_id . '&type=' . $article_type;

        // Prepare to send email *************************************************
        $subject              = "New Article Comment";

        $client_ifo           = array(
          "name"              => '',
          "email"             => '',
          "title"             => htmlspecialchars($article_title, ENT_QUOTES, "UTF-8"),
          "author"            => $article_author,
          "date"              => $article_date->format('F jS, Y'),
          "message_text_1"    => "There is a new comment on the article that was published on ". $article_date->format('F jS, Y') .", titled: <b>". htmlspecialchars($article_title, ENT_QUOTES, "UTF-8") ."</b>",
          "message_text_2"    => 'Here is the link to the article: <a href="'. host_url($url) .'">'. host_url($url) .'</a>',
          "message_type"      => 'admin',
          "message"           => 'Article comment by <b> ' . $user['username'] . '</b>: ' . $comment,
        );

        if (isset($admin_emails) && !empty($admin_emails)) {
          foreach ($admin_emails as $key => $mail_user) {

            $to_usrs = array(
              "name"    => $mail_user['name'],
              "email"   => $mail_user['mail'],
            );

            $html       =  main_general_mail($client_ifo);
            $mailer->mail->clearAllRecipients();
            if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
              $data['success'] = true;
            }
            
          }
        } else {
          $to_usrs   = array(
            "name"    => $_ENV['MAIL_USER'],
            "email"   => $_ENV['MAIL_MAIL'],
          );

          $html       =  main_general_mail($client_ifo);

          $mailer->mail->clearAllRecipients();
          if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
            $data['success'] = true;
          }

        }
      }
    }

  }

  // article share
  if (isset($_POST['share_type']) && isset($_POST['article_id'])) {
    $article_id = $_POST['article_id'];

    if (!empty($article_id)) {

      $req_sql = "UPDATE articles SET article_shares = article_shares+1 WHERE article_id = ? LIMIT 1";
      $req_dta = [$article_id];

      if ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[2])) {
        $data['success'] = true;
        $data['message'] = "";
      }

    } else{
      $data['error'] = true;
      $data['message'] = "Update error";
    }
  }

  // article subcomments
  if (isset($_POST['article_comments']) && isset($_POST['article_id'])) {
    $article_id       = $_POST['article_id'];
    $article_comments = $_POST['article_comments'];

    if (!empty($article_id)) {

      $cmnt_sql = "SELECT * FROM article_comments WHERE article_id = ? ORDER BY article_comment_date_created LIMIT 3, 5000";
      $cmnt_dta = [$article_id];

      if ($cmnt_res = prep_exec($cmnt_sql, $cmnt_dta, $sql_request_data[1])) {
        $output = '';
        foreach ($cmnt_res as $comment) {
          $username = get_user_by_id($comment['user_id'])['username'];
          $db_date  = DateTime::createFromFormat('Y-m-d H:i:s', $comment['article_comment_date_created']);

          $output .= '<div class="user_comment" style="padding-top: 7px !important;">';
          $output .= '<img class="card-img-top card_img_comment img-thumbnail" style="height: 50px; width: 50px;" src="./img/users/profile.png" alt="User Image">';
          $output .= '<div class="card_img_comment_box/ card-body/" style="padding-left: 70px;">';
          $output .= '<h6 class="card-title"><i>' . $username;
          $output .= '</i>  &nbsp; | <small class="card-subtitle mb-2 text-muted"><span class="text-warning" style="">' . $db_date->format('H:m:s - F jS, Y') . '</span></small><br>';
          $output .= '</h6>';
          $output .= '<p class="text-muted">' . $comment['article_comment'] . '</p>';
          $output .= '</div>';
          $output .= '</div>';

        }

        $data['success'] = true;
        $data['message'] = $output;
      } else {
        $data['success'] = true;
        $data['message'] = '';
      }

    } else {
      $data['error']    = true;
      $data['message']  = 'Something went wrong';
    }
  }

  // bookings
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'booking_form') {
    $name           = (isset($_POST['name'])) ? $_POST['name'] : '';
    $last_name      = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $message        = (isset($_POST['booking_message'])) ? $_POST['booking_message'] : '';
    $booking_email  = (isset($_POST['booking_email'])) ? $_POST['booking_email'] : '';
    $booking_phone  = (isset($_POST['booking_phone'])) ? $_POST['booking_phone'] : '';

    $alt_name           = (isset($_POST['alt_name'])) ? $_POST['alt_name'] : '';
    $alt_last_name      = (isset($_POST['alt_last_name'])) ? $_POST['alt_last_name'] : '';
    $alt_booking_email  = (isset($_POST['alt_booking_email'])) ? $_POST['alt_booking_email'] : '';
    $alt_booking_phone  = (isset($_POST['alt_booking_phone'])) ? $_POST['alt_booking_phone'] : '';

    $company_name   = (isset($_POST['event_company_name'])) ? $_POST['event_company_name'] : '';
    $event_period   = (isset($_POST['event_period'])) ? $_POST['event_period'] : '';
    $event_descript = (isset($_POST['event_description'])) ? $_POST['event_description'] : '';
    $event_address  = (isset($_POST['event_address'])) ? $_POST['event_address'] : '';

    $event_town     = (isset($_POST['event_town'])) ? $_POST['event_town'] : '';
    $event_city     = (isset($_POST['event_city'])) ? $_POST['event_city'] : '';
    $event_country  = (isset($_POST['event_country'])) ? $_POST['event_country'] : '';

    $event_occupation     = (isset($_POST['event_occupation']) && !empty($_POST['event_occupation'])) ? $_POST['event_occupation'] : null;

    $event_type     = (isset($_POST['event_type']) && !empty($_POST['event_type'])) ? $_POST['event_type'] : null;
    $event_id       = (isset($_POST['event'])) ? $_POST['event'] : '';

    // dfate 
    $dob            = (isset($_POST['dob'])) ? $_POST['dob'] : '';
    $mob            = (isset($_POST['mob'])) ? $_POST['mob'] : '';
    $yob            = (isset($_POST['yob'])) ? $_POST['yob'] : '';
    $tod            = (isset($_POST['tod'])) ? $_POST['tod'] : '';

    // shared booking type
    $service_id     = (isset($_POST['departure_destination'])) ? $_POST['departure_destination'] : 0;
    $booking_date   = (isset($_POST['booking_date']) ? date('Y-m-d H:i:s', strtotime($_POST['booking_date'])) : '');

    $complete       = (isset($_POST['booking_complete'])) ? 1 : 0;

    $db_week        = '';
    if (!empty($service_id) && $service_type = 'shared') {
      $service      = get_service_by_id($service_id);

      $tod_date     = date('H:i:s', strtotime($service['service_departure_time']));
      $time_string  = ' +' . date('H', strtotime($tod_date)) . ' hours +' . date('i', strtotime($tod_date)) . ' minutes +' . date('s', strtotime($tod_date)) . ' seconds';
      $booking_time = date('Y-m-d H:i:s', strtotime($time_string, strtotime($booking_date)));
      $week_day     = date('l', strtotime($booking_time));
      $db_week      = $service['service_week_day'];

      $departure    = $service['service_departure'];
      $destination  = $service['service_destination'];
    } else {
      // charter booking type
      $tod          = str_replace(["PM", "AM"], '', $tod);
      $tod_date     = date('H:i:s', strtotime($tod));
      $event_date   = $yob . '-' . $mob . '-' . $dob . ' ' . $tod_date;
      $booking_time = date("Y-m-d H:i:s", strtotime($event_date));
      $departure    = (isset($_POST['booking_departure'])) ? $_POST['booking_departure'] : '';
      $destination  = (isset($_POST['booking_destination'])) ? $_POST['booking_destination'] : '';

      $week_day     = date('l', strtotime($booking_time));
    }

    $user_count     = (isset($_POST['booking_user_count'])) ? (int) $_POST['booking_user_count'] : 0;
    $full_name      = $name . ' ' . $last_name;

    $event_date_alt = date("d M Y, @ H:i", strtotime($booking_time));
    $event_date     = date('Y-m-d H:i', strtotime($booking_time));

    $event_type     = (empty($event_type)) ? 'enquiry' : $event_type;

    $time_interval  = 5;

    if ($event_check = get_event_by_email($booking_email)) {
      $check_date   = date('Y-m-d H:i:s', strtotime($event_check['event_date_updated'] . "+" . $time_interval . "minutes"));
      if ($event_check['event_user_email'] == $booking_email && ($check_date > $date) ) {
        $data['error']    = true;
        $data['message']  = "This enquiry has been submitted in the last " . $time_interval . ' minutes.';
      }
    }

    if (!$data['error'] && is_valid_date($event_date)) {
      $data['error']    = true;
      $data['message']  = "Incorrect date format";
    }

    // validate allowed booking date
    $hour               = date('H');
    $minute             = (date('i') > 30) ? '60' : '30';
    $time_round         = "$hour:$minute:00";

    $date_norm          = date("Y-m-d");

    $current_date       = date("Y-m-d H:i:s");

    // if (!$data['error'] && !empty($booking_time) && $booking_time <= $current_date) {
    //   $data['error']    = true;
    //   $data['message']  = "Your choosen date and or time is in the past. Choose a different date and time";
    // }

    // email validity
    if (!$data['error'] && !filter_var($booking_email, FILTER_VALIDATE_EMAIL)) {
      $data['error']    = true;
      $data['message']  = 'Incorect email format';
    }

    if (!$data['error'] && empty($booking_email)) {
      $data['error']    = true;
      $data['message']  = 'Please provide your email';
    }

    if (!$data['error'] && empty($name)) {
      $data['error']    = true;
      $data['message']  = 'Please provide your name';
    }

    if (!$data['error']) {

      if (!empty($event_id)) {
        $events_sql = "UPDATE events SET event_user_count = ?, event_host_date = ?, event_user_name = ?, event_last_name = ?, event_user_email = ?, event_user_phone = ?, event_message = ?, event_type = ?, event_processed = ?, event_company_name = ?, event_description = ?, event_address = ?, event_period = ?, event_town = ?, event_city = ?, event_country = ?, event_occupation = ?, event_alt_user_name = ?, event_alt_last_name = ?, event_alt_user_email = ?, event_alt_user_phone = ? WHERE event_id = ? LIMIT 1";
        $events_dta = [$user_count, $event_date, $name, $last_name, $booking_email, $booking_phone, $message, $event_type, $complete, $company_name, $event_descript, $event_address, $event_period, $event_town, $event_city, $event_country, $event_occupation, $alt_name, $alt_last_name, $alt_booking_email, $alt_booking_phone, $event_id,];
      } else {
        $events_sql = "INSERT INTO events (event_user_count, event_host_date, event_user_name, event_last_name, event_user_email, event_user_phone, event_message, event_type, event_date_created, event_date_updated, event_processed, event_company_name, event_description, event_address, event_period, event_town, event_city, event_country, event_occupation, event_alt_user_name, event_alt_last_name, event_alt_user_email, event_alt_user_phone) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $events_dta = [$user_count, $event_date, $name, $last_name, $booking_email, $booking_phone, $message, $event_type, $date, $date, $complete, $company_name, $event_descript, $event_address, $event_period, $event_town, $event_city, $event_country, $event_occupation, $alt_name, $alt_last_name, $alt_booking_email, $alt_booking_phone];
      }

      if (prep_exec($events_sql, $events_dta, $sql_request_data[2])) {

        // Send email preparation
        $client_ifo = array(
          "name"              => $full_name,
          "email"             => $booking_email,
          "contact"           => $booking_phone,
          "company"           => $company_name,
          "event_type"        => '',
          "address"           => '',
          "description"       => $event_descript,
          "event_date"        => $event_date,
          "event_period"      => (!empty($event_period)) ? $booking_period[$event_period] : '',
          "attendees"         => $user_count,
          "alt_name"          => $alt_name,
          "alt_last_name"     => $alt_last_name,
          "alt_email"         => $alt_booking_email,
          "alt_contact"       => $alt_booking_phone,
          "event_town"        => $event_town,
          "event_city"        => $event_city,
          "event_country"     => (isset($countries_array[$event_country])) ? $countries_array[$event_country] : '',
          "message_type"      => 'public',
          "message_text_1"    => 'We would like to kindly inform you that we have received your online enquiry; we will get in touch with you soon.',
          "message_text_2"    => '',
          "message"           => $message,
        );

        // Prepare to send email *************************************************
        $to_usrs    = array(
          "name"    => $full_name,
          "email"   => $booking_email
        );

        $subject    = "Enquiry Recieved";
        $html       = event_notification($client_ifo);

        if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
          $subject  = "New Enquiry";

          $client_ifo['message_type']   = 'admin';
          $client_ifo['message_text_1'] = 'You have a new online enquiry from '. PROJECT_TITLE .' website';
          $client_ifo['message_text_2'] = 'Here are the details,';

          if (isset($admin_emails) && !empty($admin_emails)) {
            foreach ($admin_emails as $key => $mail_user) {
              $html       = event_notification($client_ifo);

              $to_usrs    = array(
                "name"    => $mail_user['name'],
                "email"   => $mail_user['mail']
              );

              $mailer->mail->clearAllRecipients();
              if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                $data['success'] = true;
              }
            }
          } else {
              $to_usrs    = array(
              "name"      => $_ENV['MAIL_USER'],
              "email"     => $_ENV['MAIL_MAIL'],
            );

            $html         = event_notification($client_ifo);

            $mailer->mail->clearAllRecipients();
            if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
              $data['success'] = true;
            }
          }
        }

        $message          = (!empty($event_id)) ? 'updated' : 'created';

        $data['success']  = true;
        
        $data['message']  = (!isset($_SESSION['user_id'])) ? 'Your form has been successfully submitted' : 'Your form has been ' . $message;
      } else {
        $data['error']    = true;
        $data['message']  = 'Your request was not succssfully submitted';
      }
    }
  }

  // careers 
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'career_form') {
    $career_id          = (isset($_POST['career'])) ?  $_POST['career'] : '';
    $vacancy_id         = (isset($_POST['vacancy'])) ?  $_POST['vacancy'] : '';
    $career_name        = (isset($_POST['career_name'])) ?  $_POST['career_name'] : '';
    $career_email       = (isset($_POST['career_email'])) ?  $_POST['career_email'] : '';
    $career_contact     = (isset($_POST['career_contact'])) ?  $_POST['career_contact'] : '';

    if (!$data['error'] && empty($career_name)) {
      $data['error']    = true;
      $data['message']  = "Provide your full name";
    }

    // email validity
    if (!$data['error'] && empty($career_email)) {
      $data['error']    = true;
      $data['message']  = "Provide your email";
    }
    
    // email validity
    if (!$data['error'] && !filter_var($career_email, FILTER_VALIDATE_EMAIL)) {
      $data['error']    = true;
      $data['message']  = 'Incorect email format';
    }

    $career_data        = get_career_by_id($career_id);

    if (!$data['error'] && empty($career_data)) {
      $data['error']    = true;
      $data['message']  = 'Note that the this career vacancy is no longer available';
    }

    if (!$data['error']) {

      // check subcription if exists
      $chck_sql = "SELECT * FROM career_applications WHERE application_email = ? LIMIT 1";
      $chck_dta = [$career_email];
      $chck_qry = prep_exec($chck_sql, $chck_dta, $sql_request_data[0]);

      if ($chck_qry && $chck_qry['application_status'] == 1 && $career_id == $chck_qry['career_id']) {
        $data['error']    = true;
        $data['message']  = 'You have already applied for this opportunity.';
      }

      if (!$data['error']) {
        unset($_SESSION['media_id']);

        if (!empty($vacancy_id)) {
          $career_sql     = "UPDATE career_applications SET application_name = ?, application_email = ?, application_contact = ? WHERE career_id = ? LIMIT 1";
          $career_dta     = [$career_name, $career_email, $career_contact, $career_id];
        } else {
          $career_sql     = "INSERT INTO career_applications (application_name, application_email, application_contact, career_id) VALUES  (?, ?, ?, ?)";
          $career_dta     = [$career_name, $career_email, $career_contact, $career_id];
        }
  
        if (prep_exec($career_sql, $career_dta, $sql_request_data[2])) {
          $career_id        = $connect->lastInsertId();

          $_SESSION['media_id'] = $career_id;
  
          $data['success']  = true;
          $data['message']  = 'Your application has been submitted';

          // Prepare to send email *************************************************

          $car_name   = $career_data['career_name'];
          $to_usrs    = array(
            "name"    => $career_name,
            "email"   => $career_email
          );

          // Send email preparation
          $client_ifo = array(
            "name"          => $career_name,
            "email"         => $career_email,
            "contact"       => $career_contact,
            "event_type"    => 'career',
            "event_date"    => $date,
            "message_text_1"    => "Your career application for ". $car_name ." has been recieved.",
            "message_text_2"    => "We will get in touch with you once your application has been considered",
            "message_type"      => '',
            "message"           => '',
          );

          $subject          = "Career Application";
          $html             = main_general_mail($client_ifo);

          $mailer->mail->clearAllRecipients();
          if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
            $data['success'] = true;
          }

          $subject           = "New Career Application";
          $client_ifo['message_text_1']  = 'There is a new career application for ' . $car_name;
          $client_ifo['message_text_2']  = 'Visit the website admin page for further details';

          if (isset($admin_emails) && !empty($admin_emails)) {
            foreach ($admin_emails as $key => $mail_user) {

              $to_usrs = array(
                "name"    => $mail_user['name'],
                "email"   => $mail_user['mail']
              );

              $html       =  main_general_mail($client_ifo);
              $mailer->mail->clearAllRecipients();
              if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
                $data['success'] = true;
              }
            }
          } else {
            $to_usrs    = array(
              "name"    => $_ENV['MAIL_USER'],
              "email"   => $_ENV['MAIL_MAIL'],
            );

            $html       =  main_general_mail($client_ifo);

            $mailer->mail->clearAllRecipients();
            if ($mailer->mail(array($to_usrs), $subject, $html, MAIL_FROM)) {
              $data['success'] = true;
            }
          }

        } else {
          $data['error']    = true;
          $data['message']  = 'Your request was not submitted';
        }
      }

    }
  }

  // media file docs
  if (!empty($_FILES['file_doc']) && ($_FILES['file_doc']['error'] === UPLOAD_ERR_OK)) {
    if (is_uploaded_file($_FILES['file_doc']['tmp_name']) === false) {
      // throw new \Exception('Error on upload: Invalid file definition');
      $data['error']    = true;
      $data['messages'] = "Error on upload: Invalid file definition";
    } else {

      if (isset($_SESSION['media_id'])) {

        $media_id     = $_SESSION['media_id'];

        $image        = $_FILES['file_doc'];
        $img_temp     = $image['tmp_name'];

        if ($media = get_career_application_by_id($media_id)) {
          $crnt_img     = $media['application_file'];
          $orgn_name    = $img_temp;
          $dir_url      = FILES_APPLICATIONS;

          // Rename the uploaded file
          $img_name     = $image['name'];
          $img_type     = strtolower(substr($img_name, strripos($img_name, '.') + 1));
          // $img_name     = $img_name . '.' . $img_type;

          $img_dir      = $dir_url;
          $img_url      = $img_dir . $img_name;
          $media_sql    = "UPDATE career_applications SET application_file = ? WHERE application_id = ? LIMIT 1";
          $media_dta    = [$img_name, $media_id];

          if (prep_exec($media_sql, $media_dta, $sql_request_data[2])) {

            if (!is_dir($img_dir) && !file_exists($img_dir)) {
              mkdir($img_dir, 0777, true);
            }

            if (move_uploaded_file($image['tmp_name'], $img_url)) {
              $tmp_dir  = MEDIA_TMP;
              // $files    = glob($tmp_dir.'*');
              // foreach ($files as $file) {
              //   unlink($file);
              // }

              // $data['success']  = true;
              // $data['message']  = "Successfully added file";
              unset($_SESSION['media_id']);

              if (file_exists($img_dir . $crnt_img) && is_file($img_dir . $crnt_img)) {
                unlink($img_dir . $crnt_img);
              }
            }
          }
        }
      } else {

        $dir_url      = FILES_PATH;
        $image        = $_FILES['file_doc'];
        $img_temp     = $image['tmp_name'];

        $new_name     = 'FILE' . date("YmddHis");
        // Rename the uploaded file
        $img_name   = $image['name'];
        $img_type   = strtolower(substr($img_name, strripos($img_name, '.') + 1));
        $img_name   = $new_name . '.' . $img_type;

        $img_dir    = $dir_url . 'tmp';
        $img_url    = $img_dir . DS . $img_name;

        if (!is_dir($img_dir) && !file_exists($img_dir)) {
          mkdir($img_dir, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $img_url)) {
          $tmp_dir  = MEDIA_TMP;
          $files    = glob($tmp_dir . '*');
          // foreach ($files as $file) {
          //   if( is_file($file) ) {
          //     unlink($file);
          //   }
          // }

          $apnd = '#page=1&zoom=75';

          $data['data']     = $img_name;
          $data['success']  = true;
          // $data['message']  = "Successfully added file";
          $data['image']    = ABS_FILES . 'tmp' . DS . $img_name . $apnd;
        }
      }
    }
  }
  

  echo json_encode($data, true);

}
