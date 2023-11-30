<?php
require_once __DIR__ . '/validations.php';


// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;


function redirect_to($new_location){
  header("Location: ". $new_location);
  exit;
}

function get($name, $def='')
{
  if(isset($_SESSION['user_id']) && $_REQUEST[$name] == 'login'){
    // redirect_to('home');
  }else{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $def;
  }
}

function getPath(){
  global $page_excludes;
  // full url path
  $url          = trim($_SERVER['REQUEST_URI'], '/');
  $url_ary      = explode('/',$_SERVER['REQUEST_URI']);
  $url_count    = count($url_ary);

  $default_page = "home";

  if (HOST_IS_LOCAL) {
    if ($url_count == 3) {
      $url_get  = substr($url, strpos($url, "/") + 1);
    } else {
      redirect_to(DS . PROJECT_NAME . DS . $default_page);
    }
  } elseif ($url_count == 3) {
    $url_get    = substr($url, strpos($url, "/") + 1);
    $url_get    = ($url_get == '') ? $default_page : $url_get;
  } else {
    if ($url_count == 2) {
      $url_get  = substr($url, strpos($url, "/") + 0);
      $url_get  = ($url_get == '') ? $default_page : $url_get;
    } else {
      redirect_to(DS . PROJECT_NAME . DS . $default_page);
    }
  }

  if (strpos($url_get, "?") != 0) {
    list($page, $getArray) = explode("?", $url_get);
  } else {
    $page       = ($url_get == '') ? $default_page : $url_get;
    $getArray   = '';
  }

  $getValues    = array();
  if (!empty($getArray)) {

    $getlistToArray    = explode("&", $getArray);
    foreach ($getlistToArray as $key => $value) {
      if (strpos($value, "=") != 0) {
        list($get, $val) = explode("=", $value);
      } else {
        $get    = $value;
        $val    = '';
      }
      $getValues[$get] = $val;
    }
  }

  $page = strtolower($page);
  if (isset($_SESSION['user_id']) && $page === 'passreset') {
    redirect_to($default_page);
  } elseif (isset($_SESSION['user_status']) && !$_SESSION['user_status'] && !in_array($page, $page_excludes)) {
    redirect_to('settings');
  }

  return [$page, $getValues];
}

function post($url='', $type=''){
  return $type . DS . $url;
}

function host_url($path){
  return SERVER_PROT . $_ENV['PROJECT_HOST'].$path;
}

function isLogged(){
  if(isset($_SESSION['user_id'])){
    return true;
  }else {
    return false;
  }
}

function money_currency($currency, $number){
	return $currency.' '.number_format((float)$number,2);
}

function print_username($name, $last_name, $username){
	$output = "<span>";
	$output .= '<b>'.$name.' '.$last_name.'@</b>';
	$output .= '<small>'.$username.'</small>';
	$output .= '</span>';
	return $output;
}

