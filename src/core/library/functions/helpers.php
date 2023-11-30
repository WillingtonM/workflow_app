<?php


function startsWith($haystack, string $needle)
{
  $length = strlen($needle);
  return substr($haystack, 0, $length) === $needle;
}

function endsWith($haystack, string $needle)
{
  $length = strlen($needle);
  if (!$length) {
    return true;
  }
  return substr($haystack, -$length) === $needle;
}

function addclass_from_page($page, $var_compare, $css_class) {
  return ($page == $var_compare)?$css_class:'';
}

function img_path($img_path, $img_name, $type=0 /* options : [0=original image, 1=sqaure image]*/) {
  global $image_modify_paths;

  $path_end = (endsWith($img_path, '/') || endsWith($img_path, DS)) ? '' : DS;
  $img_path = $img_path . $path_end;

  if ($type == 1) {
    return img_centered($img_name, $img_path, $image_modify_paths[$type]);
  } elseif ($type == 2) {
    return img_thumbnail($img_name, $img_path, $image_modify_paths[$type]);
  } else {
    $sub_path   = (!empty($image_modify_paths[$type])) ? $image_modify_paths[$type] . DS : '';
    $file       = $img_path . $sub_path;
    if (!is_dir($file)) {
      mkdir($file, 0777, true);
    }
    return  $file . $img_name;
  }

}

function global_img_unlink($dir_url) {
  $imgs           = glob($dir_url.'*.*');
  foreach ($imgs as $img) {
    if (is_file($img)) {
      unlink($img);
    }
  }
}

function move_file ($old_path, $new_path) {

  if(!is_dir($new_path) && !file_exists($new_path)){
		mkdir($new_path, 0777, true);
	}

  $ret = false;
  $imgs           = glob($old_path.'*.*');
  $img_ends       = '';
  foreach ($imgs as $img) {
    if (is_file($img)) {
      $img_expl     = explode(DS, $img);
      $img_ends     = end($img_expl);
      rename($img, $new_path . $img_ends);

      $ret = true;
    }
  }
  if ($ret) {
    return $img_ends;
  }
}

function money_currency($currency, $number){
	return $currency.' '.number_format((float)$number,2);
}

function array_key_match_count($array, $key, $match_val) {
  $count = 0;
  foreach ($array as $k => $val) {
    if($match_val == $val[$key]){
      $count++;
    }
  }

  return $count;
}

function match_inarray($option_index, $option_array = array ()) {
  global $merchant_pmnt_mthds;

  $element = ($merchant_pmnt_mthds[$option_index -1]);

  if (isset($option_array[$element])) {
    return ($option_array[$element] == 1)?true:false;
  }
}

function short_paragrapth($string, $length) {
  $wrapped  = wordwrap($string, $length);
  $lines    = explode("\n", $wrapped);
  $ends     = (strlen($string) > $length)?' ...':'';
  return $lines[0] . $ends;
}

// messaging
function alert_type($type){
  if($type == 1){
    return 'alert-success';
  }else{
    return 'alert-warning';
  }
}

function convert_urls($string)
{
  $regex = "~((https?|ftp)\:\/\/)?"; // SCHEME
  $regex .= "([a-zA-Z0-9+!*(),;?&=\$_.-]+(\:[a-zA-Z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
  $regex .= "([a-zA-Z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
  $regex .= "(\:[0-9]{2,5})?"; // Port
  $regex .= "(\/([a-zA-Z0-9+\$_-]\.?)+)*\/?"; // Path
  $regex .= "(\?[a-z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
  $regex .= "(#[a-z_.-][a-zA-Z0-9+\$_.-]*)?~"; // Anchor

  $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
  return preg_replace($regex, '<a href="$0" target="_blank" title="$0">$0</a>', $string);
}

function highlight_words($text, $words)
{
  foreach ($words as $word)
  {
    $word = preg_quote($word);

    $text = preg_replace("/\b($word)\b/i", '<b>$1</b>', $text);

  }
  return $text;
}

function convert_timezone($date, $current_timezone = CURRENT_TIMEZONE, $end_timezone, $format = 'Y-m-d H:i:s')
{
  // $current_timezone = (CURRENT_TIMEZONE == "GMT" || CURRENT_TIMEZONE == "UTC") ? "Etc/UTC" : CURRENT_TIMEZONE;

  if ($current_timezone != $end_timezone) {

    $current_timezone = new DateTimeZone($current_timezone);

    $userTimezone     = new DateTimeZone($end_timezone);
    $myDateTime       = new DateTime($date, $current_timezone);

    $offset           = $userTimezone->getOffset($myDateTime);

    $myInterval       = DateInterval::createFromDateString((string)$offset . 'seconds');
    $myDateTime->add($myInterval);
    
    return $result = $myDateTime->format('Y-m-d H:i:s');
  }
}

function convert_get_tourl($get_arr) {
  $url_str = '';

  if (is_array($get_arr) & !empty($get_arr) ) {
    
    foreach ($get_arr as $key =>$val) {
      $url_str .= $key . '=' . $val . '&';
    }

    $url_str = rtrim($url_str, '&');
  }

  return $url_str;
}

// ime range
function create_time_range($start, $end, $interval = '30 mins', $format = '12')
{
  $startTime    = strtotime($start);
  $endTime      = strtotime($end);
  $returnFormat = ($format == '12') ? 'g:i:s A' : 'G:i A';

  $current      = time();
  $addTime      = strtotime('+' . $interval, $current);
  $diff         = $addTime - $current;

  $times        = array();
  while ($startTime < $endTime) {
    $times[]    = date($returnFormat, $startTime);
    $startTime += $diff;
  }
  $times[]      = date($returnFormat, $startTime);
  return $times;
}

// time lapsed function
function timelapsed($time, $cut_period = '')
{

  $time       = time() - $time; // to get the time since that moment
  $time       = ($time < 1) ? 1 : $time;
  $tokens     = array(
    31536000  => 'year',
    2592000   => 'month',
    604800    => 'week',
    86400     => 'day',
    3600      => 'hour',
    60        => 'minute',
    1         => 'second'
  );

  foreach ($tokens as $unit => $text) {
    if ($time < $unit && empty($cut_period)) continue;
    $numberOfUnits = floor($time / $unit);
    return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
  }

  // todo : time period cut
  
}


// sql helpers *****************************************
