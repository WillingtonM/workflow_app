<?php

function db_hash($secret){
  return hash('sha256', $secret);
}

function create_sql_table($script_path, $link){
  $sqlErrorCode = 0;
  $sqlErrorText = '';

  $f = fopen($script_path,"r+");
  $sqlFile = fread($f, filesize($script_path));

  // Remove C style and inline comments
  $comment_patterns   = array('/\/\*.*(\n)*.*(\*\/)?/', //C comments
                            '/\s*--.*\n/', //inline comments start with --
                            '/\s*#.*\n/', //inline comments start with #
                            );
  $sqlFile = preg_replace($comment_patterns, "\n", $sqlFile);

  //Retrieve sql statements
  $sqlArray = explode(";\n", $sqlFile);
  $sqlArray = preg_replace("/\s/", ' ', $sqlArray);

  foreach ($sqlArray as $stmt) {
    if (strlen($stmt)>3 && substr(ltrim($stmt),0,2)!='/*') {
      $result         = $link->query($stmt);

      if (!$result) {
        $errorInfo    = $result->errorInfo;
        $sqlErrorCode = $errorInfo[1];
        $sqlErrorText = $errorInfo[2];
        break;
      }else{
        $sqlErrorCode = 0;
      }
    }
  }
  
  if ($sqlErrorCode == 0) {
    $err = "Script is executed succesfully!";
  } else {
    $err =  "An error occured during installation!<br/>";
    echo "Error code: $sqlErrorCode<br/>";
    echo "Error text: $sqlErrorText<br/>";
  }
  
  // echo $err;
}