function sanitize($dirty){
	return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

function get_token(){
  return (isset($_SESSION['csrf_token']))?$_SESSION['csrf_token']: $_SESSION['csrf_token'] = db_hash(bin2hex(random_bytes(22)));
}

function prep_exec($sql_stmnt, $sql_data, $sql_rqst){
  global $connect, $sql_request_data;

  $data = null;

  try {
    $stmt  = $connect->prepare($sql_stmnt);
    $stmt->execute($sql_data);

    if ($sql_rqst == $sql_request_data[0]) {
      $data = $stmt->fetch();
    } elseif ($sql_rqst == $sql_request_data[1]) {
      $data = $stmt->fetchAll();
    } elseif ($sql_rqst == $sql_request_data[3]) {
      $data = $stmt->rowCount();
    } elseif ($sql_rqst == $sql_request_data[2]) {
      $data = ($stmt) ? true : false;
    }
  } catch (Exception $e) {
    die("ERROR: Database execution error | " . $e->getMessage());
  }

  return ($data !== false) ? $data : false;

}

function passwor_check_2($userPassword, $hash){
  if (password_verify($userPassword, $hash)) {
    // Login successful.
    if (password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost' => 12])) {
      // Recalculate a new password_hash() and overwrite the one we stored previously
    }
    return true;
  } else {
    return false;
  }
}

function try_login($username, $password, $type="username") {

  if( $user = ($type == 'username')?get_user_by_username($username):get_user_by_email($username) ){
    if (passwor_check_2($password, $user['password'])){
      return $user;
    }else {
      return false;
    }
  } else {
    return false;
  }
}

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

// change date format
function change_date_format($from, $to, $date){
  $dt = DateTime::createFromFormat($from,$date);
  if($dt !== false && !array_sum($dt->getLastErrors())){
    // valid date
    $newdate = $dt->format($to);
  }else{
    $newdate = false;
  }
  return $newdate;
}

// HASHING
function password_hashing($password){
  return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
}

// messaging
function alert_type($type){
  if($type == 1){
    return 'alert-success';
  }else{
    return 'alert-warning';
  }
}

// Image Handling ************************************************************************
function chech_valid_mimetype($image){
  $valid    = array();
  $img_mime = array("image/jpeg", "image/jpg","image/gif", "image/bmp", "image/png", "image/webp");
  $finfo    = finfo_open( FILEINFO_MIME_TYPE );
  $mtype    = finfo_file( $finfo, $image );
  finfo_close( $finfo );

  if(!in_array($mtype, $img_mime)){
    // throw new RuntimeException('File Type Errror.');
    $valid['success']   = false;
    $valid['messages']  = 'The file type is incorrect';

  } else {
    $valid['success']   = true;
    $valid['messages']  = 'correct image';
  }
  return $valid;
}

function check_valid_imgsize($image)
{
  $valid = array();
  $size  = @getimagesize($image);

  if (empty($size) || ($size[0] === 0) || ($size[1] === 0)) {
      // throw new \Exception('Image size is not set.');
      $valid['success']   = false;
      $valid['messages']  = 'Image size is not set.';
  } elseif (!empty($size) && ($size[0] > 15000000) || ($size[1] > 15000000)) {
      // throw new RuntimeException('Exceeded filesize limit.');
      $valid['success']   = false;
      $valid['messages']  = 'The file size must be less than 15MB';
  } else {
    $valid = TRUE;
  }

  return $valid;
}

// image validation
function image_validation($img_name, $name, $img_temp, $dir_url)
{
  $valid = array('success' => true, 'message' => '', 'mime_type' => '');

  // mime type validation
  $valid_mime_type = chech_valid_mimetype($img_temp);

  if($valid['success'] && !$valid_mime_type['success'])
  {
    $valid['success']   = false;
    $valid['message']   = $valid_mime_type['message'];
  }

  // image size validation
  $valid_imgsize  = check_valid_imgsize($img_temp);
  if ($valid['success'] && !$valid_imgsize) {
    $valid['success']   = false;
    $valid['message']   = $valid_imgsize['message'];
  }

  if ($valid['success'] ) {
    $img_type     = strtolower(substr($img_name, strripos($img_name, '.') + 1));
    $img_name     = $name . '.' . $img_type;

    if (!is_dir($dir_url) && !file_exists($dir_url)) {
      mkdir($dir_url, 0777, true);
    }

    $img_url      = $dir_url . $img_name;

    if (move_uploaded_file($img_temp, $img_url)) {
      chmod($img_url, 0777);
      $valid['success']   = true;
      $valid['message']   = 'Image uploaded';
      $valid['mime_type'] = $img_type;
    }


  }

  return $valid;
}

function check_image_size($image_path, $resize_arr = array(500, 500), $strict = false) { // resize_arr['width', 'height']
  
  $list               = false;

  if ($strict) {
    $thumb_width      = $resize_arr[0];
    $thumb_max_height = $resize_arr[1];

    $aspect_ratio     = (float) $thumb_max_height / $thumb_width;

    $thumb_height     = round($thumb_width * $aspect_ratio);

    if ($thumb_height <= $thumb_max_height) {
      $list = [$thumb_width, $thumb_max_height];
    } else {
      while ($thumb_height > $thumb_max_height) {
        $thumb_width -= 10;
        $thumb_height = round($thumb_width * $aspect_ratio);
      }

      $list = [$thumb_width, $thumb_height];
    }

  } else {

    $thumb_width      = (is_array($resize_arr) && !empty($resize_arr)) ? $resize_arr[0] : 0;
    $thumb_height     = (is_array($resize_arr) && !empty($resize_arr)) ? $resize_arr[1] : 0;

    $max_dimension    = ($thumb_height >= $thumb_width) ? $thumb_height : $thumb_width;

    
    list($width_orig, $height_orig, $image_type) = getimagesize($image_path);
  
    // calculate the aspect ratio
    $aspect_ratio     = (float) $height_orig / $width_orig;

    if ($aspect_ratio > 1) {
      // calculate new height
      $thumb_height   = round($thumb_width * $aspect_ratio);

      if ($thumb_height <= $max_dimension) {
        $list = false;
      } else {
        while ($thumb_height > $max_dimension) {
          $thumb_width -= 10;
          $thumb_height = round($thumb_width * $aspect_ratio);
        }

        $list = [$thumb_width, $thumb_height];
      }
      
    } else {
      // calculate new width
      $thumb_max_width    = round($thumb_height * $aspect_ratio);
      $thumb_height       = round($thumb_width * $aspect_ratio);

      if ($width_orig <= $thumb_max_width) {
        $list         = [$width_orig, $height_orig];
      } else {
        while ($thumb_height > $max_dimension) {
          $thumb_width -= 10;
          $thumb_height = round($thumb_width * $aspect_ratio);
        }

        $list = [$thumb_width, $thumb_height];
        

      }
    }
    
  }

  return $list;
  
}

function image_resize($image_path, $resize_arr = array(500, 500)) {

  $thumb_width      = $resize_arr[0];
  $thumb_max_height = $resize_arr[1];
  $image            = false;

  // configure with favored image driver (gd by default)
  Image::configure(['driver' => 'gd']);

  // and you are ready to go ...
  if ($thumb_width > 0 && $thumb_max_height > 0) {
    $image          = Image::make($image_path)->resize($thumb_width, $thumb_max_height)->save();
  }

  return ($image) ? true: false;

} 

function img_centered($image_name,$o_path,$url){
  ob_start();
  $image_full_path = $o_path.$image_name;
	$img_type = mime_content_type($image_full_path);
  $img_type = strtolower($img_type);

	if($img_type == "image/png"){
		$src    = imagecreatefrompng($image_full_path);
	}

	if($img_type == "image/gif"){
		$src    = imagecreatefromgif($image_full_path);
	}

	if($img_type == "image/jpeg"){
		$src    = imagecreatefromjpeg($image_full_path);
	}

  if ($img_type == "image/bmp") {
    $src    = imagecreatefrombmp($image_full_path);
  }

  if ($img_type == "image/webp") {
    $src    = imagecreatefromwebp($image_full_path);
  }

	list($old_width, $old_height) = getimagesize($image_full_path);

	if ($old_width > $old_height){
		$dst_w = $old_height;
		$dst_h = $old_height;

		$dst_x = ($old_width - $old_height)/2;
		$dst_y = 0;
	}elseif ($old_height > $old_width) {
		$dst_h = $old_width;
		$dst_w = $old_width;

		$dst_x = 0;
		$dst_y = ($old_height - $old_width)/2;
	}else{
		$dst_w = $old_width;
		$dst_h = $old_height;

		$dst_x = 0;
		$dst_y = 0;
	}

	$tmp = imagecreatetruecolor($dst_w, $dst_h);
	imagecopyresampled($tmp, $src, 0, 0, $dst_x, $dst_y, $dst_w, $dst_h, $dst_w, $dst_h);

  // header('Content-Type: image/png');
	$img_name  = basename($image_full_path);
	$dir_url   = $o_path . $url;
	$dir 		   = $dir_url . DS . $img_name;

	if(!is_dir($dir_url) && !file_exists($dir_url)){
		mkdir($dir_url, 0777, true);
	}

  if(!file_exists($dir)){
    move_uploaded_file($img_name, $dir);

    if($img_type == "image/png"){
      $trans_index = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
      imagefill($tmp, 0, 0, $trans_index);
  		imagealphablending($tmp, false);
      imagesavealpha($tmp, true);
      $img_product = imagepng($tmp, $dir,9);
  	}
  	if($img_type == "image/gif"){
      $img_product = imagegif($tmp, $dir);
  	}
  	if($img_type == "image/jpeg"){
      $img_product = imagejpeg($tmp, $dir,100);
  	}
    if ($img_type == "image/bmp") {
      $img_product = imagebmp($tmp, $dir, 100);
    }
    if ($img_type == "image/webp") {
      $img_product = imagewebp($tmp, $dir, 100);
    }
  }

  imagedestroy($tmp);

  ob_end_clean();
	return $dir;
}

function img_thumbnail($image_path,$o_path,$url){
  ob_start();
	$img_type = image_type_to_mime_type(exif_imagetype($o_path.$image_path));
  $img_type = strtolower($img_type);
  $ext_path = $o_path . $image_path;

	if($img_type == "image/png"){
		$src = imagecreatefrompng($ext_path);
	}
	if($img_type == "image/gif"){
		$src = imagecreatefromgif($ext_path);
	}
	if($img_type == "image/jpeg"){
		$src = imagecreatefromjpeg($ext_path);
	}
  if ($img_type == "image/bmp") {
    $src = imagecreatefrombmp($ext_path);
  }
  if ($img_type == "image/webp") {
    $src = imagecreatefromwebp($ext_path);
  }

	list($old_width, $old_height) = getimagesize($ext_path);

	if ($old_width > $old_height){
		if($old_height < $old_width/2){
			$dst_w = $old_height*2;
			$dst_h = $old_height;

			$scl_h = (15/100)*$dst_h;
			$dst_h = $dst_h - $scl_h;

			$dst_x = 0;
			$dst_y = 0;
		}else{
			$dst_w = $old_width;
			$dst_h = $old_width/2;

			$scl_h = (15/100)*$dst_h;
			$dst_h = $dst_h - $scl_h;

			$dst_x = 0;
			$dst_y = ($old_width - $old_height)/2;
		}
	}elseif ($old_height > $old_width) {
		$dst_h = $old_width/2;
		$dst_w = $old_width;

		$scl_h = (15/100)*$dst_h;
		$dst_h = $dst_h - $scl_h;

		$dst_x = ($old_height - $old_width)/2;
		$dst_y = 0;
	}else{
		$dst_w = $old_width;
		$dst_h = $old_width/2;

		$scl_h = (15/100)*$dst_h;
		$dst_h = $dst_h - $scl_h;

		$dst_x = 0;
		$dst_y = ($old_width - $old_height)/2;
	}

	$tmp = imagecreatetruecolor($dst_w, $dst_h);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);

	$img_name = basename($ext_path);
	$dir_url  = $o_path.$url;
	$dir 		  = $dir_url . DS . $img_name;

	if(!is_dir($dir_url) && !file_exists($dir_url)){
		mkdir($dir_url,0777, true);
	}

  if(!file_exists($dir)){
    move_uploaded_file($img_name, $dir);
    if($img_type == "image/png"){
      $trans_index = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
      imagefill($tmp, 0, 0, $trans_index);
  		imagealphablending($tmp, false);
      imagesavealpha($tmp, true);
      $img_product = imagepng($tmp, $dir,9);
  	}
  	if($img_type == "image/gif"){
      $img_product = imagegif($tmp, $dir);
  	}
  	if($img_type == "image/jpeg"){
      $img_product = imagejpeg($tmp, $dir,100);
  	}
    if ($img_type == "image/bmp") {
      $img_product = imagebmp($tmp, $dir, 100);
    }
    if ($img_type == "image/webp") {
      $img_product = imagewebp($tmp, $dir, 100);
    }
  }else{

  }

  imagedestroy($tmp);

  ob_end_clean();
	return $dir;
}

