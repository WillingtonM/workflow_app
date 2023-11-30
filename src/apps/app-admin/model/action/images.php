<?php

if (isset($_POST)) :

    $date     = date('Y-m-d H:i:s');
    $data     = array('error' => '', 'data' => '', 'success' => false, 'message' => '', 'url' => '');
    $errors   = array('error' => '');
    $user_id  = (isset($_SESSION['user_id']) && $_SESSION['user_id'] != null) ? $_SESSION['user_id'] : 0;

    $emailkey = constant("EMAIL_KEY");

    // users image
    if (isset($_FILES["post_image"]["tmp_name"]) && $_FILES['post_image']['error'] == UPLOAD_ERR_OK && !isset($_SESSION['last_user_id'])) {

        $user_dir = USER_PROFILE_URL . 'tmp' . DS;
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
                $data['image']    = ABS_USER_PROFILE . 'tmp' . DS . $new_name;
            } else {
                $data['error']    = true;
                $data['message']  = 'Image was not uploaded successfully';
            }
        } else {
            $data['error']    = $image_res['success'];
        }

        $data['message']  = (empty($data['message'])) ? $image_res['message'] : $data['message'];
    }


    if (!empty($_FILES['post_image']) && ($_FILES['post_image']['error'] == UPLOAD_ERR_OK && isset($_SESSION['last_user_id']))) {
        clearstatcache();
        $afd_user_id    = $_SESSION['last_user_id'];

        if ($user   = get_user_by_id($afd_user_id) ) {

            $user_dir = USER_PROFILE_URL;
            $new_name = 'IMGIM' . date("YmddHis");
            $img_name = $_FILES["post_image"]["name"];
            $img_temp = $_FILES["post_image"]["tmp_name"];

            // Be sure we're dealing with an upload
            $image_res = image_validation($img_name, $new_name, $img_temp, $user_dir);
            if ($image_res['success']) {

                $img_name   = $new_name . '.' . $image_res['mime_type'];
                $img_sql    = "UPDATE users SET user_image = ? WHERE user_id = ? LIMIT 1";
                $img_dta    = [$img_name, $afd_user_id];

                if (prep_exec($img_sql, $img_dta, $sql_request_data[2])) {
                    $data['url']      = "refresh";
                    $data['success']  = true;
                    $data['message']  = "User image has been succesfully created";

                    unset($_SESSION['last_user_id']);
                } else {
                    $data['error']    = true;
                    $data['message']  = "User image was not successfully updated";
                }
            } else {
                $data['error']          = $image_res['success'];
                $data['message']        = (empty($data['message'])) ? $image_res['message'] : $data['message'];
            }
        } else {
            $data['error']              = true;
            $data['message']            = "User was not found";
        }

        clearstatcache();
    }



    echo json_encode($data, true);


endif;
