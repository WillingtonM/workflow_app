<?php
use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\Psr7\Message;



if(isset($_POST)) {
  $date         = date('Y-m-d H:i:s');
  $data         = array('error' => '','data' => '', 'success' => false,'message' => '', 'url' => '', 'image' => '');
  $user_id      = (isset($_SESSION['user_id']) && $_SESSION['user_id'] != null)?$_SESSION['user_id']:0;
  $office_id    = (isset($_SESSION['office_id']) && $_SESSION['office_id'] != null)?$_SESSION['office_id']:0;
  $company_id   = get_company_id();

  $is_admin     = is_admin_check();
  $subscription = company_subscription();


  // user ************************************************************************************************

  // resend confirm
  if (isset($_POST['resend_confirm'])) {
    // Prepare to send email
    $user     = get_user_by_id($user_id);

    if (!$user['email_confirm']) {
      $from     = MAIL_FROM;
      $token    = $user['email_confirm_code'];
      $url      = '/confirmation?token=' . $token . '&usrkey=' . db_hash($user['user_id']) . '&uid=' . $user['user_id'];

      $full_name = '';
      $email      = $user['email'];

      $to_usrs    = array(
        "name"    => $full_name,
        "email"   => $email
      );

      $client_ifo = array(
        "name"    => $full_name,
        "email"   => $email,
        "message" => "Please confirm your email by clicking below:",
        "url"     => host_url($url),
      );

      $subject  = PROJECT_TITLE . " | Email Confirmation";
      $html     = confirmation_mail($full_name, $client_ifo);

      if ($mailer->mail(array($to_usrs), $subject, $html, $from)) {
        $mailer->mail->clearAllRecipients();

        $data['success'] = true;
        $data['message'] = "Email has been sent";
      }
    } else {
      $data['error']    = true;
      $data['message']  = "Email has has already been sent";
    }
  }

  // users
  if (isset($_POST['position']) && isset($_POST['email']) && isset($_POST['name'])) {
    $user_type_id       = (isset($_POST['user_type'])) ? $_POST['user_type'] : '';
    $username           = (isset($_POST['username'])) ? $_POST['username'] : '';
    $name               = (isset($_POST['name'])) ? $_POST['name'] : '';
    $surname            = (isset($_POST['surname'])) ? $_POST['surname'] : '';
    $mobile             = (isset($_POST['mobile'])) ? $_POST['mobile'] : '';
    $telephone          = (isset($_POST['telephone'])) ? $_POST['telephone'] : '';
    $email              = (isset($_POST['email'])) ? $_POST['email'] : '';
    $password           = (isset($_POST['password'])) ? $_POST['password'] : '';
    $position           = (isset($_POST['position'])) ? $_POST['position'] : '';
    $checker            = (isset($_POST['is_checker'])) ? 1 : 0;
    $province           = (isset($_POST['province'])) ? $_POST['province'] : '';
    $list_position      = (!isset($_POST['list_position']) && empty($_POST['list_position'])) ? 0 : (int) $_POST['list_position'];
    $user_description   = (isset($_POST['description'])) ? $_POST['description'] : '';

    $usr_id             = (isset($_POST['post_user'])) ? $_POST['post_user'] : '';
    $user               = get_user_by_id($usr_id);

    if (!$data['error'] && empty($user_type_id) ) {
      $data['error']    = true;
      $data['message']  = 'Please select a user type option';
    }
    
    $user_type_id       = (isset($user['user_type_id']) && ($user['user_type_id'] != 1 || $user['user_type_id'] != 2) || (!isset($user) && !empty($user_type_id))) ? $user_type_id : ((isset($user)) ? $user['user_type_id'] : 2);

    $usr_type_qry       = get_user_type_by_id($user_type_id);

    if (!$data['error'] && !$usr_type_qry && ( (isset($user['user_type']) && $user_type_id != 1) || !$user) ) {
      $data['error']    = true;
      $data['message']  = 'Please select a user type option';
    }

    if (isset($_POST['username'])) {
      if ($username == '') {
        $data['error']    = true;
        $data['message']  = "Username can not be blank";
      } elseif (!has_min_length($username, 3)) {
        $data['error']    = true;
        $data['message']  = "Username must be more than 3 characters";
      }
    }

    // validate contact number
    $contact_number = validate_phone_number($mobile);
    if (!$data['error'] && !$contact_number && $usr_type_qry['user_type_slug'] == 'guest') {
      $data['error']      = true;
      $data['form_check'] = true;
      $data['form_id']    = 'contactFeedback';
      $data['message']    = 'Invalid phone number';
    }

    if (!$data['error'] && !$user && $usr_type_qry['user_type_slug'] == 'guest') {
      $password           = (empty($password)) ? $mobile: $password;
    }

    if (!$data['error'] && $usr_type_qry && $usr_type_qry['user_type_slug'] != 'guest' && !$data['error']) {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //invalid email!
        $data['error']    = true;
        $data['message']  = "Incorect email format";
      }
    }

    if (!$data['error'] && !$user && !empty($email) && !empty(get_user_by_email($email))) {
      $data['error']      = true;
      $data['message']    = 'A user with thie email already exists';
    }

    if (!$data['error']) {
      if (isset($_POST['post_user'])) {
        $user_id      = $_POST['post_user'];
        $chck_sql     = "SELECT username, user_id FROM users WHERE user_id = ? LIMIT 1";
        $chck_dta     = [$user_id];
        $data['data'] = 'update';
        $_SESSION['last_user_id'] = $user_id;
      } else {
        $chck_sql     = "SELECT username, user_id FROM users WHERE username = ? LIMIT 1";
        $chck_dta     = [$username];
      }

      $chck_qry       = prep_exec($chck_sql, $chck_dta, $sql_request_data[0]);

      if ($chck_qry && $data['data'] != 'update') {
        $data['error']    = true;
        $data['message']  = "The user already exists, use a different username";
      } else {

        if ($password != '' && $data['data'] == 'update') {
          $h_password       = password_hashing($password);
        }

        $user_type_id     = $usr_type_qry['user_type_id'];
        $user_type        = $usr_type_qry['user_type_slug'];
        $msg_dta          = array();

        if ($data['data'] == 'update') {
          $usr_id           = $chck_qry['user_id'];
          $key_dta          = 'update';
          $user             = get_user_by_id($usr_id);

          if ($user) {
            $msg_dta['old'] = array(
              'user_type'   => $user['user_type_id'],
              'name'        => $user['name'],
              'username'    => $user['username'],
              'surname'     => $user['last_name'],
              'mobile'      => $user['contact_number'],
              'telephone'   => $user['alt_contact_number'],
              'email'       => $user['email'],
              'position'    => $user['user_position'],
              'province'    => $user['user_province'],
              'list_position'    => $user['user_listpos'],
              'description' => $user['user_description'],
            );
          }

          $msg_dta['new']   = array(
            'user_type'     => $user_type_id,
            'name'          => $name,
            'username'      => $username,
            'surname'       => $surname,
            'mobile'        => $mobile,
            'telephone'     => $telephone,
            'email'         => $email,
            'position'      => $position,
            'province'      => $province,
            'list_position' => $list_position,
            'description'   => $user_description,
          );

          if ($password != '') {
            $inst_sql     = "UPDATE users SET user_type_id = ?, user_type = ?, username = ?, contact_number = ?, alt_contact_number = ?, name = ?, last_name = ?, email = ?, user_position = ?, user_listpos = ?, user_province = ?, user_description = ?, password = ?, user_is_checker = ? WHERE user_id = ? LIMIT 1";
            $inst_dta     = [$user_type_id, $user_type, $username, $mobile, $telephone, $name, $surname, $email, $position, $list_position, $province, $user_description, $h_password, $checker, $user_id];
          } else {
            $inst_sql     = "UPDATE users SET user_type_id = ?, user_type = ?, username = ?, contact_number = ?, alt_contact_number = ?, name = ?, last_name = ?, email = ?, user_position = ?, user_listpos = ?, user_province = ?, user_description = ?, user_is_checker = ? WHERE user_id = ? LIMIT 1";
            $inst_dta     = [$user_type_id, $user_type, $username, $mobile, $telephone, $name, $surname, $email, $position, $list_position, $province, $user_description, $checker, $user_id];
          }
        } else {
          $key_dta        = 'insert';
          $msg_dta        = 'insert';
          $h_password     = password_hashing($password);
          $inst_sql       = "INSERT INTO users (company_id, office_id, user_type_id, user_type, username, contact_number, alt_contact_number, name, last_name, email, password, user_is_checker, user_position, user_listpos, user_province, user_description, date_created, last_seen) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $inst_dta       = [$company_id, $office_id, $user_type_id, $user_type, $username, $mobile, $telephone, $name, $surname, $email, $h_password, $checker, $position, $list_position, $province, $user_description, $date, $date];
        }

        if (prep_exec($inst_sql, $inst_dta, $sql_request_data[2])) {
          $usr_id         = ($data['data'] == 'update' && isset($usr_id)) ? $usr_id : $connect->lastInsertId();
          if ($data['data'] != 'update') {
            $_SESSION['last_user_id'] = $usr_id;
          }

          $notif_db       = 'users';
          $msg_dta        = (is_array($msg_dta)) ? json_encode($msg_dta, true) : $msg_dta;

          if (insert_notifications($user_id, $usr_id, $notif_db, $usr_id, 0, 0, $msg_dta, $key_dta)) {

            $company      = get_company_by_id($company_id);

            // ******* send SMS to user
            if ($data['data'] != 'update') {
              $client       = get_user_by_id($usr_id);
              $d_name       = substr($name, 0, 1) . ' ' . $surname;
              $msg_array    = "Hello $d_name, Your user account has been created: Login info; username: $username; password: $password; website: ".$_ENV["PROJECT_HOST"]." ~" . $company['company_name'];

              $err          = true;
              if ($msg_array && $mobile) {
                // list($err, $response) = post_sms_message($message, $mobile, $usr_id);
              }

              if ((!$err || $err == '200') && isset($response)) {
                if (is_array($response) || is_object($response)) {
                  // echo $response;
                } else {
                  $response = json_decode($response, true);
                }

                $amount     = $response['cost'];
                $payment_id = $response['eventId'];
                $msg_res    = $response['sample'];
                $cost_break = $response['costBreakdown'];

                $ins_sql    = "INSERT INTO sms_orders (user_id, company_id, client_association_id, practice_task_id, order_confirmation, confirmation_token, order_complete, order_amount, order_amount_net, order_payment_id, order_token, order_status, order_payment_status, order_message, order_billing_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $ins_dta    = [$usr_id, $company_id, 0, 0, 1, '', 1, $amount, $amount, $payment_id, '', 1, 1, $msg_res, $date];

                if (prep_exec($ins_sql, $ins_dta, $sql_request_data[2])) {
                  // $data['url']      = 'refresh';
                  $data['success']  = true;
                  $data['message']  = "SMS has been successfully sent";
                  // $data['data']     = $response;
                }
              }
            }

            $data['url']      = 'refresh';
            $data['delayed']  = true;
            $data['seconds']  = 7000;
            $data['success']  = true;
            $data['message']  = "User has been updated succesfully";
          }
        } else {
          $data['error']      = true;
          $data['message']    = "Something went wrong, please try again";
        }
      }

      $data['data'] = '';
    }
  }

  // articles ************************************************************************************************

  // article content
  if (isset($_POST['article_title']) && isset($_POST['article_content'])) {

    unset($_SESSION['article_id']);
    $article_title     = sanitize($_POST['article_title']);
    $article_post      = $_POST['article_content'];
    $article_type      = (isset($_POST['article_type'])) ? $_POST['article_type'] : false;
    $article_id        = (isset($_POST['article_id'])) ? $_POST['article_id'] : false;
    $article_link      = $_POST['article_link'];
    $article_publisher = (isset($_POST['article_publisher'])) ? $_POST['article_publisher'] : '';
    $article_author    = $_POST['article_author'];
    $article_source    = $_POST['article_source'];
    // $article_pubdate   = $_POST['article_publish_date'];

    $pub_dob           = (isset($_POST['publication_day'])) ? $_POST['publication_day'] : '';
    $pub_mob           = (isset($_POST['publication_month'])) ? $_POST['publication_month'] : '';
    $pub_yob           = (isset($_POST['publication_year'])) ? $_POST['publication_year'] : '';
    $article_pubdate   = (!empty($pub_dob) && !empty($pub_mob) && !empty($pub_yob)) ? date("Y-m-d H:i:s", strtotime($pub_yob . '/' . $pub_mob . '/' . $pub_dob)) : '';

    $article_file      = ((isset($_POST['file_name'])) ? $_POST['file_name'] : '');

    $cronjob           = (isset($_POST['cronjob'])) ? 1 : 0;
    $cronjob_status    = $cronjob;

    $twitjob           = (isset($_POST['twitter_publish'])) ? 1 : 0;
    $twitjob_status    = $twitjob;

    $publication       = (isset($_POST['subscription_publish'])) ? 1 : 0;

    // cron date
    $dob               = (isset($_POST['dob'])) ? $_POST['dob'] : '';
    $mob               = (isset($_POST['mob'])) ? $_POST['mob'] : '';
    $yob               = (isset($_POST['yob'])) ? $_POST['yob'] : '';
    $hour              = (isset($_POST['hour'])) ? $_POST['hour'] : '';

    $cronjob_date      = (!empty($dob) && !empty($mob) && !empty($yob)) ? date("Y-m-d H:i:s", strtotime($yob . '/' . $mob . '/' . $dob . ' ' . $hour . ':0:0')) : '';


    if (!empty($article_post)) {
      // $article_post = json_encode($article_post);
      // $article_post = json_decode($article_post);
      // $article_post = $article_post['content'];
    }

    if (empty($article_pubdate)) {
      $data['error']    = true;
      $data['message']  = "Provide article published date";
    }

    if (get_article_by_title($article_title) && empty($article_id) && !empty($article_title)) {
      $data['error']    = true;
      $data['message']  = "The aticle title already exists, consider changing the title of your article";
    }

    if (empty($article_title) && !$data['error']) {
      $data['error']    = true;
      $data['message']  = "Article title field is empty";
    } elseif (empty($article_post) && !$data['error']) {
      $data['error']    = true;
      $data['message']  = "Article content field is empty";
    }

    if (!in_array($article_type, $article_types) && !$data['error']) {
      $data['error']    = true;
      $data['message']  = "The article type mentioned is not supported";
    } elseif (!$article_type && !$data['error']) {
      $data['error']    = true;
      $data['message']  = "Please choose article type";
    }

    if (!empty($article_link)) {
      if (!check_url($article_link)) {
        $data['error']   = true;
        $data['message'] = "The link provided is incorrect";
      }
    }

    if (!isset($_SESSION['user_id'])) {
      $data['error']    = true;
      $data['message']  = "You are not logged in, please refresh the page and attempt tp login";
    }

    if (!$data['error']) {
      if (empty($article_id)) {
        $article_sql = "INSERT INTO articles (user_id, article_title, article_author, article_link, article_file, article_publisher, article_source, article_content, article_type, article_cronjob, article_cronjob_status, article_twitjob, article_cronjob_date, article_publish_date, article_date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $article_dta = [$user_id, $article_title, $article_author, $article_link, $article_file, $article_publisher, $article_source, $article_post, $article_type, $cronjob, $cronjob_status, $twitjob, $cronjob_date, $article_pubdate, $date];
      } else {
        $db_article = get_article_by_id($article_id);
        if ($db_article['article_cronjob_status'] == 0 && $cronjob == 1) {
          $article_sql = "UPDATE articles SET user_id = ?, article_title = ?, article_author = ?, article_link = ?, article_file = ?, article_publisher = ?, article_source = ?, article_content = ?, article_type = ?, article_cronjob = ?, article_cronjob_status = ?, article_twitjob = ?, article_publish_date = ? WHERE article_id = ? LIMIT 1";
          $article_dta = [$user_id, $article_title, $article_author, $article_link, $article_file, $article_publisher, $article_source, $article_post, $article_type, $cronjob, $cronjob_status, $twitjob, $article_pubdate, $article_id];
        } elseif ($db_article['article_cronjob_status'] == 1 && $db_article['article_sent'] == 0) {
          $article_sql = "UPDATE articles SET user_id = ?, article_title = ?, article_author = ?, article_link = ?, article_file = ?, article_publisher = ?, article_source = ?, article_content = ?, article_type = ?, article_cronjob = ?, article_cronjob_status = ?, article_twitjob = ?, article_cronjob_date = ?, article_publish_date = ? WHERE article_id = ? LIMIT 1";
          $article_dta = [$user_id, $article_title, $article_author, $article_link, $article_file, $article_publisher, $article_source, $article_post, $article_type, $cronjob, $cronjob_status, $twitjob, $cronjob_date, $article_pubdate, $article_id];
        } else {
          $article_sql = "UPDATE articles SET user_id = ?, article_title = ?, article_author = ?, article_link = ?, article_file = ?, article_publisher = ?, article_source = ?, article_content = ?, article_type = ?, article_cronjob = ?, article_publish_date = ? WHERE article_id = ? LIMIT 1";
          $article_dta = [$user_id, $article_title, $article_author, $article_link, $article_file, $article_publisher, $article_source, $article_post, $article_type, $cronjob, $article_pubdate, $article_id];
        }
      }

      if ($sbscrp_qry = prep_exec($article_sql, $article_dta, $sql_request_data[2])) {
        $data['success'] = true;
        $data['message'] = "Your article has been updated!";
        $_SESSION['article_id'] = (!empty($article_id)) ? $article_id : $connect->lastInsertId();

        $dir_url = FILES_PATH . 'tmp' . DS;
        if (!empty($article_file) && file_exists($dir_url . $article_file)) {
          if (rename($dir_url . $article_file, FILES_PATH . $article_file)) {
            $data['data'] = 'File updated';
          }
        }

        if (empty($article_id) && $cronjob === 0) {
          $_SESSION['cronjob'] = false;
        }

        if (empty($article_id) && $twitjob === 1) {
          $_SESSION['twitjob'] = true;
        }

        if (empty($article_id) && $publication === 1) {
          $_SESSION['subscription_publish'] = $publication;
        }

        if (!empty($article_id) && isset($db_article) && $db_article['article_type'] != $article_type) {
          $article_dir      = ARTICLES_URL . $db_article['article_type'] . DS . $db_article['article_image'];
          $article_newpath  = ARTICLES_URL . $article_type . DS . $db_article['article_image'];
          if (is_file($article_dir)) {
            rename($article_dir, $article_newpath);
          }
        }
      }
    }
  }

  // article image temp
  if (isset($_FILES["post_image"]["tmp_name"]) && $_FILES['post_image']['error'] == UPLOAD_ERR_OK && !isset($_SESSION['article_id'])) {

    $user_dir = ARTICLES_URL . 'tmp' . DS;
    $new_name = 'IMGIM' . date("YmddHis");
    $img_name = $_FILES["post_image"]["name"];
    $img_temp = $_FILES["post_image"]["tmp_name"];
    // Be sure we're dealing with an upload
    $image_res = image_validation($img_name, $new_name, $img_temp, $user_dir);
    if ($image_res['success']) {
      $new_name = $new_name . '.' . $image_res['mime_type'];
      if (is_dir($user_dir)) {
        // article_img('tmp', $new_name);

        $data['success']  = $image_res['success'];
        $data['image']    = ABS_ARTICLES . 'tmp' . DS . $new_name;
      } else {
        $data['error']    = true;
        $data['message']  = 'Image was not uploaded successfully';
      }
    } else {
      $data['error']    = $image_res['success'];
    }

    $data['message']  = (empty($data['message'])) ? $image_res['message'] : $data['message'];
  }

  // article image
  if (!empty($_FILES['post_image']) && ($_FILES['post_image']['error'] == UPLOAD_ERR_OK && isset($_SESSION['article_id']))) {
    clearstatcache();
    $article_id   = $_SESSION['article_id'];
    $user         = get_user_by_id($user_id);

    $article_sql  = "SELECT * FROM articles WHERE article_id = ? LIMIT 1";
    $article_dta  = [$article_id];

    if ($article  = prep_exec($article_sql, $article_dta, $sql_request_data[0])) {

      $user_dir   = ARTICLES_URL . $article['article_type'] . DS;
      $new_name   = 'IMGIM' . date("YmddHis");
      $img_name   = $_FILES["post_image"]["name"];
      $img_temp   = $_FILES["post_image"]["tmp_name"];
      // Be sure we're dealing with an upload
      $image_res  = image_validation($img_name, $new_name, $img_temp, $user_dir);
      if ($image_res['success']) {

        $img_name = $new_name . '.' . $image_res['mime_type'];
        $img_sql  = "UPDATE articles SET article_image = ?, user_id = ? WHERE article_id = ? LIMIT 1";
        $img_dta  = [$img_name, $user_id, $article_id];

        if (prep_exec($img_sql, $img_dta, $sql_request_data[2])) {
          $data['success']  = true;
          $data['message']  = "Article has been succesfully created";

          if (!isset($_SESSION['cronjob'])) {
            unset($_SESSION['article_id']);
            $data['url']      = 'blog';
            $data['delayed']  = true;
            $data['seconds']  = 7000;
          } else {
            $_SESSION['imgupload'] = true;
          }
        } else {
          $data['error']      = true;
          $data['message']    = "Image was not successfully updated";
        }
      } else {
        $data['error']        = $image_res['success'];
        $data['message']      = (empty($data['message'])) ? $image_res['message'] : $data['message'];
      }
    } else {
      $data['error']      = true;
      $data['message']    = "Article was not found";
    }

    clearstatcache();
  }

  // article file
  if (isset($_POST['article_file'])) {

    // Allowed origins to upload images
    $accepted_origins = array("http://localhost", "https://" . $_ENV['PROJECT_HOST'], "http://" . $_ENV['PROJECT_HOST']);

    // Images upload path


    reset($_FILES);
    $temp = current($_FILES);
    if (is_uploaded_file($temp['tmp_name'])) {
      if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Same-origin requests won't set an origin. If the origin is set, it must be valid.
        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
          header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        } else {
          header("HTTP/1.1 403 Origin Denied");
          return;
        }
      }

      // Sanitize input
      if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
      }

      // Verify extension
      if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
      }

      // Accept upload if there was no origin, or if it is an accepted origin
      // $filetowrite = $imageFolder . $temp['name'];
      // move_uploaded_file($temp['tmp_name'], $filetowrite);

      // Respond to the successful upload with JSON.
      // $data['url'] = $filetowrite;

      $path_image   = 'images' . DS;

      $user_dir     = MEDIA_URL . $path_image;
      $new_name     = 'IMGIM' . date("YmddHis");
      $img_name     = $temp["name"];
      $img_temp     = $temp["tmp_name"];
      // Be sure we're dealing with an upload
      $image_res    = image_validation($img_name, $new_name, $img_temp, $user_dir);
      if ($image_res['success']) {
        $new_name = $new_name . '.' . $image_res['mime_type'];
        if (is_dir($user_dir)) {
          // article_img('tmp', $new_name);

          $data['success']  = $image_res['success'];
          $data['image']    = ABS_MEDIA . $path_image . $new_name;
        } else {
          $data['error']    = true;
          $data['message']  = 'Image was not uploaded successfully';
        }
      } else {
        $data['error']      = $image_res['success'];
      }

      $data['message']      = (empty($data['message'])) ? $image_res['message'] : $data['message'];
    } else {
      // Notify editor that the upload failed
      header("HTTP/1.1 500 Server Error");
    }
  }

  // article twitter post
  if (isset($_SESSION['twitjob']) && isset($_SESSION['article_id']) && isset($_SESSION['imgupload'])) {

    $twitjob              = (isset($_POST['twitter_publish'])) ? 1 : 0;
    $article_id           = $_SESSION['article_id'];
    // Prepare to send tweet
    $article              = get_article_by_id($article_id);
    $article_title        = $article['article_title'];
    $article_type         = $article['article_type'];
    $article_image        = $article['article_image'];
    $article_slg          = $slugify->slugify($article_title);
    $url                  = '/article?article=' . $article_slg . '&slgid=' . $article_id . '&type=' . $article_type;
    // [post to twitter]
    $api_user             = get_api_by_user_id($user_id);
    if ($api_user && isset($_SESSION['request_vars'])) {
      $data['api_data']   = 'True twitter';
      // $oauth_token        = $api_user['oauth_token'];
      // $oauth_token_secret = $api_user['oauth_token_secret'];

      $oauth_token        = (isset($_SESSION['request_vars']['oauth_token'])) ? $_SESSION['request_vars']['oauth_token'] : $api_user['oauth_token'];
      $oauth_token_secret = (isset($_SESSION['request_vars']['oauth_token_secret'])) ? $_SESSION['request_vars']['oauth_token_secret'] : $api_user['oauth_token_secret'];

      $twi_connect        = new TwitterOAuth($_ENV['TWEET_API_KEY'], $_ENV['TWEET_API_KEY_SECRET'], $oauth_token, $oauth_token_secret);
      $content            = $twi_connect->get("account/verify_credentials");

      $tweet_msg          = $article_title . " " . host_url($url) . ' #' . ucfirst($api_user['first_name']) . ucfirst($api_user['last_name']) . ' via @' . $api_user['username'];
      $tweet_param        = [
        'status' => $tweet_msg,
      ];

      // create tweet
      $twi_connect  = new TwitterOAuth($_ENV['TWEET_API_KEY'], $_ENV['TWEET_API_KEY_SECRET'], $oauth_token, $oauth_token_secret);
      $tweet        = $twi_connect->post("statuses/update", $tweet_param);

      if ($twi_connect->getLastHttpCode() == 200) {
        $data['data']     = $tweet;
        $data['success']  = true;
        $data['message']  = "Tweet was not created, something went wrong";
      } else {
        $data['data']     = $tweet;
        $data['error']    = true;
        $data['message']  = "Tweet was not created, something went wrong";
      }
    }

    unset($_SESSION['twitjob']);
  }

  // article cronjob
  if (isset($_SESSION['cronjob']) && isset($_SESSION['article_id']) && isset($_SESSION['imgupload'])) {

    $publication    = (isset($_SESSION['subscription_publish'])) ? 1 : 0;

    $article_id     = $_SESSION['article_id'];
    // Prepare to send email
    $article        = get_article_by_id($article_id);
    $article_title  = $article['article_title'];
    $article_type   = $article['article_type'];
    $article_post   = $article['article_content'];
    $article_author = $article['article_author'];
    $article_image  = $article['article_image'];
    $article_pubdat = $article['article_publish_date'];
    $article_slg    = $slugify->slugify($article_title);

    $url            = '/article?article=' . $article_slg . '&slgid=' . $article_id . '&type=' . $article_type;
    // $url_title      = "New Article";
    $message        = (PAGE_SETTINGS['article_email_length'] == 0)? short_paragrapth($article_post, 2500): $article_post;
    $subject        = PROJECT_TITLE . ' | ' . $article_title;
    $subject        = PROJECT_TITLE . ' | ' . html_entity_decode($article_title, ENT_QUOTES, "UTF-8");
    $subject        = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $from           = MAIL_FROM;

    $artcl_date     = DateTime::createFromFormat('Y-m-d H:i:s', $article_pubdat);
    // $artcl_date     = DateTime::createFromFormat('Y-m-d', $article_pubdat);

    $mail_data      = array(
      "name"        => '',
      "email"       => '',
      "url_info"    => array(
        "url_title" => (PAGE_SETTINGS['article_email_length'] == 0) ? 'Read more ...' : 'Read article online',
        "url_link"  => host_url($url),
        "url_reset" => ''
      ),
      "message"     => $message,
      "title"       => htmlspecialchars($article_title, ENT_QUOTES, "UTF-8"),
      // "title"       => html_entity_decode($article_title, ENT_QUOTES, "UTF-8"),
      "author"      => $article_author,
      "date"        => $artcl_date->format('F jS, Y'),
      "image"       => host_url('/' . ABS_ARTICLES . $article_type . DS . $article_image),
      "mail_data"   => $article,
    );
    // post to email subscribers
    $subscribers    = get_subscribers();

    if ($subscribers != null && $publication === 1) {
      foreach ($subscribers as $user) {
        $name           = $user['subscription_name'];
        $last_name      = $user['subscription_last_name'];
        $full_name      = $name . " " . $last_name;
        $url_reset      = '/action?&distroy=true&mail=' . $user['subscription_email'];

        $to = array(
          array(
            "name"      => $name,
            "last_name" => $last_name,
            "full_name" => $full_name,
            "email"     => $user['subscription_email']
          ),
        );

        $mail_data['name']  = $name;
        $mail_data['email'] = $user['subscription_email'];
        $mail_data['url_info']['url_reset'] = host_url($url_reset);

        $html           = general_mail($mail_data);
        if (isset($mailer)) {
          $mailer->mail->clearAllRecipients();
        }

        if ($mailer->mail($to, $subject, $html, $from)) {
          $mailer->mail->clearAllRecipients();

          $data['url']      = 'blog';
          $data['success']  = true;
          $data['delayed']  = true;
          $data['seconds']  = 7000;
          $data['message']  = "Article succesfully published and sent ";
        } else {
          $data['error']    = true;
          $data['message']  = 'Email was not sent, try again';
        }
      }
    }

    update_article_by_id($article_id);
    unset($_SESSION['cronjob']);
    unset($_SESSION['article_id']);
    unset($_SESSION['imgupload']);
    unset($_SESSION['subscription_publish']);
  }

  // article remove
  if (isset($_POST['article_remove']) && $_POST['article_remove'] && isset($_POST['article_id'])) {
    $article_id = $_POST['article_id'];
    $article_tp = $_POST['article_type'];

    if (!empty($article_id)) {
      $req_sql = "UPDATE articles SET article_status = 0 WHERE article_id = ? LIMIT 1";
      $req_dta = [$article_id];
      if (prep_exec($req_sql, $req_dta, $sql_request_data[2])) {
        $data['success'] = true;
        $data['message'] = "Article has been removed";
        $data['url']     = 'articles?' . $article_tp;
      } else {
        $data['error']   = true;
        $data['message'] = "Something went wrong, and your media is not removed";
      }
    }
  }

  // media ************************************************************************************************

  // media content
  if (isset($_POST['media_title']) && isset($_POST['media_type']) && $_POST['media_type'] != 'appearance' && $_POST['media_type'] != 'podcast') {

    $media_title    = (isset($_POST['media_title'])) ? $_POST['media_title'] : '';
    $media_type     = (isset($_POST['media_type'])) ? $_POST['media_type'] : '';
    $file_type      = (isset($_POST['file_type'])) ? $_POST['file_type'] : '';
    $media_url      = (isset($_POST['media_url'])) ? $_POST['media_url'] : '';
    $media_id       = (isset($_POST['media_id'])) ? $_POST['media_id'] : 0;
    $media_content  = (isset($_POST['media_content'])) ? $_POST['media_content'] : '';
    $media_date     = (isset($_POST['media_publish_date'])) ? $_POST['media_publish_date'] : '';

    $media_image    = ($media_type != 'file') ? $slugify->slugify($media_title) : '';

    if (!$data['error'] && empty($media_title)) {
      $data['error']    = true;
      $data['message']  = "File title can not be blank";
    }

    if (!$data['error'] && empty($media_date)) {
      $data['error']    = true;
      $data['message']  = "Publication date cannot be blank";
    } else {
      $media_date       = (!empty($media_date)) ? date('Y-m-d H:i:s', strtotime($media_date)) : $media_date;
    }

    if (!$data['error']) {
      $chck_sql = "SELECT * FROM media WHERE media_title = ? AND media_type = ? LIMIT 1";
      $chck_dta = [$media_title, $media_type];

      if (prep_exec($chck_sql, $chck_dta, $sql_request_data[0])) {
        if ($media_id == 0) {
          $data['error']    = true;
          $data['message']  = "The title already exists, consider using a different media title";
        } else {
          $media = get_media_by_id($media_id);
          if ($media['media_title'] != $media_title) {
            $data['error']    = true;
            $data['message']  = "The title already exists, consider using a different media title";
          }
        }
      }

      if (!$data['error']) {

        if ($media_id) {
          if ($media_type != 'file') {
            $old_image_url =  get_media_by_id($media_id)['media_image'];
          }
          $inst_sql = "UPDATE media SET media_title = ?, media_content = ?, media_url = ?, media_type = ?, media_file_type = ?, media_image = ?, media_publish_date = ?, user_id = ? WHERE media_id = ? LIMIT 1";
          $inst_dta = [$media_title, $media_content, $media_url, $media_type, $file_type, $media_image, $media_date, $user_id, $media_id];
        } else {
          if ($media_type == 'file') {
            $media_image =  '';
          }
          $inst_sql = "INSERT INTO media (media_title, media_content, media_url, media_type, user_id, media_file_type, media_image, media_publish_date, media_date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $inst_dta = [$media_title, $media_content, $media_url, $media_type, $user_id, $file_type, $media_image, $media_date, $date];
        }

        if (prep_exec($inst_sql, $inst_dta, $sql_request_data[2])) {
          $media_id = ($media_id == 0) ? $connect->lastInsertId() : $media_id;

          if (!$media_id) {
            // $data['url'] = "refresh";
          }

          $data['success'] = true;
          $data['message'] = "Media content has been succesfully updated";

          if ($media_image != '') {
            $img_dir = GALLERY_URL;
            $gal_dir = $img_dir . $media_image . DS;

            if (!is_dir($gal_dir) && !file_exists($gal_dir)) {
              mkdir($gal_dir, 0777, true);

              $edit_img = (isset($old_image_url) && $old_image_url != $media_image) ? true : false;
            }

            $old_dir  = $img_dir . $old_image_url . DS;
            $old_files    = glob($old_dir . '*.*');

            if (isset($edit_img) && $edit_img) {
              foreach ($old_files as $file) {
                $img_exp  = explode(DS, $file);
                $img_name = end($img_exp);
                rename($file, $gal_dir . $img_name);
              }
            }

            $tmp_dir  = $img_dir . 'tmp' . DS;
            $files    = glob($tmp_dir . '*.*');

            foreach ($files as $file) {
              $img_exp  = explode(DS, $file);
              $img_name = end($img_exp);
              rename($file, $gal_dir . $img_name);
            }

            foreach ($files as $file) {
              if (is_file($file)) {
                unlink($file);
              }
            }
          } else {
            $_SESSION['media_id'] = $media_id;
          }
        }
      }
    }
  }

  // media remove
  if (isset($_POST['media_remove']) && $_POST['media_remove'] && isset($_POST['media_id'])) {
    $media_id = $_POST['media_id'];

    if (!empty($media_id)) {
      $req_sql = "UPDATE media SET media_status = 0 WHERE media_id = ? LIMIT 1";
      $req_dta = [$media_id];
      if (prep_exec($req_sql, $req_dta, $sql_request_data[2])) {
        $data['url'] = "refresh";
        $data['success'] = true;
        $data['message'] = "Media has been removed";
      } else {
        $data['error'] = true;
        $data['message'] = "Something went wrong, and your media is not removed";
      }
    }
  }

  // media apearance type
  if (isset($_POST['media_title']) && isset($_POST['media_content']) && isset($_POST['media_type']) && ($_POST['media_type'] == 'appearance' || $_POST['media_type'] == 'podcast')) {

    $media_title    = (isset($_POST['media_title'])) ? $_POST['media_title'] : '';
    $media_content  = (isset($_POST['media_content'])) ? $_POST['media_content'] : '';
    $media_url      = (isset($_POST['media_url'])) ? $_POST['media_url'] : '';
    $media_pubdate  = (isset($_POST['media_publish_date'])) ? $_POST['media_publish_date'] : '';
    $media_pubdate  = (!empty($media_pubdate)) ? date('Y-m-d H:i:s', strtotime($media_pubdate)) : $media_pubdate;
    $media_type     = (isset($_POST['media_type'])) ? $_POST['media_type'] : '';

    $media_id       = (isset($_POST['media_id']) && !empty($_POST['media_id'])) ? $_POST['media_id'] : '';

    if (!$data['error'] && empty($media_title)) {
      $data['error']    = true;
      $data['message']  = "Media title field is empty";
    }

    if (!$data['error'] && empty($media_pubdate)) {
      $data['error']    = true;
      $data['message']  = "Publication date cannot be blank";
    } 
    
    if (!$data['error'] && empty($media_content)) {
      $data['error']    = true;
      $data['message']  = "Media content field is empty";
    }

    $media_check = null;
    $media_check = get_media_by_title($media_title, $media_type);
    if (!$data['error'] && $media_check) {
      $data['error']    = true;
      $data['message']  = "Media tittle already exists";
    }

    $media                = get_media_by_id($media_id);

    if ($media_check && !empty($media) && $media_check['media_id'] == $media_id && $media_check['media_type'] == $media['media_type']) {
      $data['error']    = false;
      $data['message']  = "";
    }

    if (!$data['error']) {

      if (!empty($media_id)) {
        $req_sql = "UPDATE media SET media_title = ?, media_content = ?, media_url = ?, media_publish_date = ? WHERE media_id = ? LIMIT 1";
        $req_dta = [$media_title, $media_content, $media_url, $media_pubdate, $media_id];
      } else {
        $req_sql = "INSERT INTO media (media_title, media_content, media_url, media_type, user_id, media_publish_date, media_date_created) VALUES (?,?,?,?,?,?,?)";
        $req_dta = [$media_title, $media_content, $media_url, $media_type, $user_id, $media_pubdate, $date];
      }

      if (prep_exec($req_sql, $req_dta, $sql_request_data[2])) {
        $message          = (!empty($media_id)) ? 'updated' : 'published';
        $data['success']  = true;
        $data['message']  = "Your media content hab been " . $message;
        $data['url']      = "refresh";
      } else {
        $data['error']    = true;
        $data['message']  = "There was an error on updating your media content";
      }
    }
  }

  // media file docs
  if (!empty($_FILES['file_doc']) && ($_FILES['file_doc']['error'] === UPLOAD_ERR_OK) ) {

    if (is_uploaded_file($_FILES['file_doc']['tmp_name']) === false) {
      // throw new \Exception('Error on upload: Invalid file definition');
      $data['error']    = true;
      $data['messages'] = "Error on upload: Invalid file definition";
	  } else {
			if (isset($_SESSION['media_id'])) {

				$media_id 		= $_SESSION['media_id'];
        
        $image        = $_FILES['file_doc'];
        $img_temp     = $image['tmp_name'];

        if ($media = get_media_by_id($media_id)) {
          $crnt_img   = $media['media_image'];
          $orgn_name  = $slugify->slugify($media['media_title']);
          $media_type = $media['media_type'];
          $dir_url 	  = FILES_PATH ;

          // Rename the uploaded file
          $img_name   = $image['name'];
          $img_type   = strtolower(substr($img_name, strripos($img_name, '.')+1));
          $img_name   = $orgn_name.'.'.$img_type;

          $img_dir    = $dir_url;
          $img_url    = $img_dir . $img_name;

          $media_sql  = "UPDATE media SET media_image = ? WHERE media_id = ? LIMIT 1";
          $media_dta  = [$img_name, $media_id];

          if (prep_exec($media_sql, $media_dta, $sql_request_data[2])) {

            if (!is_dir($img_dir) && !file_exists($img_dir)) {
              mkdir($img_dir, 0777, true);
            }

            if(move_uploaded_file($image['tmp_name'], $img_url)){
              $tmp_dir  = MEDIA_TMP;
              // $files    = glob($tmp_dir.'*');
              // foreach ($files as $file) {
              //   unlink($file);
              // }

              $data['success']  = true;
              $data['message']  = "Successfully added file";
              unset($_SESSION['media_id']);

              if(file_exists($img_dir . $crnt_img) && is_file($img_dir . $crnt_img)){
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
        $img_name     = $image['name'];
        $img_type     = strtolower(substr($img_name, strripos($img_name, '.') + 1));
        $img_name     = $new_name . '.' . $img_type;

        $img_dir      = $dir_url . 'tmp';
        $img_url      = $img_dir . DS . $img_name;

        if (!is_dir($img_dir) && !file_exists($img_dir)) {
          mkdir($img_dir, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $img_url)) {
          $tmp_dir    = MEDIA_TMP;
          $files      = glob($tmp_dir . '*');
          // foreach ($files as $file) {
          //   if( is_file($file) ) {
          //     unlink($file);
          //   }
          // }

          $apnd       = '#page=1&zoom=75';

          $data['data']     = $img_name;
          $data['success']  = true;
          // $data['message']  = "Successfully added file";
          $data['image']    = ABS_FILES . 'tmp' . DS . $img_name . $apnd;
        }
      }
		}
  }

  // gallery
  if (is_array($_FILES) && isset($_FILES['product_images']) && !isset($_SESSION['media_id'])) {
    
    $media_id   = (isset($_POST['media_id']) && $_POST['media_id'] != '') ? $_POST['media_id'] : 0;
    $count      = 0;
    // $total_files 	= count($_FILES['product_images']['name']);
    if ($media_id) {
      $media    = get_media_by_id($media_id);
    }
    
    $dir_url    = ($media_id != 0 && isset($media)) ? GALLERY_URL . $media['media_image'] . DS : GALLERY_URL . 'tmp' . DS;
    if (!is_dir($dir_url) && !file_exists($dir_url)) {
      mkdir($dir_url, 0777, true);
    }

    foreach ($_FILES['product_images']['name'] as $name => $value) {
      $img_name       = $_FILES['product_images']['name'][$name];
      $img_type       = strtolower(substr($img_name, strripos($img_name, '.') + 1));
      $img_temp       = $_FILES['product_images']['tmp_name'][$name];
      $file_name      = explode('.', $_FILES['product_images']['name'][$name]);
      $allowed_ext    = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
      if (in_array($file_name[1], $allowed_ext)) {
        $new_name     = 'IM_IMG' . date('YmdHms') . $count . '.' . $file_name[1];
        $new_imgpath  = $dir_url . $new_name;
        if (move_uploaded_file($img_temp, $new_imgpath)) {
          chmod($new_imgpath, 0777);

          $array_size = array(1080, 1080);
          // continue reduce image size if more than MAX_IMG_SIZE
          $image_size = check_image_size($new_imgpath, $array_size);
          if ($image_size && is_array($image_size)) {
            image_resize($new_imgpath, $image_size);
          }

          $img_size   = filesize($new_imgpath);
          clearstatcache();

          while ($img_size >= MAX_IMG_SIZE * 1000) {
            
            $heith = $image_size[1];
            $width = $image_size[0];
            $ratio = $heith/$width;
            $array_size[0] = $image_size[0] - 10;  
            $array_size[1] = round($array_size[0] * $ratio);

            $image_size = check_image_size($new_imgpath, $array_size);
            if ($image_size && is_array($image_size)) {
              image_resize($new_imgpath, $image_size);
            }
            
            $img_size   = filesize($new_imgpath);
            clearstatcache();
          }

        }
      } else {
        $data['error']    = true;
        $data['message']  = 'invalid file format';
      }
      $count++;
    }

    $dir = ($media_id != 0 && isset($media)) ? ABS_GALLERY . $media['media_image'] . DS : ABS_GALLERY . 'tmp' . DS;

    if (!$data['error']) {

      $data['update']   = true;
      $data['image']    = global_imgs($dir, 'col-md-3', 24);
      $data['success']  = true;
      $data['message']  = 'image uploaded';
    }

    unset($_SESSION['media_id']);
  }

  // delete image from slide folder image
  if (isset($_POST['path']) && !empty($_POST['path'])) {
    $media_id = (isset($_POST['media_id']) && $_POST['media_id'] != '')?$_POST['media_id']:0;
    if ($media_id) {
      $media  = get_media_by_id($media_id);
    }
    $dir_url      = ($media_id != 0 && isset($media))? GALLERY_URL . $media['media_image'] .DS : GALLERY_URL . 'tmp' .DS;

    $image        = $_POST['image'];
    $post_path    = $_POST['path'];
    $path         = $dir_url . $image;

    if (file_exists($path)) {
      if (unlink($path)) {
        $data['url']     = 'remove';
        $data['success'] = true;
      }
    }
  }

  // email subscription ************************************************************************************************
  // email subscription
  if (isset($_POST['signup_email'])) {
    $name         = $_POST['name'];
    $last_name    = $_POST['last_name'];
    $signup_email = sanitize(strtolower($_POST['signup_email']));
    $full_name    = $name . ' ' . $last_name;

    $subscription_id = (isset($_POST['subscription_id']) && !empty($_POST['subscription_id'])) ? $_POST['subscription_id'] : null;

    if (empty($name)) {
      $data['error'] = true;
      $data['message'] = 'Please provide your name';
    }

    if (empty($last_name)) {
      $data['error'] = true;
      $data['message'] = 'Please provide you surname';
    }

    // email validity
    if (!filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {
      $data['error'] = true;
      $data['message'] = 'Incorect email format';
    }

    if (empty($signup_email)) {
      $data['error'] = true;
      $data['message'] = 'Please provide your email';
    }

    if (!$data['error']) {

      // check subcription if exists
      if ($subscription_id != null) {
        $chck_sql = "SELECT subscription_id, subscription_name, subscription_last_name, subscription_email, subscription_token, subscription_date_created, subscription_date_updated, subscription_status FROM email_subscription WHERE subscription_id = ? LIMIT 1";
        $chck_dta = [$subscription_id];
        $chck_qry = prep_exec($chck_sql, $chck_dta, $sql_request_data[0]);

        $email = $chck_qry['subscription_email'];

        $email_id = ($email == $signup_email) ? true : false;

        if (!$email_id && get_subscriber_by_email($signup_email)) {
          $data['error'] = true;
          $data['message'] = "There is already a user who currently uses this email";
        }
      } else {
        $chck_qry = get_subscriber_by_email($signup_email);
        if ($chck_qry) {
          $data['error']      = true;
          $data['message']    = "The email subscriber already exists, try to use a fifferent email";
        }
      }

      if (!$data['error']) {
        if ($chck_qry && $subscription_id != null) {
          $user = get_subscriber_by_email($chck_qry['subscription_email']);
          $sbscrp_sql = "UPDATE email_subscription SET subscription_status = 1, subscription_edit = 0, subscription_name = ?, subscription_last_name = ?, subscription_email = ? WHERE subscription_id = ? LIMIT 1";
          $sbscrp_dta = [$name, $last_name, $signup_email, $subscription_id];
        } else {
          $sbscrp_sql   = "INSERT INTO email_subscription (subscription_name, subscription_last_name, subscription_email, subscription_date_created) VALUES (?,?,?,?)";
          $sbscrp_dta   = [$name, $last_name, $signup_email, $date];
        }

        if ($sbscrp_qry   = prep_exec($sbscrp_sql, $sbscrp_dta, $sql_request_data[2])) {

          $last_id            = ( isset($subscription_id) && empty($subscription_id)) ? $subscription_id :  $connect->lastInsertId();
          $token              = db_hash($last_id);
          $token_url          = "/action?distroy=true&id=" . $last_id . "&token=" . $token . '&mail=' . $signup_email;

          $upd_sql            = "UPDATE email_subscription SET subscription_token = ? WHERE subscription_id = ? LIMIT 1";
          $upd_dta            = [$token, $last_id];
          if ($sql_res  = prep_exec($upd_sql, $upd_dta, $sql_request_data[2])) {
            $data['success']  = true;
            $data['message']  = "The email has been successfully subscribed";
          }

          $data['url'] = 'refresh';

          if ($data['success'] == true) {
            $data['error'] = '';
          } else {
            $data['success'] == false;
          }
        }
      }
    }
  }

  // remove subscription
  if (isset($_POST['subscribtion_remove']) && isset($_POST['subscribtion_id'])) {
    $subscription_id = $_POST['subscribtion_id'];

    if (!empty($subscription_id)) {
      $sbscrp_sql   = "UPDATE email_subscription SET subscription_status = 0, subscription_edit = 1 WHERE subscription_id = ? LIMIT 1";
      $sbscrp_dta   = [$subscription_id];

      if ($sbscrp_qry = prep_exec($sbscrp_sql, $sbscrp_dta, $sql_request_data[2])) {
        $data['success'] = true;
        $data['message'] = "Email has been succesfully unsubsribed";

        $data['url'] = 'refresh';
      }
    } else {
      $data['error']    = true;
      $data['message']  = 'Your subscription was not remove, Somwthing went wrong';
    }
  }

  // pages subscription ************************************************************************************************
  
  // page content
  if (isset($_POST['page_name']) && isset($_POST['article_content'])) {

    $page_content   = $_POST['article_content'];
    $page_id        = (isset($_POST['page_id']))? sanitize($_POST['page_id']):'';
    $page_name      = sanitize($_POST['page_name']);

    if (empty($page_content)) {
      $data['error']    = true;
      $data['message']  = "Page content is empty";
    }

    if (!$data['error'] && empty($page_name)) {
      $data['error']    = true;
      $data['message']  = "Page name is empty";
    }


    if (!$data['error']) {

      $db_page = get_page_content_by_name($page_name);
      if (!$db_page || $db_page == null) {
        $article_sql = "INSERT INTO page_contents (page_content_name, page_content, page_content_date_created) VALUES (?, ?, ?)";
        $article_dta = [$page_name, $page_content, $date];
      } else {
        $article_sql      = "UPDATE page_contents SET page_content_name = ?, page_content = ? WHERE page_content_name = ? LIMIT 1";
        $article_dta      = [$page_name, $page_content, $page_name];
        
      }

      if ( $sbscrp_qry = prep_exec($article_sql, $article_dta, $sql_request_data[2])) {
        $data['success'] = true;
        $data['message'] = "Page content has been updated!";

      }
    }
  }

  // booking & Events subscription ************************************************************************************************

  // bookings rsvp
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'rsvp_form') {
    $last_name      = $_POST['last_name'];
    $name           = $_POST['name'];
    $booking_email  = $_POST['user_email'];
    $contact        = $_POST['contact'];

    $attandence     = (isset($_POST['attandence'])) ? $_POST['attandence'] : '';
    $guests         = (isset($_POST['guests'])) ? (int) $_POST['guests'] : 0;

    $dietary        = (isset($_POST['dietary'])) ? $_POST['dietary'] : array();
    $dietary        = json_encode($dietary, true);

    $diet_comment   = $_POST['dietary_comment'];
    $message        = $_POST['comment'];

    $full_name      = $name . ' ' . $last_name;

    $event_id       = (isset($_POST['event'])? $_POST['event']:'');

    // attendance
    if (empty($attandence)) {
      $data['error'] = true;
      $data['message'] = 'Attandance option is empty';
    }

    // email validity
    if (!$data['error'] && !filter_var($booking_email, FILTER_VALIDATE_EMAIL)) {
      $data['error'] = true;
      $data['message'] = 'Incorect email format';
    }

    if (!$data['error'] && empty($booking_email)) {
      $data['error'] = true;
      $data['message'] = 'Please provide your email';
    }

    // check existance
    if (empty($event_id)) {
      $rsvp_user = get_event_by_email($booking_email);
    } else {
      $rsvp_user = null; 
    }
    

    if (!$data['error']  && $rsvp_user) {
      $data['error']    = true;
      $data['message']  = 'This email has already been used for booking';
    }

    if (!$data['error'] && empty($last_name)) {
      $data['error'] = true;
      $data['message'] = 'Please provide your last name (surname)';
    }

    if (!$data['error'] && empty($name)) {
      $data['error'] = true;
      $data['message'] = 'Please provide your name';
    }

    if (!$data['error'] && $guests > 2) {
      $data['error'] = true;
      $data['message'] = 'You can only bring no more than 2 guests';
    }

    if (!$data['error']) {

      if (!empty($event_id)) {
        $events_sql = "UPDATE events SET event_name = ?, event_last_name = ?, event_user_email =?, event_user_contact =?, event_attendance = ?, event_guests = ?, event_dietary = ?, event_dietary_message = ?, event_message = ?, event_date_updated = ? WHERE event_id = ? LIMIT 1";
        $events_dta = [$name, $last_name, $booking_email, $contact, $attandence, $guests, $dietary, $diet_comment, $message, $date, $event_id];
      } else {
        $events_sql = "INSERT INTO events (event_name, event_last_name, event_user_email, event_user_contact, event_attendance, event_guests, event_dietary, event_dietary_message, event_message, event_date_created, event_date_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $events_dta = [$name, $last_name, $booking_email, $contact, $attandence, $guests, $dietary, $diet_comment, $message, $date, $date];
      }
      

      $events_qry   = prep_exec($events_sql, $events_dta, $sql_request_data[2]);

      if ($events_qry) {

        $messsage   = (!empty($event_id))?'updated':'inserted';

        $data['success'] = true;
        $data['message'] = 'Your RSVP have been recieved ' . $messsage;
      } else {
        $data['error']   = true;
        $data['message'] = 'Your request was not submitted';
      }

    }
  }

  
  // quotation bookings
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'quotation_form') {
    $name           = (isset($_POST['name'])) ? $_POST['name'] : '';
    $last_name      = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $message        = (isset($_POST['booking_message'])) ? $_POST['booking_message'] : '';
    $booking_email  = (isset($_POST['booking_email'])) ? $_POST['booking_email'] : '';
    $booking_phone  = (isset($_POST['booking_phone'])) ? $_POST['booking_phone'] : '';

    $company_name   = (isset($_POST['event_company_name'])) ? $_POST['event_company_name'] : '';
    $event_period   = (isset($_POST['event_period'])) ? $_POST['event_period'] : '';
    $event_descript = (isset($_POST['event_description'])) ? $_POST['event_description'] : '';
    $event_address  = (isset($_POST['event_address'])) ? $_POST['event_address'] : '';

    $coll_address   = (isset($_POST['collection_addresss'])) ? $_POST['collection_addresss'] : '';
    $deli_address   = (isset($_POST['delivery_address'])) ? $_POST['delivery_address'] : '';

    $event_province = (isset($_POST['event_province'])) ? $_POST['event_province'] : '';
    $event_country  = (isset($_POST['event_country'])) ? $_POST['event_country'] : '';

    $event_type     = (isset($_POST['event_type']) && !empty($_POST['event_type'])) ? $_POST['event_type'] : null;

    if(empty($event_type)) {
      $event_type   = (isset($_POST['booking_type']) && !empty($_POST['booking_type'])) ? $_POST['booking_type'] : null;
    }

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


    // if (!$data['error'] && $event_type == null) {
    //   $data['error']    = true;
    //   $data['message']  = "Make sure that booking type option is selected";
    // }

    // booking date
    if (!$data['error'] && $event_type == 'shared' && $db_week != $week_day) {
      $data['error']    = true;
      $data['message']  = "Make sure that the selected date correcponds correctly with the selected scheduled day of the week";
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

    if (!$data['error'] && empty($event_province)) {
      $data['error'] = true;
      $data['message'] = 'Please select a province';
    }

    // if (!$data['error'] && empty($user_count)) {
    //   $data['error']    = true;
    //   $data['message']  = 'Please provide expected number of attendees/guests';
    // }

    if (!$data['error']) {

      if (!empty($event_id)) {
        $events_sql = "UPDATE events SET event_user_count =?, event_host_date = ?, event_user_name = ?, event_last_name = ?, event_user_email = ?, event_user_phone = ?, event_message = ?, event_type = ?, event_processed = ?, event_company_name = ?, event_description = ?, event_address = ?, event_period = ?, collection_addresss = ?, delivery_address = ?, event_province = ?, event_country = ? WHERE event_id = ? LIMIT 1";
        $events_dta = [$user_count, $event_date, $name, $last_name, $booking_email, $booking_phone, $message, $event_type, $complete, $company_name, $event_descript, $event_address, $event_period, $controller, $deli_address, $event_province, $event_country, $event_id,];
      } else {
        $events_sql = "INSERT INTO events (event_user_count, event_host_date, event_user_name, event_last_name, event_user_email, event_user_phone, event_message, event_type, event_date_created, event_date_updated, event_processed, event_company_name, event_description, event_address, event_period, collection_addresss, delivery_address, event_province, event_country) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $events_dta = [$user_count, $event_date, $name, $last_name, $booking_email, $booking_phone, $message, $event_type, $date, $date, $complete, $company_name, $event_descript, $event_address, $event_period, $coll_address, $deli_address, $event_province, $event_country,];
      }

      if (prep_exec($events_sql, $events_dta, $sql_request_data[2])) {

         // Send email preparation
         $client_ifo = array(
          "fullname"        => $full_name,
          "name"            => $name,
          "last_name"       => $last_name,
          "email"           => $booking_email,
          "contact"         => $booking_phone,
          "company"         => $company_name,
          "event_type"      => $caurier_booking_navba[$event_type]['short'],
          "description"     => $event_descript,
          "coll_address"    => $coll_address,
          "dell_address"    => $deli_address,
          "event_date"      => $event_date,
          "event_period"    => (!empty($event_period))? $booking_period[$event_period] : '',
          "attendees"       => $user_count,
          "message_text_1"  => "Thank you for requesting a quote. We will get in touch with you sooner.",
          "message_text_2"  => "Here are your quote details:",
          "message_type"    => 'user',
          "message"         => $message,
        );

        // Prepare to send email *************************************************
        $from         = MAIL_FROM;

        $to_usrs      = array(
          "name"      => $full_name,
          "email"     => $booking_email
        );

        $subject      = "Booking Recieved";
        $html         =  event_notification($client_ifo);

        // if ($mailer->mail(array($to_usrs), $subject, $html, $from)) {

        //   $client_ifo["name"]             = $_ENV["MAIL_USER"];
        //   $client_ifo["message_text_1"]   = "There is a new quote request from your website.";
        //   $client_ifo["message_text_2"]   = "Here are the details,";
        //   $client_ifo["message_type"]     = 'admin';

        //   $subject    = "New Booking";
        //   $html       =  event_notification($client_ifo);

        //   $mailer->mail->clearAllRecipients();
        //   if ($mailer->mail(array(array("name"    => $_ENV["MAIL_USER"], "email"   => $_ENV['MAIL_MAIL'])), $subject, $html, $from)) {
        //     $data['success'] = true;
        //   }
        // }
        
        $message          = (!empty($event_id)) ? 'updated' : 'created';

        $data['success']  = true;
        
        $data['message']  = (!isset($_SESSION['user_id'])) ? 'You have succesfully made a quote request, please check your email for confirmation' : 'Your booking has been ' . $message;
      } else {
        $data['error']    = true;
        $data['message']  = 'Your request was not succssfully submitted';
      }
    }
  }
  
  // bookings form
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'booking_form') {
     $name           = (isset($_POST['name'])) ? $_POST['name'] : '';
    $last_name      = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $message        = (isset($_POST['booking_message'])) ? $_POST['booking_message'] : '';
    $booking_email  = (isset($_POST['booking_email'])) ? $_POST['booking_email'] : '';
    $booking_phone  = (isset($_POST['booking_phone'])) ? $_POST['booking_phone'] : '';

    $company_name   = (isset($_POST['event_company_name'])) ? $_POST['event_company_name'] : '';
    $event_period   = (isset($_POST['event_period'])) ? $_POST['event_period'] : '';
    $event_descript = (isset($_POST['event_description'])) ? $_POST['event_description'] : '';
    $event_address  = (isset($_POST['event_address'])) ? $_POST['event_address'] : '';

    $coll_address   = (isset($_POST['collection_addresss'])) ? $_POST['collection_addresss'] : '';
    $deli_address   = (isset($_POST['delivery_address'])) ? $_POST['delivery_address'] : '';

    $event_province = (isset($_POST['event_province'])) ? $_POST['event_province'] : '';
    $event_country  = (isset($_POST['event_country'])) ? $_POST['event_country'] : '';

    $event_type     = (isset($_POST['event_type']) && !empty($_POST['event_type'])) ? $_POST['event_type'] : null;

    if(empty($event_type)) {
      $event_type   = (isset($_POST['booking_type']) && !empty($_POST['booking_type'])) ? $_POST['booking_type'] : null;
    }

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


    // if (!$data['error'] && $event_type == null) {
    //   $data['error']    = true;
    //   $data['message']  = "Make sure that booking type option is selected";
    // }

    // booking date
    if (!$data['error'] && $event_type == 'shared' && $db_week != $week_day) {
      $data['error']    = true;
      $data['message']  = "Make sure that the selected date correcponds correctly with the selected scheduled day of the week";
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

    if (!$data['error'] && empty($event_province)) {
      $data['error'] = true;
      $data['message'] = 'Please select a province';
    }

    // if (!$data['error'] && empty($user_count)) {
    //   $data['error']    = true;
    //   $data['message']  = 'Please provide expected number of attendees/guests';
    // }

    if (!$data['error']) {

      if (!empty($event_id)) {
        $events_sql = "UPDATE events SET event_user_count =?, event_host_date = ?, event_user_name = ?, event_last_name = ?, event_user_email = ?, event_user_phone = ?, event_message = ?, event_type = ?, event_processed = ?, event_company_name = ?, event_description = ?, event_address = ?, event_period = ?, collection_addresss = ?, delivery_address = ?, event_province = ?, event_country = ? WHERE event_id = ? LIMIT 1";
        $events_dta = [$user_count, $event_date, $name, $last_name, $booking_email, $booking_phone, $message, $event_type, $complete, $company_name, $event_descript, $event_address, $event_period, $controller, $deli_address, $event_province, $event_country, $event_id,];
      } else {
        $events_sql = "INSERT INTO events (event_user_count, event_host_date, event_user_name, event_last_name, event_user_email, event_user_phone, event_message, event_type, event_date_created, event_date_updated, event_processed, event_company_name, event_description, event_address, event_period, collection_addresss, delivery_address, event_province, event_country) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $events_dta = [$user_count, $event_date, $name, $last_name, $booking_email, $booking_phone, $message, $event_type, $date, $date, $complete, $company_name, $event_descript, $event_address, $event_period, $coll_address, $deli_address, $event_province, $event_country,];
      }

      if (prep_exec($events_sql, $events_dta, $sql_request_data[2])) {
        $message    = (!empty($event_id))?'updated':'created';

        $data['success'] = true;
        $data['message'] = 'Your booking has been ' . $message;
      } else {
        $data['error']   = true;
        $data['message'] = 'Your request was not submitted';
      }

    }
  }

  // event booking
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'events_form') {
    $event_title    = (isset($_POST['event_title'])) ? $_POST['event_title'] : '';
    $event_venue    = (isset($_POST['event_venue'])) ? $_POST['event_venue'] : '';
    $event_descrpt  = (isset($_POST['event_description'])) ? $_POST['event_description'] : '';

    $company_name   = (isset($_POST['event_company_name'])) ? $_POST['event_company_name'] : '';
    $event_period   = (isset($_POST['event_period'])) ? $_POST['event_period'] : '';
    $event_descript = (isset($_POST['event_description'])) ? $_POST['event_description'] : '';
   
    $event_type     = (isset($_POST['event_type']) && !empty($_POST['event_type'])) ? $_POST['event_type'] : null;

    if(empty($event_type)) {
      $event_type   = (isset($_POST['booking_type']) && !empty($_POST['booking_type'])) ? $_POST['booking_type'] : null;
    }

    $event_id       = (isset($_POST['event'])) ? $_POST['event'] : '';

    // dfate 
    $dob            = (isset($_POST['dob'])) ? $_POST['dob'] : '';
    $mob            = (isset($_POST['mob'])) ? $_POST['mob'] : '';
    $yob            = (isset($_POST['yob'])) ? $_POST['yob'] : '';

    $tod            = (isset($_POST['start_hour'])) ? (int) $_POST['start_hour'] : '';
    $tend           = (isset($_POST['end_hour'])) ? (int) $_POST['end_hour'] : '';

    // shared booking type
    $service_id     = (isset($_POST['departure_destination'])) ? $_POST['departure_destination'] : 0;
    $booking_date   = (isset($_POST['booking_date']) ? date('Y-m-d H:i:s', strtotime($_POST['booking_date'])) : '');

    $complete       = (isset($_POST['booking_complete'])) ? 1 : 0;


    $db_week        = '';
    $service_type   = '';
    
    // charter booking type
    $tod_date       = date('H:i', mktime(0, $tod * 60));
    $tend_date      = date('H:i', mktime(0, $tend * 60));
    $event_date     = $yob . '-' . $mob . '-' . $dob . ' ' . $tod_date;
    $event_end_date = $yob . '-' . $mob . '-' . $dob . ' ' . $tend_date;
    $booking_time   = date("Y-m-d H:i:s", strtotime($event_date));

    $event_date     = date('Y-m-d H:i', strtotime($booking_time));

    // validate allowed booking date
    $hour           = date('H');
    $minute         = (date('i') > 30) ? '60' : '30';
    $time_round     = "$hour:$minute:00";

    $date_norm      = date("Y-m-d");

    $current_date   = date("Y-m-d H:i:s");

    if (!$data['error'] && $booking_time <= $current_date) {
      $data['error']    = true;
      $data['message']  = "Your choosen date and or time is in the past. Choose a different date and time";
    }

    if (!$data['error'] && $tend_date <= $tod_date) {
      $data['error']    = true;
      $data['message']  = "Event end time is behind your start time";
    }

    // email validity
    if (!$data['error'] && empty($event_title)) {
      $data['error']    = true;
      $data['message']  = 'Provide event title';
    }

    if (!$data['error'] && empty($event_venue)) {
      $data['error']    = true;
      $data['message']  = 'Please provide event venue';
    }

    if (!$data['error']) {

      if (!empty($event_id)) {
        $events_sql = "UPDATE events SET event_title = ?, event_host_date = ?, event_venue = ?, event_description = ?, event_type = ?, event_begin_date = ?, event_end_date = ? WHERE event_id = ? LIMIT 1";
        $events_dta = [$event_title, $event_date, $event_venue, $event_descript, $event_type, $event_date, $event_end_date, $event_id,];
      } else {
        $events_sql = "INSERT INTO events (event_title, event_host_date, event_venue, event_description, event_type, event_begin_date, event_end_date) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
        $events_dta = [$event_title, $event_date, $event_venue, $event_descript, $event_type, $event_date, $event_end_date];
      }

      if (prep_exec($events_sql, $events_dta, $sql_request_data[2])) {
        $message    = (!empty($event_id)) ? 'updated' : 'created';

        $data['success']  = true;
        $data['message']  = 'Your event has been ' . $message;
        $data['url']      = 'refresh';
      } else {
        $data['error']    = true;
        $data['message']  = 'Your request was not submitted';
      }
    }
  }

  // settings ************************************************************************************************************
  // subscription popup
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'subscription_popup') {

    $value = (isset($_POST['form_value'])) ?  (int) $_POST['form_value']:'';

    $sql = "UPDATE settings SET subscription_popup = ? WHERE user_id = 1 LIMIT 1";
    $dta = [$value];

    if (prep_exec($sql, $dta, $sql_request_data[2])) {

    }


  }

  // subscription active
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'subscription_active') {

    $value = (isset($_POST['form_value'])) ?  (int) $_POST['form_value'] : '';

    $sql = "UPDATE settings SET subscription_active = ? WHERE user_id = 1 LIMIT 1";
    $dta = [$value];

    if (prep_exec($sql, $dta, $sql_request_data[2])) {
    }
  }

  // article email type
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'article_email_type') {

    $value = (isset($_POST['form_value'])) ?  (int) $_POST['form_value'] : '';

    $sql = "UPDATE settings SET article_email_length = ? WHERE user_id = 1 LIMIT 1";
    $dta = [$value];

    if (prep_exec($sql, $dta, $sql_request_data[2])) {
    }
  }

  // article header
  if (isset($_POST['form_name']) && $_POST['form_name'] == 'article_header') {

    $value = (isset($_POST['article_content'])) ?  $_POST['article_content'] : '';

    $sql = "UPDATE settings SET setting_email_header = ? WHERE user_id = 1 LIMIT 1";
    $dta = [$value];

    if (prep_exec($sql, $dta, $sql_request_data[2])) {
    }
  }

  // article footer
  if (isset($_POST['form_name']) && $_POST['form_name'] == 'article_footer') {

    $value = (isset($_POST['article_content'])) ?  $_POST['article_content'] : '';

    $sql = "UPDATE settings SET setting_email_footer = ? WHERE user_id = 1 LIMIT 1";
    $dta = [$value];

    if (prep_exec($sql, $dta, $sql_request_data[2])) {
    }
  }

  // careers form
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'career_form') {
    $career_id          = (isset($_POST['career'])) ?  $_POST['career'] : '';
    $career_name        = (isset($_POST['career_name'])) ?  $_POST['career_name'] : '';
    $career_type        = (isset($_POST['career_type'])) ?  $_POST['career_type'] : '';
    $career_location    = (isset($_POST['career_location'])) ?  $_POST['career_location'] : '';
    $career_amount      = (isset($_POST['career_amount'])) ?  $_POST['career_amount'] : '';
    $career_descript    = (isset($_POST['career_description'])) ?  $_POST['career_description'] : '';

    $pub_dob            = (isset($_POST['closing_day'])) ? $_POST['closing_day'] : '';
    $pub_mob            = (isset($_POST['closing_month'])) ? $_POST['closing_month'] : '';
    $pub_yob            = (isset($_POST['closing_year'])) ? $_POST['closing_year'] : '';
    $closing_date       = (!empty($pub_dob) && !empty($pub_mob) && !empty($pub_yob)) ? date("Y-m-d H:i:s", strtotime($pub_yob . '/' . $pub_mob . '/' . $pub_dob)) : '';

    if (!$data['error'] && empty($closing_date)) {
      $data['error']    = true;
      $data['message']  = "Provide career closing date date";
    }

    if (!$data['error'] && empty($career_name)) {
      $data['error']    = true;
      $data['message']  = "Provide career name";
    }

    if (!$data['error'] && empty($career_type)) {
      $data['error']    = true;
      $data['message']  = "Provide career type";
    }

    if (!$data['error']) {
      if (!empty($career_id)) {
        $career_sql     = "UPDATE careers SET career_closing_date = ?, career_name = ?, career_period_type = ?, career_amount = ?, career_location = ?, career_description = ? WHERE career_id = ? LIMIT 1";
        $career_dta     = [$closing_date, $career_name, $career_type, $career_amount, $career_location, $career_descript, $career_id];
      } else {
        $career_sql     = "INSERT INTO careers (career_closing_date, career_name, career_period_type, career_amount, career_location, career_description) VALUES  (?, ?, ?, ?, ?, ?)";
        $career_dta     = [$closing_date, $career_name, $career_type, $career_amount, $career_location, $career_descript];
      }

      if (prep_exec($career_sql, $career_dta, $sql_request_data[2])) {
        $message          = (!empty($career_id)) ? 'updated' : 'created';

        $data['success']  = true;
        $data['message']  = 'Career has been ' . $message;
        $data['url']      = 'refresh';
      } else {
        $data['error']    = true;
        $data['message']  = 'Your request was not submitted';
      }
    }

  }


  // user types
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'user_type_form') {
    $user_type_id   = (isset($_POST['user_type_id'])) ? $_POST['user_type_id'] : '';
    $user_type      = (isset($_POST['user_type'])) ? $_POST['user_type'] : '';
    $is_admin       = (isset($_POST['is_admin']) && !empty($_POST['is_admin'])) ? 1 : 0;
    $execute        = (isset($_POST['execute']) && !empty($_POST['execute'])) ? 1 : 0;
    $write          = (isset($_POST['write']) && !empty($_POST['write'])) ? 1 : 0;
    $read           = (isset($_POST['read']) && !empty($_POST['read'])) ? 1 : 0;

    $user_type_slug = $slugify->slugify($user_type);

    $user_type_res  = get_user_type_by_id($user_type_id);
    $user_type_ext  = get_user_type_by_name($user_type);
    
    if (empty($user_type)) {
      $data['error']    = true;
      $data['message']  = "Provide user type";
    }

    if (!$data['error'] && !empty($user_type_id) && empty($user_type_res)) {
      $data['error']    = true;
      $data['message']  = "User type does not exists";
    }

    if (!$data['error'] && empty($user_type_id) && !empty($user_type_ext) && $user_type_ext['user_type_status'] == 1) {
      $data['error']    = true;
      $data['message']  = "User type already exists";
    }

    if (!$data['error']) {
      if(!empty($user_type_res) && $user_type_res['user_type_status'] == 1) {
        $sql = "UPDATE user_types SET user_type = ?, user_type_slug = ?, user_type_admin = ?, permission_execute = ?, permission_write = ?, permission_read = ? WHERE user_type_id = ? LIMIT 1";
        $dta = [$user_type, $user_type_slug, $is_admin, $execute, $write, $read, $user_type_id];
      } elseif(!empty($user_type_ext) && $user_type_ext['user_type_status'] == 0){
        $sql = "UPDATE user_types SET user_type_slug = ?, user_type_admin = ?, permission_execute = ?, permission_write = ?, permission_read = ? , user_type_status = 1 WHERE user_type = ? LIMIT 1";
        $dta = [$is_admin, $execute, $write, $read, $user_type];
      } else {
        $sql = "INSERT INTO user_types (user_id, company_id, user_type, user_type_slug, user_type_admin, permission_execute, permission_write, permission_read) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $dta = [$user_id, $company_id, $user_type, $user_type_slug, $is_admin, $execute, $write, $read];
      }

      if (prep_exec($sql, $dta, $sql_request_data[2])) 
      {
        $data['message']  = "User type has been updated"; 
        $data['url']      = 'refresh';
        $data['success']  = true;
      }

    }
  }

  // remove user type
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'user_type_remove') {
    $user_type_id       = (isset($_POST['user_type_id'])) ? $_POST['user_type_id'] : '';

    $user_type = get_user_type_by_id($user_type_id);

    if (!$data['error'] && empty($user_type)) {
      $data['error']    = true;
      $data['message']  = "User type does not exists";
    }

    if (!$data['error']) {
      $sql = "UPDATE user_types SET user_type_status = 0 WHERE user_type_id = ? LIMIT 1";
      $dta = [$user_type_id];

      if (prep_exec($sql, $dta, $sql_request_data[2])) 
      {
        $data['url']      = 'refresh';
        $data['success']  = true;
      }

    }
  }



  // Clients task association ************************************************************************************************************
  // add task categories
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'category_form') {
    $category_id   = (isset($_POST['category_id'])) ? $_POST['category_id'] : '';
    $category      = (isset($_POST['category'])) ? $_POST['category'] : '';

    $category_slug = $slugify->slugify($category);

    $category_res  = get_category_by_id($category_id);
    $category_ext  = get_category_name($category);
    
    if (empty($category)) {
      $data['error']    = true;
      $data['message']  = "Provide task category";
    }

    if (!$data['error'] && !empty($category_id) && empty($category_res)) {
      $data['error']    = true;
      $data['message']  = "Task category does not exists";
    }

    if (!$data['error'] && empty($category_id) && !empty($category_ext) && $category_ext['category_status'] == 1) {
      $data['error']    = true;
      $data['message']  = "Task category already exists";
    }

    if (!$data['error']) {
      if(!empty($category_res) && $category_res['category_status'] == 1) {
        $sql = "UPDATE task_categories SET category = ?, category_slug = ? WHERE category_id = ? LIMIT 1";
        $dta = [$category, $category_slug, $category_id];
      } else {
        $sql = "INSERT INTO task_categories (user_id, company_id, category, category_slug) VALUES (?, ?, ?, ?)";
        $dta = [$user_id, $company_id, $category, $category_slug];
      }

      if (prep_exec($sql, $dta, $sql_request_data[2])) 
      {
        $data['message']  = "Task category has been " . (!empty($category_res)) ? 'updated' : 'created';
        $data['url']      = 'refresh';
        $data['delayed']  = true;
        $data['seconds']  = 5000;
        $data['success']  = true;
      }

    }
  }

  // remove user type
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'category_remove') {
    $category_id        = (isset($_POST['category_id'])) ? $_POST['category_id'] : '';
    $category           = get_category_by_id($category_id);

    if (!$data['error'] && empty($user_type)) {
      $data['error']    = true;
      $data['message']  = "Taskk category does not exists";
    }

    if (!$data['error']) {
      $sql = "UPDATE task_categories SET category_status = 0 WHERE category_id = ? LIMIT 1";
      $dta = [$category_id];

      if (prep_exec($sql, $dta, $sql_request_data[2])) 
      {
        $data['url']      = 'refresh';
        $data['success']  = true;
      }

    }
  }



  // Clients task association ************************************************************************************************************
  // add Clients task association
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'member_add') {

    $practice_area  = (isset($_POST['practice_area'])) ? $_POST['practice_area'] : '';
    $name           = (isset($_POST['name'])) ? $_POST['name'] : '';
    $name_other     = (isset($_POST['name_other'])) ? $_POST['name_other'] : '';
    $reference      = (isset($_POST['reference'])) ? $_POST['reference'] : '';
    $identity       = (isset($_POST['identity'])) ? $_POST['identity'] : '';
    $description    = (isset($_POST['description'])) ? $_POST['description'] : '';

    $clients        = (isset($_POST['clients'])) ? $_POST['clients'] : '';

    $client_assct_id  = (isset($_POST['post_user'])) ? $_POST['post_user'] : '';



    if (!$data['error'] && empty($client_assct_id)) {
      // if (get_client_association_by_name_other($description)) {
      //   $data['error']    = false;
      //   $data['message']  = "User with the same surname and initials exists already exists";
      // }
    }

    if (!$data['error'] && empty($name)) {
      $data['error']      = true;
      $data['message']    = "A client association name cannot be blank";
    }

    if (!$data['error'] && get_client_association_by_reference($reference)) {
      $data['error']      = true;
      $data['message']    = "A client association with the same reference number already exists";
    }

    if (!$data['error'] && !empty($identity) && get_client_association_by_identity($identity)) {
      $data['error']      = true;
      $data['message']    = "A client association with the same identity number already exists";
    }

    $practice           = get_practice_area_by_id($practice_area);
    if (!$data['error'] && !$practice) {
      $data['error']    = true;
      $data['message']  = "Please ensure that practice area is selected and valid";
    }

    if (!$data['error']) {
      $msg_dta = array();

      if (!empty($client_assct_id)) {
        $member             = get_client_association_by_id($client_assct_id);
        $msg_dta['new']     = array(
          'name'            => $name,
          'name_other'      => $name_other,
          'practice_area'   => $practice_area,
          'reference'       => $reference,
          'description'     => $description,
          'identity'        => $member['association_identity'],
        );

        $msg_dta['old'] = array(
          'name'            => $member['association_name'],
          'name_other'      => $member['association_name_other'],
          'practice_area'   => $member['practice_area_id'],
          'reference'       => $member['association_reference'],
          'description'     => $member['association_description'],
          'identity'        => $member['association_identity'],
        );

        $key_dta    = 'update';

        $ins_sql    = "UPDATE client_associations SET association_name = ?, association_name_other = ?, association_description = ?, association_reference = ?, association_identity = ?, practice_area_id = ? WHERE client_association_id = ? LIMIT 1";
        $ins_dta    = [$name, $name_other, $description, $reference, $identity, $practice_area, $client_assct_id];
      } else {
        $ins_sql    = "INSERT INTO client_associations (company_id, office_id, association_name, association_name_other, association_description, association_reference, association_identity, practice_area_id, user_id) VALUES (?,?,?,?,?,?,?,?,?)";
        $ins_dta    = [$company_id, $office_id, $name, $name_other, $description, $reference, $identity, $practice_area, $user_id];
        $key_dta    = 'insert';
        $msg_dta    = 'insert';
      }

      if (prep_exec($ins_sql, $ins_dta, $sql_request_data[2])) {
        $notif_db   = 'client_associations';
        $client_assct_id  = ($msg_dta == 'insert') ? $connect->lastInsertId() : $client_assct_id;
        $msg_dta    = (is_array($msg_dta)) ? json_encode($msg_dta, true) : $msg_dta;
        if (insert_notifications($user_id, $client_assct_id, $notif_db, $client_assct_id, 0, 0, $msg_dta, $key_dta)) {
          $data['url']      = 'refresh';
          $data['success']  = true;
        }

        $client_assct_id    = ($key_dta == 'insert') ? $connect->lastInsertID() : $client_assct_id;
        
        if (!empty($clients)) {
          foreach ($clients as $key => $value) {
            $usr_id             = $value;
            $user               = get_client_association_by_user_id($usr_id, $client_assct_id, false);
            $state_msg          = ($user) ? 1 : 'insert';

            if (!$data['error'] && $user && $user['association_status'] == 1) {
              $data['error']    =   true;
              $data['message']  = 'Already assigned';
            }

            if (!$data['error']) {
              if (!$user) {
                $assc_sql       = "INSERT INTO associations (creator_user_id, practice_area_id, user_id, client_association_id) VALUES (?, ?, ?, ?)";
              } elseif ($user && $user['association_status'] != 1) {
                $assc_sql       = "UPDATE associations set association_status = 1, creator_user_id = ?, practice_area_id = ? WHERE user_id = ? AND client_association_id = ?  LIMIT 1";
              }

              $assc_dta         = [$user_id, $practice_area, $usr_id, $client_assct_id];

              if (prep_exec($assc_sql, $assc_dta, $sql_request_data[2])) {

                $notif_db       = 'associations';
                $db_table       = ($user) ? 'association_status' : '';
                if (insert_notifications($user_id, $client_assct_id, $notif_db, $usr_id, 0, 0, $state_msg, $db_table)) {
                }
              }
            }
          }
          
          $data['error']  = false;
        }

        $data['message']  = 'A client association has been succesfully updated';
        // $data['url']      = 'refresh';
        $data['delayed']  = true;
        $data['seconds']  = 9000;
        $data['success']  = true;
      }
    }
  }

  // update client associations
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'member_update') {

    $client_assct_id      = $_POST['member'];
    $practice_id          = (isset($_POST['practice']) && !empty($_POST['practice'])) ? $_POST['practice'] : 1;
    $member               = get_client_association_by_id($client_assct_id);
    $upd_sts              = true;
    $sql_dta              = '';
    $msg_type             = '';

    if (!empty($client_assct_id) && $member) {
      $notif_db           = 'activity_tasks';
      $notif_key          = 'activity_task_date';
      // clients
      $clients            = get_association_user_by_client_association_id($client_assct_id);
      $practice_tasks     = get_practice_tasks_by_practice($practice_id);

      $member_name        = $member['association_name'];
      $msg_dta            = array();
      $new_sql_dta        = array();
      $old_sql_dta        = array();
      
      if (is_array($practice_tasks) || is_object($practice_tasks)) {
        foreach ($practice_tasks as $key => $val) {
          // $post_date      = $_POST[$key];
          $upd_sts          = (isset($val['activity_task_date']) && !empty($val['activity_task_date'])) ? true : false;
          $old_mbr_dat      = ($upd_sts) ? date(DATE_FORMAT, strtotime($val['activity_task_date'])) : '';
  
          if (isset($_POST['activity'.$key]) && !empty($_POST['activity'.$key])) {
            $member_date    = date(DATE_FORMAT, strtotime($_POST['activity'.$key]));
            $task_id        = $val['practice_task_id'];
            $update_type    = 'insert';
  
  
            if ($member_date != $old_mbr_dat && !empty($old_mbr_dat)) {
              $sql_dta          .= (string) $key . " = '" . $member_date . "',";
  
              $new_sql_dta[$key] = $member_date;
              $old_sql_dta[$key] = $old_mbr_dat;
  
              $update_type        = 'update';
            } elseif($member_date == $old_mbr_dat) {
              continue;
            } 
  
            
            // update activity
            if ($activity_task  = get_activity_tasks_by_practice_task ($client_assct_id, $task_id)) {
              update_activity_task ($member_date, $user_id, $client_assct_id, $task_id);
            } else {
              insert_activity_task ($user_id, $client_assct_id, $task_id, $member_date);
            }
            
            // update and send email
            if ($upd_sts == false) {
              insert_notifications($user_id, $client_assct_id, $notif_db, $task_id, 0, 0, $member_date, $update_type);
  
              // **************** send SMS
              if (isset($val['practice_task_sms']) && $val['practice_task_sms'] && (is_array($clients) || is_object($clients)) ) {
                foreach ($clients as $keys => $value) {
                  $usr_id       = $value['user_id'];
                  $client       = get_user_by_id($usr_id);
                  $phone        = $client['contact_number'];
                  $d_name       = $member_name;
                  $msg_array    = $val['practice_task_sms_text'];
                  $msg_array    = str_replace('Name', $d_name, $msg_array);
                  $message      = ($msg_type == 'consultation') ? str_replace('Cell', $phone, str_replace('Password', $phone, $msg_array)) : $msg_array;
  
                  $err          = true;
                  if ($message && $phone) {
                    // list($err, $response) = post_sms_message($message, $phone, $usr_id);
                  }
  
                  if ((!$err || $err == '200') && isset($response)) {
                    if (is_array($response) || is_object($response)) {
                      // echo $response;
                    } else {
                      $response = json_decode($response, true);
                    }
  
                    $amount     = $response['cost'];
                    $payment_id = $response['eventId'];
                    $msg_res    = $response['sample'];
                    $cost_break = $response['costBreakdown'];
  
                    $ins_sql    = "INSERT INTO sms_orders (user_id, company_id, client_association_id, practice_task_id, order_confirmation, confirmation_token, order_complete, order_amount, order_amount_net, order_payment_id, order_token, order_status, order_payment_status, order_message, order_billing_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $ins_dta    = [$usr_id, $company_id, $client_assct_id, $task_id, 1, '', 1, $amount, $amount, $payment_id, '', 1, 1, $msg_res, $date];
  
                    if (prep_exec($ins_sql, $ins_dta, $sql_request_data[2])) {
                      // $data['url']      = 'refresh';
                      $data['success']  = true;
                      $data['message']  = "SMS has been successfully sent";
                      // $data['data']     = $response;
                    }
                  }
                }
              } // send SMS
            }
  
            $data['success'] = true;
            $data['message'] = "Update was successful";
  
          } else {
            continue;
          }
        }
      } else {
        $data['error']      = true;
        $data['message']    = 'There are curently no tasks, create tasks from <a class="font-weight-bolder" href="./admin">The Admin Page</a>';
      }

    } else {
      $data['error']        = true;
      $data['message']      = "Something went wrong, please refresh the page or try again later";
    }
  }

  // remove client association
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'remove_association') {
    $usr_id = (isset($_POST['user'])) ? $_POST['user'] : '';

    if (get_client_association_by_id($usr_id)) {
      $stmnt_sql          = "UPDATE client_associations SET client_association_status = 0 WHERE client_association_id = ? LIMIT 1";
      $stmnt_dta          = [$usr_id];

      if (prep_exec($stmnt_sql, $stmnt_dta, $sql_request_data[2])) {

        $notif_db         = 'client_associations';
        $state_msg        = 'remove';
        if (insert_notifications($user_id, $usr_id, $notif_db, $usr_id, 0, 0, $state_msg, 'client_association_status')) {
        }

        $data['url']      = 'refresh';
        $data['success']  = true;
      }
    }
  }

  // remove association
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'remove_member') {
    $client_assct_id  = $_POST['member'];
    $usr_id     = $_POST['user'];

    if (!empty($client_assct_id)) {
      $rmv_sql = "UPDATE associations set association_status = 0, creator_user_id = ? WHERE user_id = ? AND client_association_id = ? LIMIT 1";
      $rmv_dta = [$user_id, $usr_id, $client_assct_id];

      if (prep_exec($rmv_sql, $rmv_dta, $sql_request_data[2])) {

        $notif_db         = 'associations';
        $state_msg        = 'update';
        if (insert_notifications($user_id, $client_assct_id, $notif_db, $usr_id, 0, 0, 0, 'association_status')) {
        }

        // $data['url']      = 'remove';
        $data['url']      = 'refresh';
        $data['success']  = true;
      }
    }
  }

  // add/update associations
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'search_assign') {
    $usr_id           = (isset($_POST['user'])) ? $_POST['user'] : '';
    $client_assct_id  = (isset($_POST['member'])) ? $_POST['member'] : '';
    $user_type        = (isset($_POST['user_type'])) ? $_POST['user_type'] : '';

    $practice_area_id = (isset($_POST['practice_area'])) ? $_POST['practice_area'] : '';

    $practice         = get_practice_area_by_id($practice_area_id);

    $user             = get_client_association_by_user_id($usr_id, $client_assct_id, false);
    $state_msg        = ($user) ? 1 : 'insert';

    if (!$data['error'] && !$practice) {
      $data['error']    = true;
      $data['message']  = "Please ensure that practice area is selected and valid";
    }

    if (!$data['error'] && $user && $user['association_status'] == 1) {
      $data['error'] =   true;
      $data['message']  = 'Already assigned';
    }

    if (!$data['error']) {
      if (!$user) {
        $rmv_sql  = "INSERT INTO associations (creator_user_id, practice_area_id, user_id, client_association_id) VALUES (?, ?, ?, ?)";
      } elseif ($user && $user['association_status'] != 1) {
        $rmv_sql  = "UPDATE associations set association_status = 1, creator_user_id = ?, practice_area_id = ? WHERE user_id = ? AND client_association_id = ?  LIMIT 1";
      }

      $rmv_dta    = [$user_id, $practice_area_id, $usr_id, $client_assct_id];

      if (prep_exec($rmv_sql, $rmv_dta, $sql_request_data[2])) {

        $notif_db = 'associations';
        $db_table = ($user) ? 'association_status' : '';
        if (insert_notifications($user_id, $client_assct_id, $notif_db, $usr_id, 0, 0, $state_msg, $db_table)) {
        }

        $data['url']      = 'refresh';
        $data['success']  = true;
      }
    }
  }
  
  // registry ************************************************************************************************************
  // add registry
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'registry_add') {
    
    $regusr_id          = (isset($_POST['user'])) ? $_POST['user'] : '';
    $comment            = (isset($_POST['comment'])) ? $_POST['comment'] : '';
    $edit_id            = (isset($_POST['registry'])) ? $_POST['registry'] : '';

    $user               = get_user_by_id($regusr_id);

    if (!$data['error'] && !$user) {
      $data['error']    = true;
      $data['message']  = 'User was not found';
    }

    if (!$data['error'] && empty($comment)) {
      $data['error']    = true;
      $data['message']  = 'Please provide a comment';
    }

    if (!$data['error']) {
      if ($edit = get_registry_by_id($edit_id) ) {
        $sql = "UPDATE registry SET registry_user_id = ?, registry_comment = ? WHERE registry_id = ? LIMIT 1";
        $dta = [$regusr_id, $comment, $edit_id]; 
      } else {
        $sql = "INSERT INTO registry (user_id, registry_user_id, registry_comment) VALUES (?, ?, ?)";
        $dta = [$user_id, $regusr_id, $comment];
      }

      if (prep_exec($sql, $dta, $sql_request_data[2])) {

        $registry_id  = ($edit) ? $edit_id : $connect->lastInsertId();

        $notif_db     = 'registry';
        $db_table     = ($user) ? 'registry_aprove' : '';

        // send email
        if(!$edit) {
          $full_name    = $user['name'] . ' ' . $user['last_name'];
          $email        = $user['email'];
          $token        = db_hash($registry_id);
          $url          = '/action?token=' . $token . '&usrkey=' . db_hash($user['user_id']) . '&uid=' . $registry_id . '&type=approve';
  
          $url_reset    = '/action?&distroy=true&mail=' . $user['email'];
  
          $to = array(
            array(
              "name"   => $full_name,
              "email"  => $user['email']
            ),
          );
  
          $artcl_date     = DateTime::createFromFormat('Y-m-d H:i:s', $date);
  
          $mail_data      = array(
            "name"        => $full_name,
            "email"       => $email,
            "url_info"    => array(
              "url_title" => 'CONFIRM',
              "url_link"  => host_url($url),
              "url_reset" => host_url($url_reset),
            ),
            "msg_data"  => $comment,
            "message"   => "Click the link below to approve the receipt or to acknowledge the message/comment/contents of this email",
            "author"      => '',
            "date"        => $artcl_date ->format('F jS, Y'),
            "image"       => '',
          );
  
          $subject        = "Registry Notification";
          $html           = email_registry($full_name, $mail_data);
  
          if (isset($mailer)) {
            $mailer->mail->clearAllRecipients();
          }
  
          if ($mailer->mail($to, $subject, $html, MAIL_FROM)) {
            $mailer->mail->clearAllRecipients();
          }
        }

        $data['url']      = 'refresh';
        $data['success']  = true;
      }
      
    }
    
  }

  // approve registry
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'registry_approve') {
    $user     = (isset($_POST['user'])) ? $_POST['user'] : '';
    $reg_id   = (isset($_POST['registry'])) ? $_POST['registry'] : '';

    $registry = get_registry_by_id($reg_id);

    if ($registry && $registry['registry_approve'] == 0) {
      $sql = "UPDATE registry SET registry_approve = 1 WHERE registry_id = ? LIMIT 1";
      $dta = [$registry['registry_id']];

      if (prep_exec($sql, $dta, $sql_request_data[2])) {
        $data['url']      = 'refresh';
        $data['success']  = true;
      
      }
      
    }
  
  }

  // practice area ************************************************************************************************************
  // add practice area
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'practice_add') {
    
    $practice_id        = (isset($_POST['practice_id'])) ? $_POST['practice_id'] : '';
    $practice           = (isset($_POST['practice'])) ? $_POST['practice'] : '';

    $practice_slug      = $slugify->slugify($practice);

    $practice_area      = get_practice_area_by_id($practice_id);

    if (!$data['error'] && !empty($practice_id) && !$practice_area) {
      $data['error']    = true;
      $data['message']  = 'Practice area was not found';
    }

    if (!$data['error'] && empty($practice) && $practice['practice_area'] == $practice) {
      $data['error']    = true;
      $data['message']  = 'Practice area already exists';
    }

    if (!$data['error']) {
      if ($practice_area ) {
        $sql = "UPDATE practice_areas SET company_id = ?, practice_area = ?, practice_area_slug = ? WHERE practice_area_id = ? LIMIT 1";
        $dta = [$company_id, $practice, $practice_slug, $practice_id]; 
      } else {
        $sql = "INSERT INTO practice_areas (user_id, company_id, practice_area, practice_area_slug) VALUES (?, ?, ?, ?)";
        $dta = [$user_id, $company_id, $practice, $practice_slug];
      }

      if (prep_exec($sql, $dta, $sql_request_data[2])) {

        $registry_id      = ($practice_area) ? $practice_id : $connect->lastInsertId();

        $data['url']      = 'refresh';
        $data['success']  = true;
      }
      
    }
    
  }

  // remove practice area
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'practice_remove') {
    $practice_id        = (isset($_POST['practice_id'])) ? $_POST['practice_id'] : '';
    $practice_area      = get_practice_area_by_id($practice_id);

    if ($practice_area && $practice_area['practice_area_status'] == 0) {
      $sql  = "UPDATE practice_areas SET practice_area_status = 1 WHERE practice_area_id = ? LIMIT 1";
      $dta  = [$practice_area['practice_area_id']];

      if (prep_exec($sql, $dta, $sql_request_data[2])) {
        $data['url']      = 'refresh';
        $data['success']  = true;
      }

    }
  
  }

  // practice task ************************************************************************************************************
  // add practice task
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'practice_area') {
    
    $practice_task_id   = (isset($_POST['practice_id'])) ? $_POST['practice_id'] : '';
    $practice_area_id   = (isset($_POST['practice_area'])) ? $_POST['practice_area'] : '';
    $task_name          = (isset($_POST['task_name'])) ? $_POST['task_name'] : '';
    $task_text          = (isset($_POST['task_text'])) ? $_POST['task_text'] : '';
    $task_position      = (isset($_POST['task_position'])) ? (int) $_POST['task_position'] : '';
    
    $send_sms           = (isset($_POST['send_sms']) && !empty($_POST['send_sms'])) ? 1 : 0;
    $send_email         = (isset($_POST['email_text']) && !empty($_POST['email_text'])) ? 1 : 0;

    $sms_text           = (isset($_POST['sms_text'])) ? $_POST['sms_text'] : '';
    $email_text         = (isset($_POST['article_content'])) ? $_POST['article_content'] : '';
    $notice_text        = (isset($_POST['practice_notice_text'])) ? $_POST['practice_notice_text'] : '';

    $task_name_slug     = $slugify->slugify($task_name);

    $practice_task      = get_practice_task_by_id($practice_task_id);
    $chck_practice_task = get_practice_task_by_name($task_name);
    $practice_area_dta  = get_practice_area_by_id($practice_area_id);

    if (!$data['error'] && !empty($practice_task_id) && !$practice_task) {
      $data['error']    = true;
      $data['message']  = 'Practice task was not found';
    }

    if (!$data['error'] && empty($practice_area_dta)) {
      $data['error']    = true;
      $data['message']  = 'Select practice area from the selection list';
    }
    
    if (!$data['error'] && empty($practice_task_id) && !empty($chck_practice_task)) {
      $data['error']    = true;
      $data['message']  = 'Practice task already exists';
    }

    if (!$data['error'] && empty($task_name)) {
      $data['error']    = true;
      $data['message']  = 'Practice task name cannot be blank';
    }

    if (!$data['error'] && $send_sms && empty($sms_text)) {
      $data['error']    = true;
      $data['message']  = 'You have opted to send an SMS, Please provide SMS text';
    }

    if (!$data['error'] && $send_email && empty($email_text)) {
      $data['error']    = true;
      $data['message']  = 'You have opted to send an email, Please provide email text';
    }

    if (!empty($practice_task) && empty($task_position)) {
      $tasks_count      = count_practice_tasks_by_company($company_id);
      $task_position    = $tasks_count + 1;
    }

    if (!$data['error']) {
      if ($practice_task ) {
        $sql = "UPDATE practice_tasks SET practice_area_id = ?, practice_task_name = ?, practice_task_position = ?,practice_task_slug = ?, practice_task_text = ?, practice_task_sms = ?, practice_task_sms_text = ?, practice_task_email = ?, practice_task_email_text = ? WHERE practice_task_id = ? LIMIT 1";
        $dta = [$practice_area_id, $task_name, $task_position, $task_name_slug, $task_text, $send_sms, $sms_text, $send_email, $email_text, $practice_task_id]; 
      } else {
        $sql = "INSERT INTO practice_tasks (practice_area_id, practice_task_name, practice_task_position, practice_task_slug, practice_task_text, practice_task_sms, practice_task_sms_text, practice_task_email, practice_task_email_text, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $dta = [$practice_area_id, $task_name, $task_position, $task_name_slug, $task_text, $send_sms, $sms_text, $send_email, $email_text, $user_id]; 
      }

      if (prep_exec($sql, $dta, $sql_request_data[2])) {

        $task_positions = get_practice_task_position($task_position);

        $count = 0;
        if (is_object($task_positions) || is_array($task_positions)) {
          foreach ($task_positions as $position) {
            $count ++;
            $new_pos = $task_position + $count;
            increment_practice_task_position($position['practice_task_id'], $new_pos);
          }
        }

        // echo increment_practice_task_position($task_position);

        $registry_id        = ($practice_task) ? $practice_task_id : $connect->lastInsertId();

        if ($practice_task) {
          $data['message']  = "Practice task updated succesfully";
        } else {
          $data['url']      = 'refresh';
        }
        $data['success']    = true;
      }
      
    }
    
  }

  // remove practice area
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'practice_task_remove') {
    $practice_id        = (isset($_POST['practice_id'])) ? $_POST['practice_id'] : '';
    $practice_area      = get_practice_task_by_id($practice_id);

    if ($practice_area && $practice_area['practice_task_status'] == 0) {
      $sql  = "UPDATE practice_tasks SET practice_task_status = 1 WHERE practice_task_id = ? LIMIT 1";
      $dta  = [$practice_area['practice_task_id']];

      if (prep_exec($sql, $dta, $sql_request_data[2])) {
        $data['url']      = 'refresh';
        $data['success']  = true;
      }
    }
  
  }

  // client association: initiate processing
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'client_association_data') {
    $practice_area_id        = (isset($_POST['practice_area'])) ? $_POST['practice_area'] : '';
    
    if (get_practice_area_by_id($practice_area_id)) {
      $data['success'] = true;
      $data['message'] = "Data is being processed";
      $_SESSION['practice_area_id'] = $practice_area_id;
    }
  }

  // process excel data files
  if (!empty($_FILES['data_file']) && ($_FILES['data_file']['error'] === UPLOAD_ERR_OK) && isset($_SESSION['practice_area_id'])) {

    $practice_area_id = $_SESSION['practice_area_id'];
    $practice_area    = get_practice_area_by_id($practice_area_id);

    if (is_uploaded_file($_FILES['data_file']['tmp_name']) === false) {
      $data['error']    = true;
      $data['messages'] = "Error on upload: Invalid file definition";
	  } else {
      $dir_url      = FILES_MIGRATIONS;
      $image        = $_FILES['data_file'];
      $img_temp     = $image['tmp_name'];

      $new_name     = strtoupper($practice_area['practice_area_slug']) . '_FILE' . date("YmddHis");
      // Rename the uploaded file
      $img_name     = $image['name'];
      $img_type     = strtolower(substr($img_name, strripos($img_name, '.') + 1));
      $img_name     = $new_name . '.' . $img_type;

      $img_dir      = $dir_url . 'tmp';
      $img_url      = $img_dir . DS . $img_name;

      if (!is_dir($img_dir) && !file_exists($img_dir)) {
        mkdir($img_dir, 0777, true);
      }

      if (move_uploaded_file($image['tmp_name'], $img_url)) {
        $top_std_col    = STD_COLUMNS;
        $top_columnn    = $top_std_col;
        $tasks          = get_practice_tasks_by_practice($practice_area_id);

        $task_ids       = [];

        foreach ($tasks as $task)
        {
          array_push($top_columnn, $task['practice_task_name']);
          array_push($task_ids, $task['practice_task_id']);
        }

        $path           = $img_url;
      
        /** Create a new Xls Reader  **/
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $reader         = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        
        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet    = $reader->load($path);

        $excel_data     = $spreadsheet->getActiveSheet()->toArray();

        $cnt            = 0;

        foreach ($excel_data as $row) {
          $cnt++;

          if ($cnt == 1) {
            $cells          = [];
            foreach ($row as $cell) {
              $cells[]      = $cell;
            }

            $top_col_count  = count($top_columnn);
            if ($top_col_count != count($cells)) {
              $data['error']    = true;
              $data['message']  = "The number of columns in the datasheet is not consistent with the required number of " . $top_col_count . ' columns, please download the correct datasheet format' ;
            }

            $diff_array         = array_diff($top_columnn, $cells);

            if (!$data['error'] && !empty($diff_array)) {
              $data['error']    = true;
              $data['message']  = "The data sheet first row columns names/values are not consistent with the equired names/values, please download the correct datasheet format";
            }

            continue;
          }

          if ($data['error']) break;

          // spreadsheet variable
          $col_0      = (is_null($row[0]) || empty($row[0])) ? null : $row[0];
          $col_1      = (is_null($row[1]) || empty($row[1])) ? null : $row[1];
          $col_2      = (is_null($row[2]) || empty($row[2])) ? null : $row[2];
          $col_3      = (is_null($row[3]) || empty($row[3])) ? null : $row[3];
          $col_4      = (is_null($row[4]) || empty($row[4])) ? null : $row[4];
          $col_5      = (is_null($row[5]) || empty($row[5])) ? null : $row[5];

          // member variables
          $member     = get_client_association_by_name_other($col_1);

          // user variables
          $col_4              = (!empty($col_4) && !is_null($col_4)) ? preg_replace("/\s+/", "", $col_4) : NULL;
          $col_4              = (!empty($col_4)) ? str_replace(' ', '', $col_4) : NULL;

          $name               = (is_null($col_4) || empty($col_4)) ? null : $col_4;
          $phone              = ((is_null($col_4) || empty($col_4)) && !empty($name)) ? $name : $col_4;
          $email              = (is_null($col_5) || empty($col_5)) ? null : $col_5;
          $password           = (!empty($phone)) ? password_hashing($phone) : NULL;

          $user               = ($phone != null) ? get_user_by_username($phone) : null;

          // checks
          $last_member_id     = NULL;
          
          if ( ($member == null || empty($member)) && !empty($col_1) ) {
            // deceased sql variables
            $client_sql       = "INSERT INTO client_associations (user_id, company_id, office_id, practice_area_id, association_reference, association_name, association_identity) VALUES (?,?,?,?,?,?,?)";
            $client_dta       = [$user_id, $company_id, $office_id, $practice_area_id, $col_0, $col_1, $col_2];
            
            if (prep_exec($client_sql, $client_dta, $sql_request_data[2])) {
              $last_member_id = $connect->lastInsertID();
            }

            $count            = 0;
            foreach ($row as $cell) {
              $ids_ind        = $count - count($top_std_col);
              if ($count > 3 && !is_null($cell) && !empty($cell) && isset($task_ids[$ids_ind])) {
                $task_id = $task_ids[$ids_ind];
                $task_date = (!empty($cell)) ? date(DATE_FORMAT, strtotime($cell)) : $cell;
                insert_activity_task ($user_id, $last_member_id, $task_id, $cell);
              }
  
              $count ++;
            }
          }

          // client sql variables
          $users_sql      = "INSERT INTO users (user_type_id, user_type, username, name, email, password, contact_number, company_id, office_id) VALUES (6, 'guest', :username, :name, :email, :password, :contact_number, :company_id ,:office_id)";
          $users_dta      = array(
            ':username'       => $phone,
            ':name'           => $name,
            ':email'          => $col_5,
            ':password'       => $password,
            ':contact_number' => $col_4,
            ':company_id'     => $company_id,
            ':office_id'      => $office_id,
          );

          if ($user) {
            $last_user_id     = $user['user_id'];
          } elseif (!empty($phone) && !empty($password)) {
            if (prep_exec($users_sql, $users_dta, $sql_request_data[2])) {
              $last_user_id   = $connect->lastInsertID();
            }
          } else {
            $last_user_id     = NULL;
          }

          if (!empty($phone) && isset($last_member_id) && !empty($last_member_id)) {
            $assoc_sql        = "INSERT INTO associations (user_id, client_association_id, creator_user_id, practice_area_id) VALUES (?, ?, ?, ?)";
            $assoc_dta        = [$last_user_id, $last_member_id, $user_id, $practice_area_id];
            prep_exec($assoc_sql, $assoc_dta, $sql_request_data[2]);
          }

        }

        if (!$data['error']) {
          $data['reload']     = false;
          $data['success']    = true;
          $data['message']    = "Data migrated successfully";
        }

      }
		}
  }

  // add company
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'company_form') {
    $company_id             = (isset($_POST['company_id'])) ? $_POST['company_id'] : '';
    $company_name           = (isset($_POST['company_name'])) ? $_POST['company_name'] : '';
    $company_short          = (isset($_POST['company_short'])) ? $_POST['company_short'] : '';
    $company_description    = (isset($_POST['company_description'])) ? $_POST['company_description'] : '';
    $company_type           = (isset($_POST['company_type'])) ? $_POST['company_type'] : '';

    $company_slug           = $slugify->slugify($company_name);


    $company                = get_company_by_id($company_id);
    $company_check          = get_company_by_name($company_name);

    if (!$data['error'] && empty($company_type)) {
      $data['error']    = true;
      $data['message']  = 'Select company type';
    }

    if (!$data['error'] && empty($company_name)) {
      $data['error']    = true;
      $data['message']  = 'Company name cannot be blank';
    }

    if (!$data['error'] && !empty($company_id) && !$company) {
      $data['error']    = true;
      $data['message']  = 'Company name was not found';
    }

    if (!$data['error'] && (empty($company_id) && $company_check || (!empty($company_id) && $company_check && $company_check['company_id'] != $company_id) )) {
      $data['error']    = true;
      $data['message']  = 'Company name already exists';
    }

    if (!$data['error']) {
      if (!empty($company_id)) {
        $sql_sql  = "UPDATE companies SET user_id = ?, company_name = ?, company_short = ?, company_slug = ?, company_type = ?, company_description = ? WHERE company_id = ? AND company_status = 1 LIMIT 1";
        $dta_sql  = [$user_id, $company_name, $company_short, $company_slug, $company_type, $company_description, $company_id];
      } else {
        $sql_sql  = "INSERT INTO companies (user_id, company_name, company_slug, company_short, company_type, company_description) VALUES (?,?,?,?,?,?)";
        $dta_sql  = [$user_id, $company_name, $company_short, $company_slug, $company_type, $company_description];
      }

      if (prep_exec($sql_sql, $dta_sql, $sql_request_data[2])) {

        $data['url']      = 'refresh';
        $data['message']  = 'Company information updated';
        $data['success']  = true;
        // $data['append']   = true;
      }
    }

  }

  // add office
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'office_form') {
    $office_id            = (isset($_POST['office_id'])) ? $_POST['office_id'] : '';
    $office_name          = (isset($_POST['office_name'])) ? $_POST['office_name'] : '';
    $office_short         = (isset($_POST['office_short'])) ? $_POST['office_short'] : '';
    $office_address       = (isset($_POST['office_address'])) ? $_POST['office_address'] : '';
    $office_telephone     = (isset($_POST['office_telephone'])) ? $_POST['office_telephone'] : '';

    $office_slug          = $slugify->slugify($office_name);

    $office               = get_office_by_id($office_id);
    $office_check         = get_office_by_name_company($company_id, $office_name);

    // if (!$data['error'] && empty($office_telephone)) {
    //   $data['error']      = true;
    //   $data['message']    = 'Office telephone number is blank';
    // }

    if (!$data['error'] && empty($office_name)) {
      $data['error']      = true;
      $data['message']    = 'Office name cannot be blank';
    }

    if (!$data['error'] && !empty($office_id) && !$office) {
      $data['error']      = true;
      $data['message']    = 'Office name not was not found';
    }

    if (!$data['error'] && !empty($office_id) && $office_check) {
      $data['error']      = true;
      $data['message']    = 'Office name already exists, use a different office name';
    }

    if (!$data['error']) {
      if (!empty($office_id)) {
        $sql_sql  = "UPDATE offices SET user_id = ?, office_name = ?, office_short = ?, office_slug = ?, office_telephone = ?, office_address = ? WHERE office_id = ? AND office_status = 1 LIMIT 1";
        $dta_sql  = [$user_id, $office_name, $office_short, $office_slug, $office_telephone, $office_address, $office_id];
      } else {
        $sql_sql  = "INSERT INTO offices (company_id, user_id, office_name, office_slug, office_short, office_telephone, office_address) VALUES (?,?,?,?,?,?,?)";
        $dta_sql  = [$company_id, $user_id, $office_name, $office_short, $office_slug, $office_telephone, $office_address];
      }

      if (prep_exec($sql_sql, $dta_sql, $sql_request_data[2])) {

        $data['url']      = 'refresh';
        $data['message']  = 'Company office information updated';
        $data['success']  = true;
      }
      
    }

  }

  // user remove
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'remove_user') {
    $usr_id     = (isset($_POST['user']) && !empty($_POST['user'])) ? $_POST['user'] : '';

    $user       = get_user_by_id($usr_id);
    $admin      = (isset($_SESSION['is_admin'])) ? $_SESSION['is_admin'] : NULL;
    $usr_type   = get_user_type_by_id($user['user_type_id']);
    $admin_user = (isset($usr_type['user_type_admin'])) ? $usr_type['user_type_admin'] : NULL;

    if (!empty($user) && ($user['user_id'] != $user_id) && $admin && $admin_user) {
      $upd_sql  = "UPDATE users SET user_status = 0 WHERE user_id = ? LIMIT 1";
      $upd_dtd  = [$usr_id];

      if (prep_exec($upd_sql, $upd_dtd, $sql_request_data[2])) {
        $data['url']      = 'refresh';
        $data['success']  = true;
      }
    } else {
      $data['error']      = true;
      $data['message']    = "User was not removed, you may not have permission to remove the user";
    }
  }

  // remove office
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'office_remove') {
    $office_id            = (isset($_POST['office'])) ? $_POST['office'] : '';
    $office               = get_office_by_id($office_id);

    if ($office && $office['office_status'] == 1) {
      $sql  = "UPDATE offices SET office_status = 0 WHERE office_id = ? LIMIT 1";
      $dta  = [$office['office_id']];

      if (prep_exec($sql, $dta, $sql_request_data[2])) {
        $data['url']      = 'refresh';
        $data['success']  = true;
      }
    }
  }

  // data management ************************************************************************************************************
  // download practice area data
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'data_download') {
    
    $practice_area_id   = (isset($_POST['practice_area'])) ? $_POST['practice_area'] : '';
    
    $practice_area      = get_practice_area_by_id($practice_area_id);
    $practice_task      = get_practice_tasks_by_practice($practice_area_id);

    if (!$data['error'] && empty($practice_area)) {
      $data['error']    = true;
      $data['message']  = 'We could not find the data associated with this practice area';
    }

    if (!$data['error']  && empty($practice_task)) {
      $data['error']    = true;
      $data['message']  = "You currently have to tasks in " . $practice_area['practice_area'];
    }

    if (!$data['error']) {
      // file download 
      $file_name        = ((isset($practice_area['practice_area_slug']) && !empty($practice_area['practice_area_slug']) ? $practice_area['practice_area_slug'] : '')) . '-data.xlsx';
      $file_download    = ABS_MIGRATIONS_DOCS . $file_name;
      $path             = FILES_MIGRATIONS . $file_name;

      $alphabets        = str_split(CAPITAL_LETTERS);

      if(file_exists($path) ){
        unlink($path);

        // $inputFileType  = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);

        // /**  Create a new Reader of the type that has been identified  **/
        // $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        // /**  Load $path to a Spreadsheet Object  **/
        // $spreadsheet    = $reader->load($path);
      } 
      
      // create PHPOffice spreadsheet
      $spreadsheet      = $def_spreadsheet;

      // get active sheet
      $sheet            = $spreadsheet->getActiveSheet();

      $top_std_col      = STD_COLUMNS;
      $top_col_cnt      = count($top_std_col);
      $col              = 0;
      foreach ($top_std_col as $std_col)
      {
        $position       = $alphabets[$col] . '1';
        $sheet->setCellValue($position, $std_col);
        $col ++;
      }
      
      foreach ($practice_task as $task)
      {
        $position       = $alphabets[$col] . '1';
        $sheet->setCellValue($position, $task['practice_task_name']);
        $col ++;
      }

      $sql              = "SELECT a.user_id, a.client_association_id, ca.association_name, ca.association_name_other, ca.association_description, ca.association_reference FROM client_associations ca INNER JOIN  associations a ON ca.client_association_id = a.client_association_id INNER JOIN users u ON u.user_id = a.user_id WHERE ca.client_association_status = 1 AND a.practice_area_id = ?";
      $dta              = [$practice_area_id];
      $wb_data          = prep_exec($sql, $dta, $sql_request_data[1]);

      if (is_array($wb_data) || is_object($wb_data)) {

        $data_count     = 2;
        foreach ($wb_data as $key => $member) {

          $col          = 0;
          foreach ($top_std_col as $std_col)
          {
            $position   = $alphabets[$col] . $data_count;

            if ($col == 0): $col_val = $member['association_reference']; endif;
            $name       = $member['association_name'];
            $last       = $member['association_name_other'];
            $inla       = $member['association_description'];

            if (!empty($name)) {
              preg_match_all('/\b\w/', $name, $matches);
              $mf_ltrs    = implode('', $matches[0]);
              $mf_name    = ((!empty($inla)) ? ucfirst($inla) . ' ' : '') . strtoupper($mf_ltrs);
            } else {
              $mf_name    = $last;
            }

            if ($col == 1): $col_val = ((!empty($mf_name) ) ? $mf_name : (!empty($inla) ? $inla : NULL)); endif;

            $data_info  = get_user_by_id($member['user_id']);
            $u_name     = $data_info['name'];
            $u_last     = $data_info['last_name'];
            
            if (!empty($u_name) && !empty($u_last)) {
              preg_match_all('/\b\w/', $u_name, $matches);
              $f_lttrs  = implode('', $matches[0]);
              $f_name   = ((!empty($u_last)) ? ucfirst($u_last) . ' ' : '') . strtoupper($f_lttrs);
            } elseif (empty($u_last)) {
              $f_name   = $u_name;
            }
            
            if ($col == 2): $col_val = $f_name; endif;
            if ($col == 3): $col_val = $data_info['contact_number']; endif;
            if ($col == 4): $col_val = $data_info['email']; endif;
            $sheet->setCellValue($position, $col_val);
            $col ++;
          }
          
          foreach ($practice_task as $task)
          {
            $activity_task  = get_activity_tasks_by_practice_task($member['client_association_id'], $task['practice_task_id']);
            $activity_date  = (isset($activity_task['activity_task_date'])) ? date( YEAR_FORMAT, strtotime($activity_task['activity_task_date'])) : '';
            $position       = $alphabets[$col] . $data_count;
            $sorted_date    = (!is_null($activity_date) && !preg_match("/^[a-zA-Z]+$/", $activity_date)) ? $activity_date : NULL;
            $convert_date   = (!empty($sorted_date) ) ? date(DATE_FORMAT, strtotime($sorted_date)) : NULL;
            
            $sheet->setCellValue($position, $convert_date);
            $col ++;
          }
          
          $data_count ++;
        }

        $data['url']      = $file_download;
        $data['success']  = true;
        $data['message']  = "Data succesfully processed";

      }

      //write it again to Filesystem with the same name (=replace)
      $writer         = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      $writer->save($path);
      
    }
    
  }

  // download practice area data template
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'data_template') {
    
    $practice_area_id   = (isset($_POST['practice_area'])) ? $_POST['practice_area'] : '';
    
    $practice_area      = get_practice_area_by_id($practice_area_id);
    $practice_task      = get_practice_tasks_by_practice($practice_area_id);

    if (!$data['error'] && empty($practice_area)) {
      $data['error']    = true;
      $data['message']  = 'We could not find the data associated with this practice area';
    }

    if (!$data['error']  && empty($practice_task)) {
      $data['error']    = true;
      $data['message']  = "You currently have to tasks in " . $practice_area['practice_area'];
    }

    if (!$data['error']) {
      // file download 
      $file_name        = ((isset($practice_area['practice_area_slug']) && !empty($practice_area['practice_area_slug']) ? $practice_area['practice_area_slug'] : '')) . '-template.xlsx';
      $file_download    = ABS_MIGRATIONS_DOCS . $file_name;
      $path             = FILES_MIGRATIONS . $file_name;

      $alphabets        = str_split(CAPITAL_LETTERS);

      if(file_exists($path)){
        unlink($path);
      } 
      
      // create PHPOffice spreadsheet
      $spreadsheet      = $def_spreadsheet;

      // get active sheet
      $sheet            = $spreadsheet->getActiveSheet();

      $top_std_col      = STD_COLUMNS;
      $top_col_cnt      = count($top_std_col);
      $col              = 0;
      foreach ($top_std_col as $std_col)
      {
        $position       = $alphabets[$col] . '1';
        $sheet->setCellValue($position, $std_col);
        $col ++;
      }
      
      foreach ($practice_task as $task)
      {
        $position       = $alphabets[$col] . '1';
        $sheet->setCellValue($position, $task['practice_task_name']);
        $col ++;
      }

      $data['url']      = $file_download;
      $data['success']  = true;
      $data['message']  = "Data succesfully processed";

      //write it again to Filesystem with the same name (=replace)
      $writer           = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      $writer->save($path);
    }
  }

  // search clients to add
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'search_client') {

    $value = (isset($_POST['user']) && !empty($_POST['user']))? $_POST['user'] : '';

    $practices      = get_practice_areas_by_company($company_id);

    $practice_count = (is_array($practices) || is_object($practices)) ? count($practices) : 0;

    if ($practice_count == 1) {
      foreach ($practices as $key => $practice) {
        $practice_id  = $practice['practice_area_id'];
      }
    } elseif($practice_count == 0) {
      $practice_id    = 1;
    }

    $req_sql    = "SELECT user_id, name, last_name, username FROM users WHERE name LIKE '%$value%' OR last_name LIKE '%$value%' OR username LIKE '%$value%' AND company_id = ".$company_id." AND user_status = 1 ORDER BY username DESC LIMIT 35";
    $req_dta    = [];

    if ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) {
      
      if (is_array($req_res) || is_object($req_res)) :
        ob_start();
        foreach ($req_res as $key => $result) : 
          $client_assc_id   = (isset($result['client_association_id'])) ? $result['client_association_id'] : '';
          $usr_name = ((!empty($result['name'])) ? $result['name'] . ' | ' : '');
          $usr_name = $usr_name . ' ' . $result['username']; 
          ?>
          <div class="row px-3">
            <div class="col-12 px-2 pb-0 border-bottom mb-0 pt-1">
              <a type="button" class="me-3 pt-2" onclick="requestModal(post_modal[10], post_modal[10], {'user_id':<?= $result['user_id'] ?>, 'user_type':'guest'})"> <span> <?= $usr_name ?> </span> </a> 
              <button type="button" class="btn btn-light px-3 text-warning float-end" onclick="add_member(<?= $result['user_id'] ?>, '<?= $usr_name ?>')" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?> <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> 
                <i class="fas fa-plus me-1"></i> <span>Add</span> 
              </button>
            </div>
          </div>
          <?php 

        endforeach;

        $data['data']     = ob_get_clean();
        $data['success']  = true;
      endif;

    }
  }

  // tasks ************************************************************************************************************
  // add task
  if (isset($_POST['form_type']) && $_POST['form_type'] == 'task_form') {
    
    $task_id            = (isset($_POST['task_id'])) ? $_POST['task_id'] : '';
    $task_user          = (isset($_POST['user'])) ? $_POST['user'] : '';
    $task_checker       = (isset($_POST['checker'])) ? $_POST['checker'] : '';
    $admins             = (isset($_POST['admins'])) ? $_POST['admins'] : '';
    $category_id        = (isset($_POST['category'])) ? $_POST['category'] : '';
    $task_name          = (isset($_POST['task'])) ? $_POST['task'] : '';
    $priority           = (isset($_POST['priority'])) ? $_POST['priority'] : '';
    $task_content       = (isset($_POST['article_content'])) ? $_POST['article_content'] : '';

    $sms_text           = (isset($_POST['sms_text'])) ? $_POST['sms_text'] : '';
    $notice_text        = (isset($_POST['practice_notice_text'])) ? $_POST['practice_notice_text'] : '';

    $task_admins        = json_encode($admins, true);


    // dfate 
    $dob                = (isset($_POST['dob'])) ? $_POST['dob'] : '';
    $mob                = (isset($_POST['mob'])) ? $_POST['mob'] : '';
    $yob                = (isset($_POST['yob'])) ? $_POST['yob'] : '';
    $tod                = (isset($_POST['tod'])) ? $_POST['tod'] : '';

    $tod                = str_replace(["PM","AM"], '', $tod);
    $tod_date           = date('H:i:s', strtotime($tod));
    $event_date         = $yob . '-' . $mob . '-' . $dob . ' ' . $tod_date;
    $due_date           = date("Y-m-d H:i:s", strtotime($event_date));

    $task_name_slug     = $slugify->slugify($task_name);

    $task               = get_task_by_id($task_id);
    $chck_practice_task = get_task_by_name($task_name);
    $task_category      = get_category_by_id($category_id);
    $user               = get_user_by_id($task_user);


    if (!$data['error'] && ($date >= $due_date)) {
      $data['error']    = true;
      $data['message']  = 'You have selected a past date';
    }

    if (!$data['error'] && !empty($task_id) && !$task) {
      $data['error']    = true;
      $data['message']  = 'Task was not found';
    }

    if (!$data['error'] && empty($task_category)) {
      $data['error']    = true;
      $data['message']  = 'Select task category from the selection list';
    }

    if (!$data['error'] && empty($priority)) {
      $data['error']    = true;
      $data['message']  = 'Select priority level from the selection list';
    }

    if (!$data['error'] && empty($task_content)) {
      $data['error']    = true;
      $data['message']  = 'Task description cannot be blank';
    }

    if (!$data['error'] && empty($task_user)) {
      $data['error']    = true;
      $data['message']  = 'A user was not assigned to the task';
    }

    if (!$data['error'] && empty($task_name)) {
      $data['error']    = true;
      $data['message']  = 'Task name cannot be blank';
    }

    if (!$data['error'] && empty($user)) {
      $data['errot']    = true;      
      $data['message']  = 'The user caanot be found, please select the task user';
    }

    if (!$data['error']) {
      if ($task ) {
        $sql = "UPDATE tasks SET category_id = ?, task_name = ?, assigned_to = ?, task_admins = ?, task_checker = ?, task_slug = ?, task_text = ?, task_priority = ?, task_deadline = ? WHERE task_id = ? LIMIT 1";
        $dta = [$category_id, $task_name, $task_user, $task_admins, $task_checker, $task_name_slug, $task_content, $priority, $due_date, $task_id]; 
      } else {
        $sql = "INSERT INTO tasks (company_id, category_id, task_name, assigned_to, task_admins, task_checker, task_slug, task_text, task_priority, task_deadline, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $dta = [$company_id, $category_id, $task_name, $task_user, $task_admins, $task_checker, $task_name_slug, $task_content, $priority, $due_date, $user_id]; 
      }

      if (prep_exec($sql, $dta, $sql_request_data[2])) {

        $task_id            = ($task) ? $task_id : $connect->lastInsertId();

        if ($task) {
          $data['message']  = "Task updated succesfully";
          // $data['url']      = 'tasks';
        } else {
          $data['message']  = "Task created succesfully";
          $data['url']      = 'tasks';
        }
        
        $data['delayed']    = true;
        $data['seconds']    = 7000;
        $data['success']    = true;

        // send email
        if(!$task) {
          
          $full_name        = $user['name'] . ' ' . $user['last_name'];
          $email            = $user['email'];
          $token            = db_hash($task_id);
          $url              = '/task?token=' . $token . '&usrkey=' . db_hash($user['user_id']) . '&uid=' . $task_id . '&type=task';
  
          $url_reset        = '/action?&distroy=true&mail=' . $user['email'];
  
          $to = array(
            array(
              "name"        => $full_name,
              "email"       => $user['email']
            ),
          );
  
          $artcl_date       = DateTime::createFromFormat('Y-m-d H:i:s', $date);
  
          $mail_data        = array(
            "name"          => $full_name,
            "email"         => $email,
            "msg_welcome"   => "Hello " . $full_name,
            "msg_intro"     => "A freshly assigned task awaits completion, with a deadline set for " . date("jS F Y", strtotime($due_date)) . " at precisely " . date("g:i A", strtotime($due_date)),
            "msg_top_body"  => "Below, you'll find key details about this task:",
            "url_info"      => array(
              "url_title"   => 'View new task',
              "url_message" => 'View task',
              "url_link"    => host_url($url),
              "url_reset"   => host_url($url_reset),
            ),
            "msg_data"        => $task_content,
            "msg_paragraph_1" => $task_content,
            "msg_paragraph_2" => '',
            "date"            => $artcl_date ->format('F jS, Y'),
            "image"           => '',
          );
  
          $subject          = "New Task Have Been Assigned";
          $html             = account_notification_mail($mail_data);
  
          if (isset($mailer)) {
            $mailer->mail->clearAllRecipients();
          }
  
          if ($mailer->mail($to, $subject, $html, MAIL_FROM)) {
            $mailer->mail->clearAllRecipients();
          }

          $admins[]           = $task_checker;

          // send email to task admins
          foreach ($admins as $key => $admin) {
            $user = get_user_by_id($admin);


            $admin_name       = $user['name'] . ' ' . $user['last_name'];
            $email            = $user['email'];
            $token            = db_hash($task_id);
            $url              = '/task?token=' . $token . '&usrkey=' . db_hash($user['user_id']) . '&uid=' . $task_id . '&type=task';
    
            $url_reset        = '/action?&distroy=true&mail=' . $user['email'];
    
            $to = array(
              array(
                "name"        => $admin_name,
                "email"       => $user['email']
              ),
            );
    
            $artcl_date       = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    
            $mail_data        = array(
              "name"          => $admin_name,
              "email"         => $email,
              "msg_welcome"   => "Hello " . $admin_name,
              "msg_intro"     => "A new task has been assigned to <b>" . $full_name . "</b>, with a deadline set for " . date("jS F Y", strtotime($due_date)) . " at precisely " . date("g:i A", strtotime($due_date)),
              "msg_top_body"  => "Below, you'll find key details about this task:",
              "url_info"      => array(
                "url_title"   => 'View new task',
                "url_message" => 'View task',
                "url_link"    => host_url($url),
                "url_reset"   => host_url($url_reset),
              ),
              "msg_data"        => $task_content,
              "msg_paragraph_1" => $task_content,
              "msg_paragraph_2" => '',
              "date"            => $artcl_date ->format('F jS, Y'),
              "image"           => '',
            );
    
            $subject        = "New Task Have Been Created";
            $html           = account_notification_mail($mail_data);
    
            if (isset($mailer)) {
              $mailer->mail->clearAllRecipients();
            }
    
            if ($mailer->mail($to, $subject, $html, MAIL_FROM)) {
              $mailer->mail->clearAllRecipients();
            }

          }

          // insert task into task history
          if (insert_task_history($user_id, $task_id, 'creation')) {}


        }

      }
      
    }
    
  }
  
  // print_r($_POST);

  echo json_encode($data, true);

}