function img_path($img_path, $img_name, $type=0 /* options : [0=original image, 1=sqaure image]*/) {
  global $image_modify_paths;
  
  $path_end = (endsWith($img_path, '/') || endsWith($img_path, DS)) ? '' : DS;
  $img_path = $img_path . $path_end;

  if ($type == 1) {
    return img_centered($img_name,$img_path,$image_modify_paths[$type]);
  } elseif ($type == 2) {
    return img_thumbnail($img_name, $img_path, $image_modify_paths[$type]);
  } else {
    $sub_path   = (!empty($image_modify_paths[$type]))? $image_modify_paths[$type] . DS :'';
    $file       = $img_path . $sub_path;
    if (!is_dir($file)) {
      mkdir($file, 0777, true);
    }
    return  $file . $img_name;
  }
}

function img_expanded($image_path,$o_path,$url){
  ob_start();
	$img_type = image_type_to_mime_type(exif_imagetype($o_path.$image_path));
  $img_type = strtolower($img_type);
  $ext_path = $o_path . $image_path;

	if($img_type == "image/png"){
		$src = imagecreatefrompng($ext_path);
	}
	if($img_type == "image/gif"){
		$src = imagecreatefromgif($ext_path);
	}
	if($img_type == "image/jpeg"){
		$src = imagecreatefromjpeg($ext_path);
	}
  if ($img_type == "image/bmp") {
    $src = imagecreatefrombmp($ext_path);
  }
  if ($img_type == "image/webp") {
    $src = imagecreatefromwebp($ext_path);
  }

	list($old_width, $old_height) = getimagesize($ext_path);

	if ($old_width > $old_height){
		if($old_height < $old_width/2){
			$dst_w = $old_height*2;
			$dst_h = $old_height;

			// $scl_h = (15/100)*$dst_h;
			// $dst_h = $dst_h - $scl_h;

			$dst_x = 0;
			$dst_y = 0;
		}else{
			$dst_w = $old_width;
			$dst_h = $old_width/2;

			// $scl_h = (15/100)*$dst_h;
			// $dst_h = $dst_h - $scl_h;

			$dst_x = 0;
			$dst_y = ($old_width - $old_height)/2;
		}
	}elseif ($old_height > $old_width) {
		$dst_h = $old_width/2;
		$dst_w = $old_width;

		// $scl_h = (15/100)*$dst_h;
		// $dst_h = $dst_h - $scl_h;

		$dst_x = ($old_height - $old_width)/2;
		$dst_y = 0;
	}else{
		$dst_w = $old_width;
		$dst_h = $old_width/2;

		// $scl_h = (15/100)*$dst_h;
		// $dst_h = $dst_h - $scl_h;

		$dst_x = 0;
		$dst_y = ($old_width - $old_height)/2;
	}

	$tmp = imagecreatetruecolor($dst_w, $dst_h);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);

	$img_name = basename($ext_path);
	$dir_url  = $o_path.$url;
	$dir 		  = $dir_url . DS . $img_name;

	if(!is_dir($dir_url) && !file_exists($dir_url)){
		mkdir($dir_url,0777, true);
	}

  if(!file_exists($dir)){
    move_uploaded_file($img_name, $dir);
    if($img_type == "image/png"){
      $trans_index = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
      imagefill($tmp, 0, 0, $trans_index);
  		imagealphablending($tmp, false);
      imagesavealpha($tmp, true);
      $img_product = imagepng($tmp, $dir,9);
  	}
  	if($img_type == "image/gif"){
      $img_product = imagegif($tmp, $dir);
  	}
  	if($img_type == "image/jpeg"){
      $img_product = imagejpeg($tmp, $dir,100);
  	}
    if ($img_type == "image/bmp") {
      $img_product = imagebmp($tmp, $dir, 100);
    }
    if ($img_type == "image/webp") {
      $img_product = imagewebp($tmp, $dir, 100);
    }
  }else{

  }

  imagedestroy($tmp);

  ob_end_clean();
	return $dir;
}

