<?php
$app    = 'admin';

defined('SRC_PATH') || define('SRC_PATH', realpath(dirname(__FILE__) . '/../src'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../src'));
defined('APPLICATION_SESS') || define('APPLICATION_SESS', 'app-' . $app);
defined('AUTOLOAD_PATH') || define('AUTOLOAD_PATH', realpath(dirname(__FILE__) . '/../vendor/autoload.php'));
defined('RESOURCE_PATH') || define('RESOURCE_PATH', realpath(dirname(__FILE__) . '/../resources/'));
defined('SCRIPTS_PATH') || define('SCRIPTS_PATH', realpath(dirname(__FILE__) . '/../scripts'));
defined('PROJECT_ROOT_PATH') || define('PROJECT_ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

require_once AUTOLOAD_PATH;

const DS        = DIRECTORY_SEPARATOR;
define('CONFIG_PATH', SRC_PATH . DS . 'core' . DS . 'config' . DS);

require_once __DIR__ . DS . "config.php";

$user_id        = 1;
$today          = date("Y-m-d H:i:s");

$company_id     = (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : 1;

$practice_tasks = get_practice_tasks_by_company($company_id);


// file download 
$path           = SCRIPTS_PATH . DS . 'SpreadSheets' . DS . 'deseased_estate_template.xlsx';

$alphabets      = str_split(CAPITAL_LETTERS);

/**  Identify the type of $path  **/
$inputFileType  = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);

/**  Create a new Reader of the type that has been identified  **/
$reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

/**  Load $path to a Spreadsheet Object  **/
$spreadsheet    = $reader->load($path);

//load spreadsheet
// $spreadsheet    = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
// //change it
$sheet          = $spreadsheet->getActiveSheet();

$col            = 4;
foreach ($practice_tasks as $task)
{
    $position   = $alphabets[$col] . '1';
    $sheet->setCellValue($position, $task['practice_task_name']);
    $col ++;
}


//write it again to Filesystem with the same name (=replace)
$writer         = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save($path);