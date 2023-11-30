<?php
$app    = 'admin';
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../src'));
defined('APPLICATION_SESS') || define('APPLICATION_SESS', 'app-' . $app);
defined('AUTOLOAD_PATH') || define('AUTOLOAD_PATH', realpath(dirname(__FILE__) . '/../vendor/autoload.php'));
defined('RESOURCE_PATH') || define('RESOURCE_PATH', realpath(dirname(__FILE__) . '/../resources/'));
defined('SCRIPTS_PATH') || define('SCRIPTS_PATH', realpath(dirname(__FILE__) . '/../scripts'));
defined('PROJECT_ROOT_PATH') || define('PROJECT_ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

const DS = DIRECTORY_SEPARATOR;

require_once APPLICATION_PATH . DS . 'core' . DS . 'config' . DS . 'config.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$today        = date("Y-m-d H:i:s");
// $rgst_sql     = "SELECT article_id, article_title, article_type, article_link, article_publisher, article_publish_date, SUBSTRING( article_content, 1, 255 ) AS article_content, CHAR_LENGTH(article_content) AS article_content_count, article_source, article_image, article_author, article_status, article_date_created, user_id FROM articles WHERE article_status = 1 ORDER BY article_publish_date DESC LIMIT $sql_pg_strt, $intval";
$rgst_sql     = "SELECT user_id, article_id, article_title, article_type, article_link, article_publisher, article_publish_date, article_content, article_source, article_image, article_author, article_status, article_cronjob_date, article_date_created, user_id FROM articles WHERE article_status = 1 AND article_cronjob = 1 AND article_cronjob_status = 1 AND article_sent = 0 ORDER BY article_publish_date DESC";
$rgst_dta     = [];

if ($rgst_qrys = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1])) {
    foreach ($rgst_qrys as $rgst_qry) {
        $article_crondate        = strtotime($rgst_qry['article_cronjob_date']);
        $article_crondate        = date('Y-m-d H:i:s', $article_crondate);
        // $article_crondate        = $article_crondate->format('Y-m-d H:i:s');

        if ($article_crondate <= $today) {

            $article_pubdate    = $rgst_qry['article_publish_date'];
            $user_id            = $rgst_qry['user_id'];
            $article_id         = $rgst_qry['article_id'];
            $article_title      = $rgst_qry['article_title'];
            $article_type       = $rgst_qry['article_type'];
            $article_post       = $rgst_qry['article_content'];
            $article_author     = $rgst_qry['article_author'];
            $article_image      = $rgst_qry['article_image'];

            $article_sql = "UPDATE articles SET article_cronjob_status = 0 WHERE article_id = ? LIMIT 1";
            $article_dta = [$article_id];

            if (prep_exec($article_sql, $article_dta, $sql_request_data[2])) {
                $article_slg    = $slugify->slugify($article_title);

                $url            = '/article?article=' . $article_slg . '&slgid=' . $article_id . '&type=' . $article_type;
                // $url_title      = "New Article";
                $message        = short_paragrapth($article_post, 2500);
                $subject        = PROJECT_TITLE . ' | ' . html_entity_decode($article_title, ENT_QUOTES, "UTF-8");
                $subject        = '=?UTF-8?B?' . base64_encode($subject) . '?=';
                $from           = MAIL_FROM;

                $artcl_date     = DateTime::createFromFormat('Y-m-d H:i:s', $article_pubdate);
                // $artcl_date     = DateTime::createFromFormat('Y-m-d', $article_pubdate);
                $mail_data      = array(
                    "name"        => '',
                    "email"       => '',
                    "url_info"    => array(
                        "url_title" => 'Read more ...',
                        "url_link"  => host_url($url),
                        "url_reset" => ''
                    ),
                    "message"     => $message,
                    "title"       => htmlspecialchars($article_title, ENT_QUOTES, "UTF-8"),
                    // "title"       => html_entity_decode($article_title, ENT_QUOTES, "UTF-8"),
                    "author"      => $article_author,
                    "date"        => $artcl_date->format('F jS, Y'),
                    "image"       => host_url('/' . article_img($article_type, $article_image)),
                );

                $subscribers    = get_subscribers();
                update_article_by_id($article_id);

                if ($subscribers != null) {
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
                        }
                    }
                }



                $twitjob        = (isset($rgst_qry['article_twitjob']) && $rgst_qry['article_twitjob'] == 1) ? true : false;
                $api_user       = get_api_by_user_id($user_id);
                if ($twitjob && $api_user) {
                    $oauth_token        = $api_user['oauth_token'];
                    $oauth_token_secret = $api_user['oauth_token_secret'];

                    $twi_connect  = new TwitterOAuth($_ENV['TWEET_API_KEY'], $_ENV['TWEET_API_KEY_SECRET'], $oauth_token, $oauth_token_secret);
                    $content      = $twi_connect->get("account/verify_credentials");

                    $tweet_msg    = $article_title . " " . host_url($url) . ' #' . ucfirst($api_user['first_name']) . ucfirst($api_user['last_name']) . $api_user['username'];
                    $tweet_param  = [
                        'status' => $tweet_msg,
                    ];

                    // create tweet
                    $twi_connect  = new TwitterOAuth($_ENV['TWEET_API_KEY'], $_ENV['TWEET_API_KEY_SECRET'], $oauth_token, $oauth_token_secret);
                    $tweet        = $twi_connect->post("statuses/update", $tweet_param);


                    if ($twi_connect->getLastHttpCode() == 200) {
                    } else {
                        $data['error']    = true;
                        $data['message']  = "Tweet was not created, something went wrong";
                    }
                }
            }
        }
    }
}
