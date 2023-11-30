<?php

$errors= array();
//* presence

function field_as_text($fieldname) {
	$fieldname =str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
}

function has_presence($value){
	return isset($value) && $value!== "";
}

function validate_presences($required_fields){
	$errors = array();
	foreach ($required_fields as $field) {
		$value = trim($_POST[$field]);
		if(!has_presence($value)) {
			$errors[$field] = field_as_text($field) . " can not be blank";
		}
	}
	return $errors;
}
//*string length
//*max len

function has_max_length($value,$max) {
	return strlen($value)<=$max;
}

function validate_max_length($fields_with_max_lengths) {
	$errors = array();
	//$fields_with_max_length =array("username"=>30,"password"=>8);
	foreach ($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
		if (!has_max_length($value,$max)) {
			$errors[$field] = field_as_text($field). " need to be  less than" . $max . " characters";
		}
	}
	return $errors;
}

function has_min_length($value,$min) {
	return strlen($value)>=$min;
}

function validate_min_length($fields_with_min_lengths) {
	$errors = array();
	//$fields_with_max_length =array("username"=>30,"password"=>8);
	foreach ($fields_with_min_lengths as $field => $min) {
		$value = trim($_POST[$field]);
		if (!has_min_length($value,$min)) {
			$errors[$field] = field_as_text($field). " need to be " . $min . " characters or longer";
		}
	}
	return $errors;
}

function  is_valid_username($username){
  // accepted username length between 5 and 20
  if (preg_match(USERNAME_REGEX, $username)){
    return true;
  } else{
    return false;
  }
}

function validate_username($username) {
	$data 		= array('success' => false, 'message' => '');

	$strt_with 	= preg_match('@[^[0-9]]@', $username);
	$valid_chr 	= preg_match('@^[a-zA-Z0-9_]+$@', $username);

	if ($strt_with) {
		$data['message'] = 'Your username should not start with a number';
	} elseif (!$valid_chr) {
		$data['message'] = 'Your username should only contain alphabets, numbers or underscore';
	} elseif (strlen($username) < 3 || strlen($username) > 20) {
		$data['message'] = 'Your username should be more than 2 and less than 20 characters';
	} else {
		$data['message'] = '';
	}

	if (empty($data['message'])) {
		return true;
	} else {
		// tell the user something went wrong
		return $data['message'];
	}
}

function validate_text_lenght($text, $minlen = 3, $maxlen = 25)
{
	$data 		= array('success' => false, 'message' => '');
	$valid_chr 	= preg_match('@^[0-9A-Za-z\s]*$@', $text);
	$str_len 	= (int) strlen($text);

	if ($str_len < $minlen || $str_len > $maxlen) {
		$data['message'] = 'Text should be more than ' . $minlen . ' and less than ' . $maxlen . ' characters';
	} else {
		$data['message'] = '';
	}

	if (empty($data['message'])) {
		return true;
	} else {
		// tell the user something went wrong
		return $data['message'];
	}
}

function validate_text($text, $minlen = 3, $maxlen = 25)
{
	$data 		= array('success' => false, 'message' => '');
	$valid_chr 	= preg_match('@^[0-9A-Za-z\s]*$@', $text);

	if (!$valid_chr) {
		$data['message'] = 'Invalid text: Only text and numbers are alowed';
	} else {
		$data['message'] = validate_text_lenght($text, $minlen, $maxlen);
	}

	if (empty($data['message'])) {
		return true;
	} else {
		// tell the user something went wrong
		return $data['message'];
	}
}

function is_valid_password($pwd){
	// accepted password length between 5 and 20, start with character.
	$data 		= array('success' => false, 'message' => '');

	$uppercase = preg_match('@[A-Z]@', $pwd);
	$lowercase = preg_match('@[a-z]@', $pwd);
	$number    = preg_match('@[0-9]@', $pwd);
	$special   = preg_match('@[^\w]@', $pwd);

	if (!$uppercase) {
		$data['message'] = 'Your password should atleast contain a uppercase alphabet letter';
	} elseif (!$lowercase) {
		$data['message'] = 'Your password should atleast contain a lowercase alphabet letter';
	} elseif (!$number) {
		$data['message'] = 'Your password should atleast contain a number';
	} elseif (!$special) {
		$data['message'] = 'Your password should atleast contain 1 special character';
	} elseif (strlen($pwd) < 8) {
		$data['message'] = 'Your password length should be 8 or more characters';
	} else {
		$data['message'] = '';
	}

	if (empty($data['message'])) {
		return true;
	} else {
		// tell the user something went wrong
		return $data['message'];
	}

}

function validate_phone_number($phone)
{
	// Allow +, - and . in phone number
	$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
	// Remove "-" from number
	$phone_to_check = str_replace([' ', '.', '-', '(', ')'], '', $filtered_phone_number);
	// Check the lenght of number
	// This can be customized if you want phone number from a specific country
	if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
		return false;
	} else {
		return $phone_to_check;
	}
}

function is_valid_date($date){
  //============ date format dd-mm-yyyy
  if(preg_match("/^(\d{2})-(\d{2})-(\d{4})$/", $date, $sdate)){
    if(checkdate($sdate[2], $sdate[1], $sdate[3])) {
      return true;
    }
  }else {
    return false;
  }
}


//* inclusion in a set
function has_inclusion_in($value,$set){
	return in_array($value,$set);
}

function validate($address){
	$decoded = decodeBase58($address);

	$d1 = hash("sha256", substr($decoded,0,21), true);
	$d2 = hash("sha256", $d1, true);

	if(substr_compare($decoded, $d2, 21, 4)){
		// throw new \Exception("bad digest");
		$ret = FALSE;
	}else{
		$ret = TRUE;
	}

	return $ret;
}

function decodeBase58($input) {
	$alphabet = ALP_NUMERICAL;

	$out = array_fill(0, 25, 0);
	for($i=0;$i<strlen($input);$i++){
		if(($p=strpos($alphabet, $input[$i]))===false){
			throw new \Exception("invalid character found");
		}
		$c = $p;
		for ($j = 25; $j--; ) {
			$c += (int)(58 * $out[$j]);
			$out[$j] = (int)($c % 256);
			$c /= 256;
			$c = (int)$c;
		}
		if($c != 0){
			throw new \Exception("address too long");
		}
	}

	$result = "";
	foreach($out as $val){
		$result .= chr($val);
	}

	return $result;
}
