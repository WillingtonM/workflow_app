<?php
session_start();
// session_destroy();
// $_SESSION['active_app'] = 'admin';

$app_active   = array('action' => true, 'public' => true);

if (isset($_GET['url']) && ($_GET['url'] == 'confirm' || $_GET['url'] == 'confirmation' || $_GET['url'] == 'action' || $_GET['url'] == 'notify' || $_GET['url'] == 'return' || $_GET['url'] == 'cancel' || $_GET['url'] == 'resetpass')) {
  $_SESSION['tmp_active_app'] = (isset($_SESSION['active_app']))? $_SESSION['active_app'] : 'public'; 
  $_SESSION['active_app']     = 'action';
} 

if (!isset($_SESSION['active_app'])) {
  $_SESSION['active_app']     = 'public';
}

if (isset($_SESSION['active_app']) && (isset($app_active[$_SESSION['active_app']]) && $app_active[$_SESSION['active_app']] == true)) {
  $app        = $_SESSION['active_app'];
} else {
  $app        = 'public';
}

$app          = $_SESSION['active_app'];
defined('SRC_PATH') || define('SRC_PATH', realpath(dirname(__FILE__) . '/../src'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../src/apps'));
defined('APPLICATION_SESS') || define('APPLICATION_SESS', 'app-'.$app);
defined('AUTOLOAD_PATH') || define('AUTOLOAD_PATH', realpath(dirname(__FILE__) . '/../vendor/autoload.php'));
defined('VENDOR_PATH') || define('VENDOR_PATH', realpath(dirname(__FILE__) . '/../vendor'));
defined('RESOURCE_PATH') || define('RESOURCE_PATH', realpath(dirname(__FILE__) . '/../resources/'));
defined('SCRIPTS_PATH') || define('SCRIPTS_PATH', realpath(dirname(__FILE__) . '/../scripts'));
defined('PROJECT_ROOT_PATH') || define('PROJECT_ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

const DS      = DIRECTORY_SEPARATOR;

require_once SRC_PATH . DS . 'core' . DS . 'config' . DS . 'config.php';

$controller   = $config['CONTROLLER_PATH'] . 'controller.php';

$script_vsn   = (!empty(SCRIPT_VERSION)) ? '?v=' . SCRIPT_VERSION : '';

if(file_exists($controller)){
  require $controller;
}

$pos = strrpos($page, DS);
$lst_page = ($pos === false )? $page : substr($page, $pos + 1);

$model          = $config['MODEL_PATH'] . $page . '.php';
$view           = $config['VIEW_PATH'] . $page . '.php';

$_404           = $config['TEMPLATE_PATH'] . '_404.php';
$_tok           = $config['TEMPLATE_PATH'] . '_tok.php';
$layout_path    = $config['VIEW_PATH']. 'layout' . DS;

// Start SESSION
if(file_exists($model)){
  require $model;
}

$side_content     = '';
if(file_exists($layout_path)){
  $side_content   = $layout_path . 'sidebar.php';
}

$main_content     = $config['VIEW_PATH'] . 'login.php';
if (!file_exists($view) && isset($_POST) && !empty($_POST)) {
  $main_content   = $config['PARSERS_PATH'].'empty.php';
  // $page = 'home';
} elseif (!file_exists($view)) {
  $load_page = (isset($_SESSION['user_id'])) ? 'home' : 'login';
  redirect_to($load_page);
} else {
  $main_content   = $view;
}

$header           = '';
if (file_exists($layout_path)) {
  $header         = $layout_path . 'header.php';
}

$navbar           = '';
if (file_exists($layout_path)) {
  $navbar         = $layout_path . 'navbar.php';
}

$footer           = '';
if (file_exists($layout_path)) {
  $footer         = $layout_path . 'footer.php';
}

$js_scripts       = '';
if (file_exists($layout_path)) {
  $js_scripts     = $layout_path . 'scripts.php';
}

if (isset($_POST) && !empty($_POST)) {
  if (!isset($_POST['token']) || (isset($_SESSION['csrf_token']) && $_POST['token'] != $_SESSION['csrf_token'])) {
    $main_content = $_tok;
  } else {
    require_once $main_content;
  }

} else {
  require_once $config['PARSERS_PATH']. 'base-' . $app . '.php';
}

$_SESSION['active_app']  = (isset($_SESSION['tmp_active_app'])) ? $_SESSION['tmp_active_app'] : $_SESSION['active_app'];
// if (isset($_SESSION['tmp_active_app'])) unset($_SESSION['tmp_active_app']);