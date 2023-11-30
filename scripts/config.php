<?php
// .............................................................................
// ........... PHP SETTINGS ............................................

// running OS
$windows = (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) ? true : false;

// Set timezone
date_default_timezone_set('GMT');
$end_timezone = 'Africa/Johannesburg';


// .............................................................................
// ........... AUTOLOAD_PATH And SETTINGS ......................................
require_once AUTOLOAD_PATH;
$dotenv = Dotenv\Dotenv::create(PROJECT_ROOT_PATH);
$dotenv->load();

// Load Slugify
use Cocur\Slugify\Slugify;
$slugify = new Slugify();

// excel
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 


// .............................................................................
// ........... PROJECT INFORMATION And SETTINGS ................................

// Project Constants
define("PROJECT_TITLE",             $_ENV['PROJECT_TITLE']);
define("PROJECT_NAME",              $_ENV['PROJECT_NAME']);
define("COMPANY_SHORT_NAME",        $_ENV['COMPANY_SHORT_NAME']);
define("AUTHOR",                    'Willington Mhlanga');
define("HOST_IS_LIVE",              TRUE);
define("HOST_IS_LOCAL",             TRUE);
define("PROJECT_LOGO_WHITE",        './img/home' . DS . 'logo-white.png');
define("PROJECT_LOGO_SMALL",        './img/home' . DS . 'logo.png');
define('SCRIPT_VERSION',            'v-2.00');

define('CURRENT_TIMEZONE',          (date_default_timezone_get()) ? date_default_timezone_get() : date_default_timezone_set('GMT'));
define('DATE_FORMAT',               'Y-m-d H:i:s');
define('DEFAULT_DATE_FORMAT',       'jS F Y');
define('PRIMARY_DATE_FORMAT',       'j F Y');

require_once CONFIG_PATH . "config_function.php";
require_once CONFIG_PATH . "db_config.php";
require_once CONFIG_PATH . "variables.php";

//set timezone
date_default_timezone_set('Africa/Johannesburg');

$config = [
 'CONTROLLER_PATH'  => APPLICATION_PATH . DS . APPLICATION_SESS . DS . 'controller' . DS,
 'MODEL_PATH'       => APPLICATION_PATH . DS . APPLICATION_SESS . DS . 'model' . DS,
 'VIEW_PATH'        => APPLICATION_PATH . DS . APPLICATION_SESS . DS . 'view' . DS,
 'CORE_PATH'        => SRC_PATH . DS . 'core' . DS,
 'TEMPLATE_PATH'    => SRC_PATH . DS . 'core' . DS . 'templates' . DS,
 'CACHE_PATH'       => SRC_PATH . DS . 'core' . DS . 'cache' . DS,
 'PARSERS_PATH'     => SRC_PATH . DS . 'core' . DS . 'parsers' . DS,
 'CONFIG_PATH'      => SRC_PATH . DS . 'core' . DS . 'config' . DS,
 'LIB_PATH'         => SRC_PATH . DS . 'core' . DS . 'library' . DS,
 'LIB_FUNCTIONS'    => SRC_PATH . DS . 'core' . DS . 'library' . DS . 'functions' . DS,
 'LIB_CLASSES'      => SRC_PATH . DS . 'core' . DS . 'library' . DS . 'classes' . DS,
 'LIB_EMAIL'        => SRC_PATH . DS . 'core' . DS . 'library' . DS . 'email' . DS,
 'PUBLIC_PATH'      => PROJECT_ROOT_PATH . DS . 'web' . DS,
 'IMAGE_PATH'       => PROJECT_ROOT_PATH . DS . 'web' . DS . 'img' . DS,
 'FILES_PATH'       => PROJECT_ROOT_PATH . DS . 'web' . DS . 'docs' . DS,
 'ASSETS_CSS'       => PROJECT_ROOT_PATH . DS . 'web' . DS . 'css' . DS,
 'ASSETS_JS'        => PROJECT_ROOT_PATH . DS . 'web' . DS . 'js' . DS,
 'MEDIA_PATH'       => PROJECT_ROOT_PATH . DS . 'web' . DS . 'mediacontent' . DS,
 'PRODUCT_URL'      => '..' . DS . 'resources' . DS . 'media' . DS .'img' . DS . 'products' . DS,
 // 'AUTOLOAD_PATH'    => APPLICATION_PATH . DS . 'vendor/autoload.php',
];

// Frofile Path Directories
// define('IMG_PATH',          $config['MEDIA_PATH'] . 'img' .DS);
define('IMG_PATH',          $config['IMAGE_PATH']);
define('HOME_URL',          IMG_PATH . 'home' .DS);
define('USER_PROFILE_URL',  IMG_PATH . 'users' .DS);
define('ARTICLES_URL',      IMG_PATH . 'articles' . DS);
define('MEDIA_URL',         IMG_PATH . 'media' .DS);
define('TMP_URL',           IMG_PATH . 'tmp' .DS);
define('DEFAULT_IMG_PATH',  'img' .DS);