function article_img($profile_path, $img_name, $type = 0) {
  if ($img_name == DEFAULT_ARTICLE_IMG || $img_name == '') {
    // return DEFAULT_ARTICLE;
    return img_path(ABS_IMG_PATH, DEFAULT_ARTICLE_IMG, $type);
  } else {
    $path = ABS_ARTICLES . $profile_path . DS;
    return img_path($path, $img_name, $type);
  }
}

function global_imgs($dir_url, $img_class = 'col-md-3', $limit = 4, $view = false, $alt_src = '', $media_id = '') {
  $imgs           = glob($dir_url.'*.*', GLOB_BRACE);
  $global_count   = count($imgs);
  $output         = '';
  $count          = 0;
  $media_value    = (!empty($media_id)) ?'media="'. $media_id . '"':'';
  foreach ($imgs as $img) {
    if (is_file($img)) {
      $img_path     = $img;
      $img_expl     = explode(DS, $img);
      $img_ends     = end($img_expl);
      $img_full     = explode('.', $img_ends);
      $img_name     = $img_full[0];
      if ($view == 'carousel') {
        $active = (($count == 0 && empty($media_id) || (strtolower($media_id) == strtolower($img_ends)))) ? 'active' : '';

        $output   .= '<div id="' . $img_name . '" class="carousel-item ' . $active . ' text-center col-12 carousel_container ' . $img_class . '" data-bs-interval="0">';
        $output   .= '<div class="w-100 position-absolute"><a type="button" class="float-end text-light p-3" style="-webkit-text-stroke: .01em #333; z-index: 100"><span class="me-2">' . $count + 1 . '/' . $global_count . ' </span><i class="fa-solid fa-images fs-4"></i></a></div>';
        $output   .= '<img src="' . $img_path . '"class="col-12 img-responsive carousel_img_container" data-value="' . $media_id . '" path="' . $img_path . '" image="' . $img_ends . '">';
        $output   .= '</div>';
      } elseif ($view == 'sqaure') {

        $last_pos = strripos($img_path, DS);
        $rev  = strrev($img_path);
        $path = substr($rev, strlen($img_path) - ($last_pos +1) );
        $path = strrev($path);

        // $output     .= 'Hello world';
        $output     .= '<div id="' . $img_name . '" class="' . $img_name . ' ' . $img_class . ' img_mult" align="center" '.$media_value.'><img style="border-radius: 15px !important; padding: 0;" src="' . img_path($path, $img_ends, 1) . '" class="img-thumbnail" onclick="requestModal(post_modal[6],\'imgModal\',{\'media_src\':\'' . $alt_src . '\', \'media_img\':\'' . $img_ends . '\', \'media\':' . $media_id . '})"></div>';
      } elseif ($view == 'image') {
        $last_pos = strripos($img_path, DS);
        $rev  = strrev($img_path);
        $path = substr($rev, strlen($img_path) - ($last_pos + 1));
        $path = strrev($path);

        $output     .= '<div id="' . $img_name . '" class="' . $img_name . ' ' . $img_class . ' img_mult" align="center" '.$media_value.'><img style="border-radius: 15px !important; padding: 0;" src="' . img_path($path, $img_ends, 1) . '"class="img-thumbnail"></div>';
      } elseif ($view == true) {
        $output     .= '<div id="' . $img_name . '" class="' . $img_name . ' ' . $img_class . ' img_mult" align="center" '.$media_value.'><img style="border-radius: 15px !important; padding: 0;" src="' . $img_path . '"class="img-thumbnail" path="' . $img_path . '" image="' . $img_ends . '"></div>';
      } else {
        // $output     .= 'Hello world';
        $output     .= '<div id="' . $img_name . '" class="' . $img_name . ' ' . $img_class . ' img_mult" align="center" ' . $media_value . '><img style="border-radius: 15px !important; padding: 0;" src="' . $img_path . '"class="img-thumbnail" path="' . $img_path . '" image="' . $img_ends . '"><a type="button" data-path="' . $img_path . '" id="img_' . $img_name . '" class="img_del_btn btn-sm close">&times</a></div>';
      }
    }
    $count++;
    if ($count == $limit) { break; }
  }

  return $output;
}






