<?php

class customException extends Exception {
  public function errorMessage() {
    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
    .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
    return $errorMsg;
  }
}

class Existance
{

  function __construct()
  {
    // code...
  }

  public function logedUser(){
    return ((isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))?TRUE:FALSE);
  }

  public function userUnique($user){

    if($this -> logedUser()){
      return (($_SESSION['user_id'] == $user)?TRUE:FALSE);
    }else{

    }
  }
}



?>
