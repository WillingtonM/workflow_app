<?php

if(isset($_POST['url']) && !empty($_POST)){

  $url  = (isset($_POST['url']))?sanitize($_POST['url']):'default';
  $type = (isset($_POST['get_type']))?sanitize($_POST['get_type']):'action';
  $page = post($url, $type);
}else{
  list($page, $_GET) = getPath();
}