// CURL get External Content
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function check_url($url) {
  return (filter_var($url, FILTER_VALIDATE_URL) === FALSE)?FALSE:TRUE;
}

function replace_inbewtween_char($string) {
  return preg_replace("/\<[^)]+\>/","",$string);
}

function short_paragrapth($string, $length) {
  $wrapped = wordwrap($string, $length);
  $lines = explode("\n", $wrapped);
  return $lines[0];
}

// Get client IP Address
function get_client_ip() {
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if(isset($_SERVER['REMOTE_ADDR']))
    $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
  $output = NULL;
  if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    if ($deep_detect) {
      if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
  }

  $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), '', strtolower(trim($purpose)));
  $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
  $continents = array(
    "AF" => "Africa",
    "AN" => "Antarctica",
    "AS" => "Asia",
    "EU" => "Europe",
    "OC" => "Australia (Oceania)",
    "NA" => "North America",
    "SA" => "South America"
  );

  if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
    // $ipdat = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    $ipdat = json_decode(url_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
      switch ($purpose) {
        case "location":
          $output = array(
            "city"           => @$ipdat->geoplugin_city,
            "state"          => @$ipdat->geoplugin_regionName,
            "country"        => @$ipdat->geoplugin_countryName,
            "country_code"   => @$ipdat->geoplugin_countryCode,
            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
            "continent_code" => @$ipdat->geoplugin_continentCode
          );
          break;
        case "address":
          $address = array($ipdat->geoplugin_countryName);
          if (@strlen($ipdat->geoplugin_regionName) >= 1)
            $address[] = $ipdat->geoplugin_regionName;
          if (@strlen($ipdat->geoplugin_city) >= 1)
            $address[] = $ipdat->geoplugin_city;
          $output = implode(", ", array_reverse($address));
          break;
        case "city":
          $output = @$ipdat->geoplugin_city;
          break;
        case "state":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "region":
          $output = @$ipdat->geoplugin_regionName;
            break;
        case "country":
          $output = @$ipdat->geoplugin_countryName;
          break;
        case "countrycode":
          $output = @$ipdat->geoplugin_countryCode;
          break;
      }
    }
  }

  return $output;
}


