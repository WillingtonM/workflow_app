<?php
$connect   = false;

// MySQL Connection variables
if (getenv("CLEARDB_DATABASE_URL")) { // ClearDB Connection Information
  $db_url  = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $db_host = $db_url['host'];
  $db_user = $db_url['user'];
  $db_pass = $db_url['pass'];
  $db_name = substr($db_url['path'],1);
} elseif($_SERVER['HTTP_HOST'] === 'localhost') {       // Localhost Connection Information
  $db_host = 'localhost';
  $db_user = 'root';
  $db_pass = '';
  $db_name = $_ENV["DB_NAME"];
} else {
  $db_host = $_ENV["DB_HOST"];
  $db_user = $_ENV["DB_USER"];
  $db_pass = $_ENV["DB_PASS"];
  $db_name = $_ENV["DB_NAME"];
}

define('DB_SERVER', $db_host);
define('DB_USER',   $db_user);
define('DB_PASS',   $db_pass);
define('DB_NAME',   $db_name);

if (HOST_IS_LIVE)
{
  // CREATE Database Tables and a Database (IF NOT EXISTS)
  $link = new mysqli(DB_SERVER,DB_USER,DB_PASS);
  if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  // Attempt to create database (if not exists)
  $db_sql = "CREATE DATABASE IF NOT EXISTS ".DB_NAME;
  if (mysqli_query($link, $db_sql)) {
    $link         = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    $script_path  = SCRIPTS_PATH . '/MySQL/models_check.sql';
    create_sql_table($script_path, $link);
  }

  try {
    $connect = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME, DB_USER, DB_PASS, array(
      PDO::ATTR_PERSISTENT => true)
    );

    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e){
    echo "Connection failed : " . $e->getMessage() . "<br/>";
    die();
  }

  // Attempt to Create Database Tables (if not exists)
  if ($connect !== false) {
    $conn         = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    $script_path  = SCRIPTS_PATH . '/MySQL/models_check.sql';
    create_sql_table($script_path, $conn);

    // $script_path  = SCRIPTS_PATH . '/MySQL/states.sql';
    // create_sql_table($script_path, $conn);
  }

}

