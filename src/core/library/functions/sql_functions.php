<?php
$key        = constant("MERCHANT_KEY");
$email_key  = constant("EMAIL_KEY");
$date       = date('Y-m-d H:i:s');

// -----------------------------------------------------------------------------
// user

function check_user($user_id)
{
  global $sql_request_data;

  $sql_stmnt   = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
  $sql_data   = [$user_id];

  return (prep_exec($sql_stmnt, $sql_data, $sql_request_data[0])) ? true : false;
}


function get_user_by_id($user_id)
{
  global $sql_request_data;

  $sql_stmnt  = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
  $sql_data   = [$user_id];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[0])) ? $sql_result : null;
}

function get_user_by_username($username)
{
  global $sql_request_data;

  $sql_stmnt  = "SELECT * FROM users WHERE username = ? LIMIT 1";
  $sql_data   = [$username];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[0])) ? $sql_result : null;
}

function get_user_by_email($email)
{
  global $sql_request_data;

  $sql_stmnt  = "SELECT * FROM users WHERE email = ? LIMIT 1";
  $sql_data   = [$email];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[0])) ? $sql_result : null;
}

function get_user_by_user_type_id($type_id)
{
  global $sql_request_data;

  $company_id = get_company_id();


  $sql_stmnt  = "SELECT * FROM users WHERE user_type_id = ? AND user_status = 1 AND company_id = ? ORDER BY user_listpos";
  $sql_dta    = [$type_id, $company_id];
  return ($req_res = prep_exec($sql_stmnt, $sql_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_all_user()
{
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt  = "SELECT * FROM users WHERE user_status = 1 AND company_id = ? ORDER BY user_listpos";
  $sql_dta    = [$company_id];
  return ($req_res = prep_exec($sql_stmnt, $sql_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_all_checkers()
{
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt  = "SELECT * FROM users WHERE user_status = 1 AND user_is_checker = 1 AND company_id = ? ORDER BY user_listpos";
  $sql_dta    = [$company_id];
  return ($req_res = prep_exec($sql_stmnt, $sql_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_all_admins()
{
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt  = "SELECT * FROM users WHERE user_status = 1 AND (user_type = 'sys_admin' || user_type = 'administrator') AND company_id = ? ORDER BY date_created ASC";
  $sql_dta    = [$company_id];
  return ($req_res = prep_exec($sql_stmnt, $sql_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_media_by_id($id)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM media WHERE media_id = ? LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_media_by_title($title, $media_type = '')
{
  global $sql_request_data;

  $ext_sql = (!empty($media_type)) ? " AND media_type = ? " : "";
  $req_sql = "SELECT * FROM media WHERE media_title = ? $ext_sql LIMIT 1";
  $req_dta = (!empty($media_type)) ? [$title, $media_type] : [$title];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_media_by_media_type($type)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM media WHERE media_type = ? AND media_status = 1 ORDER BY media_publish_date DESC";
  $req_dta = [$type];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function count_media_by_media_type($type)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM media WHERE media_type = ? AND media_status = 1";
  $req_dta = [$type];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[3])) ? $req_res : null;
}


// ****************************************************************************************
// page_contents 

function get_page_content_by_name($page_content_name)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM page_contents WHERE page_content_name = ? LIMIT 1";
  $req_dta = [$page_content_name];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}


// API users
function get_api_by_user_id($user_id)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM api_users WHERE user_id = ? LIMIT 1";
  $req_dta = [$user_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

// heeell ======================================================================

// ********************************************************
// associations
function get_association_by_user_id($user_id)
{
  global $sql_request_data;

  $cnt_sql = "SELECT * FROM associations as a INNER JOIN client_associations m ON m.client_association_id = a.client_association_id INNER JOIN practice_areas p ON a.practice_area_id = p.practice_area_id WHERE a.user_id = ? AND a.association_status = 1";
  $cnt_dta = [$user_id];
  return ($cnt_res = prep_exec($cnt_sql, $cnt_dta, $sql_request_data[1])) ? $cnt_res : null;
}

function get_association_by_client_association_id($user_id)
{
  global $sql_request_data;

  $cnt_sql = "SELECT DISTINCT m.association_name, m.association_name_other, m.client_association_id, m.association_description, a.association_status, a.practice_area_id, p.practice_area FROM associations as a INNER JOIN client_associations m ON m.client_association_id = a.client_association_id INNER JOIN practice_areas p ON a.practice_area_id = p.practice_area_id WHERE a.client_association_id = ? AND a.association_status = 1";
  $cnt_dta = [$user_id];
  return ($cnt_res = prep_exec($cnt_sql, $cnt_dta, $sql_request_data[1])) ? $cnt_res : null;
}

function get_association_user_by_client_association_id($user_id)
{
  global $sql_request_data;

  $cnt_sql = "SELECT DISTINCT u.user_id, u.name, u.last_name, u.username, u.contact_number, a.association_status, a.practice_area_id, p.practice_area FROM associations as a INNER JOIN users u ON u.user_id = a.user_id INNER JOIN practice_areas p ON a.practice_area_id = p.practice_area_id WHERE a.client_association_id = ? AND a.association_status = 1";
  $cnt_dta = [$user_id];
  return ($cnt_res = prep_exec($cnt_sql, $cnt_dta, $sql_request_data[1])) ? $cnt_res : null;
}

function get_client_association_by_user_id($user_id, $client_assoc_id, $status_check = true)
{
  global $sql_request_data;

  $usr_sts = ($status_check) ? "AND client_association_status = 1" : "";
  $req_sql = "SELECT * FROM associations a INNER JOIN client_associations m ON m.client_association_id = a.client_association_id INNER JOIN practice_areas p ON a.practice_area_id = p.practice_area_id WHERE a.user_id = ? AND a.client_association_id = ? $usr_sts LIMIT 1";
  $req_dta = [$user_id, $client_assoc_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_client_association_by_id($client_assoc_id, $statsu_strict = true)
{
  global $sql_request_data;

  $ext_dta = ($statsu_strict) ? 'AND client_association_status = 1' : '';

  $req_sql = "SELECT * FROM client_associations WHERE client_association_id = ? $ext_dta LIMIT 1";
  $req_dta = [$client_assoc_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_client_association_by_name_other($name)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM client_associations WHERE association_name_other = ? AND company_id = ? AND client_association_status = 1 LIMIT 1";
  $req_dta = [$name, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_client_association_by_reference($name)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM client_associations WHERE association_reference = ? AND company_id = ? AND client_association_status = 1 LIMIT 1";
  $req_dta = [$name, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_client_association_by_identity($name)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM client_associations WHERE association_identity = ? AND company_id = ? AND client_association_status = 1 LIMIT 1";
  $req_dta = [$name, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

// ********************************************************
// Notifications 
function insert_notifications($user_id, $notification_alt_id, $database, $database_id, $user_type = 0, $notification_type = 0, $notification_message = '', $message_index = '')
{
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt  = "INSERT INTO notifications (company_id, user_id, user_type, notification_type, notification_alt_id, notification_database, notification_database_id, notification_message, notification_message_index) VALUES (?,?,?,?,?,?,?,?,?)";
  $sql_data   = [$company_id, $user_id, $user_type, $notification_type, $notification_alt_id, $database, $database_id, $notification_message, $message_index];
  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[2])) ? true : false;
}

// ********************************************************
// task history
function insert_task_history($user_id, $task_id, $activity_type, $details = '')
{
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt  = "INSERT INTO task_history (company_id, user_id, activity_type, task_id, details) VALUES (?,?,?,?,?)";
  $sql_data   = [$company_id, $user_id, $activity_type, $task_id, $details];
  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[2])) ? true : false;
}

function get_task_histories($id)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM task_history th INNER JOIN tasks ts ON ts.task_id = th.task_id WHERE ts.task_id = ?  AND ts.task_status = 1 AND ts.company_id = ?";
  $req_dta = [$id, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_task_histories_long($user_id = 0, $limit = 0, $page_start = 0)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $lmt_stmnt  = ($limit == 0) ? '' : ' LIMIT ' . $page_start . ',' .  $limit;
  $usr_stmnt  = ($user_id == 0) ? '' : ' th.user_id = ' . $user_id . ' AND';

  $req_sql = "SELECT * FROM task_history th INNER JOIN tasks ts ON ts.task_id = th.task_id WHERE $usr_stmnt ts.task_status = 1 AND ts.company_id = ? ORDER BY th.history_date_created	DESC $lmt_stmnt";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_user_task_history($user_id, $task_id) 
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM task_history WHERE user_id = ? AND task_id = ?  AND history_status = 1";
  $req_dta = [$user_id, $task_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}


function get_recent_task_history($user_id = NULL) 
{
  global $sql_request_data;

  $company_id = get_company_id();

  $usr_sql = ($user_id) ? " AND th.user_id = " . $user_id . " ": "";
  $req_sql = "SELECT DISTINCT ts.task_id, th.user_id, th.history_date_created, th.activity_type, ts.task_name FROM task_history th INNER JOIN tasks ts ON ts.task_id = th.task_id WHERE ts.task_status = 1 AND ts.company_id = ? " . $usr_sql . " ORDER BY th.history_date_updated DESC LIMIT 5";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

// ********************************************************
// Notifications 
function get_notification_by_id($notification_id)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM notifications WHERE notification_id = ?  AND notification_status = 1 AND company_id = ? LIMIT 1";
  $req_dta = [$notification_id, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_notifications_by_user_id($user_id)
{
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM notifications WHERE user_id = ?  AND notification_status = 1 AND company_id = ?";
  $req_dta = [$user_id, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

// registry
function get_registry_by_id ($registry_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM registry WHERE registry_id = ?  AND registry_status = 1 LIMIT 1";
  $req_dta = [$registry_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}




// careers ***********************************************************************************

// get career by id
function get_career_by_id($id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM careers WHERE career_id = ? LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_careers($limit = null, $active = false) {
  global $sql_request_data;
  $lmt_sql = ($limit) ? "LIMIT " .$limit : '';
  $dte_sql = ($active) ? "AND DATE(career_closing_date) >= DATE(NOW()) " : '';
  $req_sql = "SELECT * FROM careers WHERE career_status = 1 " . $dte_sql . "ORDER BY career_closing_date DESC " . $lmt_sql;
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

// get career application
function get_career_application_by_id($id)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM career_applications WHERE application_id = ? LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_career_applications($limit = null, $active = 1)
{
  global $sql_request_data;
  $lmt_sql = ($limit) ? "LIMIT " . $limit : '';
  $req_sql = "SELECT * FROM career_applications WHERE application_status = ? ORDER BY application_date_created DESC " . $lmt_sql;
  $req_dta = [$active];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}


// ****************************************************************************************
// events 

function get_event_by_date($event_host_date)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM events WHERE event_host_date = ? LIMIT 1";
  $req_dta = [$event_host_date];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_event_by_id($event_id)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM events WHERE event_id = ? LIMIT 1";
  $req_dta = [$event_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_event_by_email($email)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM events WHERE event_user_email = ? ORDER BY event_date_updated DESC LIMIT 1";
  $req_dta = [$email];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_events($processed = NULL)
{
  global $sql_request_data;

  $evn_txt = ($processed !== NULL && $processed == TRUE) ? 1:0;
  $evt_prc = ($processed === NULL) ? "" : "event_processed = " . $evn_txt;

  $req_sql = "SELECT * FROM events WHERE $evt_prc ORDER BY event_date_created DESC";
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_events_processed()
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM events WHERE event_processed = 1 ORDER BY event_date_created DESC";
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_events_unprocessed()
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM events WHERE event_processed = 0 ORDER BY event_date_created DESC";
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_events_active($active = 2, $type = '')
{
  global $sql_request_data;

  $type    = sanitize($type);
  $typ_sql = (!empty($type)) ? "AND event_type = '" . $type . "'": '';
  $dte_sql = ($active == 1) ? "AND DATE(event_host_date) >= DATE(NOW()) " : (($active == 0) ? "AND DATE(event_host_date) < DATE(NOW()) ": '');
  $req_sql = "SELECT * FROM events WHERE event_status = 1 " . $dte_sql . $typ_sql . " ORDER BY event_host_date DESC";
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}



// orders *************************************************************************************

function get_order_by_id($id)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM orders WHERE order_id = ? LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_order_by_code($code)
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM orders WHERE order_track_code = ? LIMIT 1";
  $req_dta = [$code];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_order_by_event_id($event_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM orders WHERE event_id = ? LIMIT 1";
  $req_dta = [$event_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_orders()
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM orders ORDER BY order_date DESC";
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_notifications_by_order_id($order_id)
{
  global $sql_request_data;
  
  $req_sql = "SELECT * FROM notifications WHERE order_id = ? AND notification_status = 1 ORDER BY notification_created_date DESC";
  $req_dta = [$order_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_notification_by_index ($order_id, $index) {
  global $sql_request_data;
  
  $req_sql = "SELECT * FROM notifications WHERE order_id = ? AND notification_message_index = ? LIMIT 1";
  $req_dta = [$order_id, $index];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

// feedback ***********************************************************************************
function get_feedback() 
{
  global $sql_request_data;

  $req_sql = "SELECT * FROM feedback WHERE feedback_status = 1 ORDER BY feedback_date_created DESC";
  $req_dta = [];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}


// feedback ***********************************************************************************
// user type

function get_user_type_by_id ($type_id, $user_type = 1) {
  global $sql_request_data;

  $req_inf = ($user_type == 1) ? " AND user_type_status = 1" : "";
  $req_sql = "SELECT * FROM user_types WHERE user_type_id = ?". $req_inf . " LIMIT 1";
  $req_dta = [$type_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_user_type_by_name($user_type) {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM user_types ut INNER JOIN users u ON ut.user_id = u.user_id WHERE ut.user_type = ? AND u.company_id = ? LIMIT 1";
  $req_dta = [$user_type, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_user_type_by_user_id($user_id) {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM user_types ut INNER JOIN users u ON ut.user_id = u.user_id WHERE u.user_id = ? AND u.company_id = ? LIMIT 1";
  $req_dta = [$user_id, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

// get all usertypes
function get_user_types() {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM user_types WHERE user_type_status = 1 AND (company_id = ? OR user_type_default = 1)";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

// -----------------------------------------------------------------------------
// tasks
function get_task_by_id($id)
{
  global $sql_request_data;
  
  $req_sql = "SELECT * FROM tasks WHERE task_id = ? LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_task_by_name($task_name) {
 global $sql_request_data;

  $req_sql = "SELECT * FROM tasks WHERE task_name = ?  AND task_status = 1 LIMIT 1";
  $req_dta = [$task_name];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_tasks_by_assigned_id($user_id, $complete = 0, $limit = 0, $page_start = 0) {
 global $sql_request_data;

  $lmt_stmnt  = ($limit == 0) ? '' : ' LIMIT ' . $page_start . ',' .  $limit;
  $cmp_stmnt  = ($complete == 0) ? '':' AND task_completed = 1';

  $req_sql = "SELECT * FROM tasks WHERE assigned_to = ?  AND task_status = 1 $cmp_stmnt ORDER BY task_date_created	DESC $lmt_stmnt";
  $req_dta = [$user_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_completed_tasks_by_assigned_id($user_id, $limit = 0, $page_start = 0) {
 global $sql_request_data;

  $lmt_stmnt  = ($limit == 0) ? '' : ' LIMIT ' . $page_start . ',' .  $limit;

  $req_sql = "SELECT * FROM tasks WHERE assigned_to = ?  AND task_status = 1 AND task_completed = 1 ORDER BY task_date_created	DESC $lmt_stmnt";
  $req_dta = [$user_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}


function get_active_tasks($limit = 0, $page_start = 0)
{
  global $sql_request_data;

  $lmt_stmnt  = ($limit == 0) ? '' : ' LIMIT ' . $page_start . ',' .  $limit;

  $sql_stmnt  = "SELECT * FROM tasks WHERE task_status = 1 AND task_completed = 0 ORDER BY task_date_created	DESC $lmt_stmnt";
  $sql_data   = [];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[1])) ? $sql_result : null;
}

function get_complete_tasks($limit = 0)
{
  global $sql_request_data;

  $lmt_stmnt  = ($limit == 0)?'':'LIMIT '.$limit;
  $sql_stmnt  = "SELECT * FROM tasks WHERE task_status = 1 AND task_completed = 1 ORDER BY task_date_updated DESC $lmt_stmnt";
  $sql_data   = [];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[1])) ? $sql_result : null;
}


// -----------------------------------------------------------------------------
// categories
function get_category_by_id($id)
{
  global $sql_request_data;
  
  $req_sql = "SELECT * FROM task_categories WHERE category_id = ? LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_category_name($category) {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM task_categories WHERE category = ? AND company_id = ? LIMIT 1";
  $req_dta = [$category, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}


function get_categories() {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM task_categories WHERE category_status = 1 AND company_id = ?";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}


// -----------------------------------------------------------------------------
// settings

function get_seetings () {
  global $sql_request_data;

  $sql_stmnt  = "SELECT * FROM settings WHERE user_id = ? LIMIT 1";
  $sql_data   = [1];

  $sql_res    = prep_exec($sql_stmnt, $sql_data, $sql_request_data[0]);
  if (!$sql_res) {
    $header   = '<p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center"><span style="color: #44546A; font-size: 18px;">I’ve just published a new article, please find the full text below.</span> </p>';
    $footer   = '<p style="margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;border:none;padding:0cm;"><span style="color:#44546A;">&nbsp;</span></p>
          <p style="margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;border:none;padding:0cm;"><span style="color:#44546A;">Regards,</span></p>
          <p style="margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;border:none;padding:0cm;"><span style="color:#44546A;"> </span></p>
          <p style="margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;border:none;padding:0cm;"><span style="color:#44546A;">&nbsp;</span></p>';
    $sql_ins  = "INSERT INTO settings (user_id, setting_email_header, setting_email_footer) VALUES (1, ?, ?)";
    $sql_dta  = [$header, $footer];

    $sql_res  = prep_exec($sql_ins, $sql_dta, $sql_request_data[0]);
  }

  return $sql_res;
}

// practice areas  -----------------------------------------------------------------------------
// 

function get_practice_area_by_id ($id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM practice_areas WHERE practice_area_id = ?  AND practice_area_status = 1 LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_practice_areas_by_company($company_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM practice_areas WHERE practice_area_status = 1 AND company_id = ?";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

// practice tasks  -----------------------------------------------------------------------------
// 

function get_practice_task_by_id ($id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM practice_tasks WHERE practice_task_id = ?  AND practice_task_status = 1 LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_practice_task_by_name($task_name) {
 global $sql_request_data;

  $req_sql = "SELECT * FROM practice_tasks WHERE practice_task_name = ?  AND practice_task_status = 1 LIMIT 1";
  $req_dta = [$task_name];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_practice_tasks_by_company($company_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM practice_tasks pt INNER JOIN practice_areas pa ON pt.practice_area_id = pa.practice_area_id WHERE practice_task_status = 1 AND pa.company_id = ?";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function count_practice_tasks_by_company($company_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM practice_tasks pt INNER JOIN users u ON pt.user_id = u.user_id WHERE pt.practice_task_status = 1 AND u.company_id = ? ORDER BY pt.practice_task_position ASC";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[3])) ? $req_res : null;
}

function increment_practice_task_positions($position) {
  global $sql_request_data;

  $req_sql = "UPDATE practice_tasks SET practice_task_position = practice_task_position + 1 WHERE ISNULL(practice_task_position) OR practice_task_position >= ?";
  $req_dta = [$position];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[2])) ? $req_res : null;
}

function increment_practice_task_position($task_id, $position) {
  global $sql_request_data;

  $req_sql = "UPDATE practice_tasks SET practice_task_position = ? WHERE practice_task_id = ? LIMIT 1";
  $req_dta = [$position, $task_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[2])) ? $req_res : null;
}

function get_practice_task_position($position) {
  global $sql_request_data;

  $req_sql = "SELECT practice_task_id, practice_task_position FROM practice_tasks WHERE ISNULL(practice_task_position) OR practice_task_position > ? ORDER BY practice_task_position ASC";
  $req_dta = [$position];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_practice_tasks_by_practice($practice_area_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM practice_tasks WHERE practice_task_status = 1 AND practice_area_id = ? ORDER BY practice_task_position ASC";
  $req_dta = [$practice_area_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

// activity tasks  -----------------------------------------------------------------------------
// 
function insert_activity_task ($user_id, $client_assoc_id, $task_id, $task_date) {
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt = "INSERT INTO activity_tasks (company_id, user_id, client_association_id, practice_task_id, activity_task_date) VALUES (?,?,?,?,?)";
  $sql_data  = [$company_id, $user_id, $client_assoc_id, $task_id, $task_date];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[2])) ? true : false;
}

function update_activity_task ($task_date, $user_id, $client_assoc_id, $practice_task_id) {
  global $sql_request_data;

  $company_id = get_company_id();

  $sql_stmnt  = "UPDATE activity_tasks SET activity_task_date = ?, user_id = ? WHERE client_association_id = ? AND practice_task_id = ? AND company_id = ? LIMIT 1";
  $sql_data  = [$task_date, $user_id, $client_assoc_id, $practice_task_id, $company_id];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[2])) ? true : false;
}

// get activity task by client_association_id
function get_activity_tasks_by_client_association_id($client_assoc_id, $order_asc = true) {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_opt = ($order_asc) ? "ASC" : "DESC";

  $req_sql = "SELECT * FROM activity_tasks AS act INNER JOIN practice_tasks AS pt ON act.practice_task_id = pt.practice_task_id WHERE act.activity_task_status = 1 AND !ISNULL(act.activity_task_date) AND act.client_association_id = ? AND act.company_id = ? ORDER BY pt.practice_task_position $req_opt LIMIT 1";
  $req_dta = [$client_assoc_id, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_activity_tasks_by_practice_task ($client_assoc_id, $task_id) {
  global $sql_request_data;

  $company_id = get_company_id();

  $req_sql = "SELECT * FROM activity_tasks AS act INNER JOIN practice_tasks AS pt ON act.practice_task_id = pt.practice_task_id WHERE act.activity_task_status = 1 AND act.client_association_id = ? AND act.practice_task_id = ? AND act.company_id = ? LIMIT 1";
  $req_dta = [$client_assoc_id, $task_id, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

// office and companies  -----------------------------------------------------------------------------
// office and companies
function get_company_by_id ($id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM companies WHERE company_id = ?  AND company_status = 1 LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_company_by_name($company_name) {
   global $sql_request_data;

  $req_sql = "SELECT * FROM companies WHERE company_name = ?  AND company_status = 1 LIMIT 1";
  $req_dta = [$company_name];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_office_by_id ($id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM offices WHERE office_id = ?  AND office_status = 1 LIMIT 1";
  $req_dta = [$id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_office_by_company_id($company_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM offices WHERE office_status = 1 AND company_id = ? ORDER BY office_id ASC";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_offices_by_company($company_id) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM offices WHERE office_status = 1 AND company_id = ?";
  $req_dta = [$company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[1])) ? $req_res : null;
}

function get_office_by_name_company($company_id, $office_name) {
  global $sql_request_data;

  $req_sql = "SELECT * FROM offices WHERE company_id = ? AND office_name = ?  AND office_status = 1 LIMIT 1";
  $req_dta = [$company_id, $office_name];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[0])) ? $req_res : null;
}

function get_countries_by_phonecode($phonecode)
{
  global $sql_request_data;

  $sql_stmnt  = "SELECT * FROM countries WHERE phonecode = ? LIMIT 1";
  $sql_data   = [$phonecode];

  return ($sql_result = prep_exec($sql_stmnt, $sql_data, $sql_request_data[0])) ? $sql_result : null;
}

// subscriptions

function subscription_activation($company_id, $status) {
  global $sql_request_data;

  $status  = ($status) ? 1: 0;

  $req_sql = "UPDATE companies SET company_status = ? WHERE compnay_id = ? LIMIT 1";
  $req_dta = [$status, $company_id];
  return ($req_res = prep_exec($req_sql, $req_dta, $sql_request_data[2])) ? $req_res : null; 
}