function is_logged_user()
{
  if (isset($_SESSION['user_id'])) {
    return true;
  } else {
    return false;
  }
}

function user_redirect()
{
  if (!is_logged_user()) {
    redirect_to('login');
  }
}


// ime range
function create_time_range($start, $end, $interval = '30 mins', $format = '12')
{
  $startTime = strtotime($start);
  $endTime   = strtotime($end);
  $returnTimeFormat = ($format == '12') ? 'g:i:s A' : 'G:i A';

  $current   = time();
  $addTime   = strtotime('+' . $interval, $current);
  $diff      = $addTime - $current;

  $times = array();
  while ($startTime < $endTime) {
    $times[] = date($returnTimeFormat, $startTime);
    $startTime += $diff;
  }
  $times[] = date($returnTimeFormat, $startTime);
  return $times;
}

function convert_timezone($date, $current_timezone = CURRENT_TIMEZONE, $end_timezone = '', $format = 'Y-m-d H:i:s')
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

// check if user is admin
function is_admin_check()
{
  // global $permissions;
  // $user = get_user_type_by_user_id($_SESSION['user_id']);
  // return ( $permissions && ($permissions['execute']) ) ? TRUE : FALSE;
  return ( isset($_SESSION['is_admin']) ) ? $_SESSION['is_admin'] : FALSE;
}