// Media
define('MEDIA_PATH',         $config['MEDIA_PATH']);
define('MEDIA_TMP',          $config['MEDIA_PATH']) . 'tmp' . DS;
define('FILES_PATH',         $config['FILES_PATH']);

define('GALLERY_URL',        MEDIA_PATH . 'gallery' .DS);
define('FILES_URL',          MEDIA_PATH . 'files' . DS);
define('FILES_APPLICATIONS', FILES_PATH . 'applications' . DS);
define('FILES_MIGRATIONS',   FILES_PATH . 'migrations' . DS);

// Absolute Image Directories
define('ABS_IMG_PATH',        'img' . DS . 'home' .DS);
define('ABS_USER_PROFILE',    'img' . DS . 'users' .DS);
define('ABS_OTHER',           'img' . DS . 'other' . DS);
define('ABS_MEDIA',           'img' . DS . 'media' . DS);
define('ABS_ARTICLES',        'img' . DS . 'articles' .DS);
define('ABS_DOCS',            'docs' . DS);
define('ABS_TMP',             'img' . DS . 'tmp' .DS);
define('ABS_GALLERY',         'mediacontent' . DS . 'gallery' .DS);
// define('ABS_FILES',           'mediacontent' . DS . 'files' . DS);
define('ABS_FILES',           ABS_DOCS);
define('ABS_APPLICATION_DOCS',ABS_DOCS . 'applications' . DS);
define('ABS_MIGRATIONS_DOCS' ,ABS_DOCS . 'migrations' . DS);

// CSS
define("DIST_CSS",         'css/');
define("DIST_CSS_CUSTOM",  'css/custom/');

// JS
define("DIST_JS",         'js/');
define("DIST_JS_CUSTOM",  'js/custom/');

// project constants
define("CHARACTER_LIMIT", 180);

// .............................................................................

// username regular expression
define('USERNAME_REGEX',    '/^[a-zA-Z0-9][\w\.\*\-\_]{6,18}$/i');
// define('PASSWORD_REGEX',    '/[^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$]/');
define('PASSWORD_REGEX',    '/[^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$]/');


// Default project contants
define('DEFAULT_USER_IMG',    'plain-bg.png');
define('DEFAULT_ARTICLE_IMG', 'plain-bg.png');

define("DEFAULT_USER",      ABS_IMG_PATH . DEFAULT_USER_IMG);
define("DEFAULT_ARTICLE",   ABS_IMG_PATH . DEFAULT_ARTICLE_IMG);
define("MAX_IMG_SIZE",   300);
// General Constants
define('TAXRATE',           0.15);


// ************** SALTS KEYS
define('EMAIL_KEY',         db_hash('7mbUYw8YNphThnu'));
define('PHONE_KEY',         db_hash('vVpZ1T8YK3uXXtc'));
define('USER_INFO_KEY',     db_hash('ZdsBV0OhBfKDrTt'));
define('CONTACT_INFO_KEY',  db_hash('ifDsKegvCYtFVR7'));
define('MERCHANT_KEY',      db_hash('hfuocSZD90o3Jdh'));

// STRINGS
define('ALP_NUMERICAL',     '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('CAPITAL_LETTERS',   'ABCDEFGHIJKLMNOPQRSTUVWXYZ');

// .............................................................................

// ........... PHP SETTINGS ............................................
ini_set('display_errors', HOST_IS_LOCAL);
ini_set('display_startup_errors', HOST_IS_LOCAL);
ini_set('enable_dl', TRUE);
ini_set('php_mbstring.dll', TRUE);
ini_set('php_exif.dll', TRUE);

ini_set('post_max_size', '1000M');
ini_set('upload_max_filesize', '1000M');


// .............................................................................

// ........... API's ...........................................................
// .............................................................................

// SMS Souh Africa
define("SMS_CLIENT_ID",     $_ENV['SMS_CLIENT_ID']);
define("SMS_CLIENT_API",    $_ENV['SMS_CLIENT_API']);



// .............................................................................

// ........... THIRD PARTY ACCOUNTS ............................................


// .............................................................................

// ........... REQUIRE PROJECT FILES ............................................

// Functions
require_once $config['LIB_FUNCTIONS'] . 'functions.php';
require_once $config['LIB_FUNCTIONS'] . 'sql_functions.php';
require_once $config['LIB_CLASSES'] . 'Classes.php';
require_once $config['LIB_EMAIL'] . 'phpmailer.php';

// .............................................................................
define("PAGE_SETTINGS", get_seetings());
