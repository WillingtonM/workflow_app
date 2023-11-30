<?php

use Abraham\TwitterOAuth\TwitterOAuth;

$is_admin       = is_admin_check();
$subscription   = company_subscription();
$type           = (isset($_GET['article_id'])) ? 'edit' : 'add';
$article_id     = (int) (isset($_GET['article_id'])) ? $_GET['article_id'] : NULL;
$req_res        = NULL;
$count          = 0;

$twt_data       = ['error' => false, 'success' => false, 'data' => ''];

if (isset($_GET['article_id'])) {

  $req_sql      = "SELECT * FROM articles WHERE article_id = ? AND article_status = 1 LIMIT 1";
  $req_dta      = [$article_id];
  $req_res      = prep_exec($req_sql, $req_dta, $sql_request_data[0]);
}

// if (!isset($_SESSION['request_vars']) || empty($_SESSION['request_vars'])) {

//   $twi_connect    = new TwitterOAuth($_ENV['TWEET_API_KEY'], $_ENV['TWEET_API_KEY_SECRET']);

//   $request_token  = $twi_connect->oauth("oauth/request_token", ["oauth_callback" => $_ENV['TWEET_CALLBACK_URL']]);

//   // recieved token info from twitter
//   if ($twi_connect->getLastHttpCode() == 200) {

//     // get twitter oauth url
//     // $oauthUrl   = $twi_connect->getAuthorizeURL($request_token['oauth_token']);
//     $oauth_token        = $request_token['oauth_token'];
//     $oauth_token_secret = $request_token['oauth_token_secret'];

//     $oauthUrl           = $twi_connect->url("oauth/authorize", ["oauth_token" => $oauth_token]);

//     $twt_data['success'] = true;
//     $twt_data['data'] = filter_var($oauthUrl, FILTER_SANITIZE_URL);
//   } else {
//     $twt_data['data'] = 'Error connecting to twitter!, Try again later !';
//   }
// }