function member_state($data)
{
  global $client_task_associations;

  $reversed_ds  = array_reverse($client_task_associations, true);

  $res_key      = '';
  $res_arr      = array('key_text' => '', 'key_date' => '', 'upd_date' => '', 'key_stag' => '', 'key_stat' => '');

  foreach ($reversed_ds as $key => $val) {
    if (isset($data[$key]) && !empty($data[$key])) {
      $res_key  = $key;
      break;
    } else {
      continue;
    }
  }

  if ($res_key) {
    $res_arr['key_text']  = $res_key;
    $res_arr['key_date']  = (!empty($data[$res_key])) ? date(PRIMARY_DATE_FORMAT, strtotime($data[$res_key])) : '';
    $res_arr['upd_date']  = date(PRIMARY_DATE_FORMAT, strtotime($data['member_date_updated']));
    $res_arr['key_stag']  = $client_task_associations[$res_key];
    $res_arr['key_stat']  = (!empty($data[$res_key])) ? 'Complete' : 'Not initiated';
  }

  return $res_arr;
}

function get_sms_token()
{

  $curl = curl_init();

  $accountApiCredentials  = SMS_CLIENT_ID . ':' . SMS_CLIENT_API;
  $base64Credentials      = base64_encode($accountApiCredentials);
  $authHeader             = 'Authorization: Basic ' . $base64Credentials;
  $authEndpoint         = 'https://rest.mymobileapi.com/Authentication';

  curl_setopt_array($curl, [
    CURLOPT_URL => $authEndpoint,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
      "Accept: application/json",
      $authHeader
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  return [$err, $response];
}


function sms_send($message = '', $phone = '', $user_id = '')
{

  $curl = curl_init();

  list($authToken, $authResult) = get_sms_token();

  $sendUrl      = 'https://rest.mymobileapi.com/bulkmessages';
  $authHeader   = 'Authorization: Bearer ' . $authToken;
  $sendData     = '{ "messages" : [ { "content" : "' . $message . '", "destination" : "' . $phone . '", "customerId" : "' . $user_id . '" } ] }';

  curl_setopt_array($curl, [
    CURLOPT_URL => $sendUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    // CURLOPT_POSTFIELDS => "{\"messages\":[{\"document\":{\"variables\":{},\"version\":0}}]}",
    CURLOPT_POSTFIELDS => $sendData,
    CURLOPT_HTTPHEADER => [
      "Accept: application/json",
      "Content-Type: text/json",
      "Authorization:" . $authHeader,

    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);
  var_dump($response);

  curl_close($curl);

  return [$err, $response];
}

// sms API functions
function get_smsapi_token()
{

  $accountApiCredentials  = SMS_CLIENT_ID . ':' . SMS_CLIENT_API;
  $base64Credentials      = base64_encode($accountApiCredentials);

  $authHeader   = 'Authorization: Basic ' . $base64Credentials;

  $authEndpoint = 'https://rest.mymobileapi.com/Authentication';

  $authOptions  = array(
    'http' => array(
      'header'        => $authHeader,
      'method'        => 'GET',
      'ignore_errors' => true
    )
  );
  $authContext  = stream_context_create($authOptions);

  $result       = file_get_contents($authEndpoint, false, $authContext);

  $authResult   = json_decode($result);

  $status_line  = $http_response_header[0];

  preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
  $status       = $match[1];

  $authToken    = ($status === '200') ? $authResult->{'token'} : '';

  return [$authToken, $authResult];
}

function post_sms_message($message = '', $phone = '', $user_id = '')
{

  list($authToken, $authResult) = get_smsapi_token();


  $sendUrl      = 'https://rest.mymobileapi.com/bulkmessages';

  $authHeader   = 'Authorization: Bearer ' . $authToken;

  $sendData     = '{ "messages" : [ { "content" : "' . $message . '", "destination" : "' . $phone . '", "customerId" : "' . $user_id . '" } ] }';

  $options = array(
    'http' => array(
      'header'  => array("Content-Type: application/json", $authHeader),
      'method'  => 'POST',
      'content' => $sendData,
      // 'content' => $data,
      'ignore_errors' => true
    )
  );
  $context  = stream_context_create($options);

  $sendResult = file_get_contents($sendUrl, false, $context);

  $status_line = $http_response_header[0];
  preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
  $status = $match[1];

  return [$status, $sendResult];
}

function generateRandomString($length = 6, $number_only = false) {
  $characters = ($number_only) ? '0123456789' : '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function get_company_id() {
  return (isset($_SESSION['company_id'])) ? $_SESSION['company_id'] : '';
}

function company_subscription() {
  return (isset($_SESSION['SUBSCRIPTION_ACTIVE'])) ? $_SESSION['SUBSCRIPTION_ACTIVE'] : FALSE ;
}

function company_isset() {
  return (isset($_SESSION['company_setup']) && $_SESSION['company_setup']) ? TRUE : FALSE; 
}