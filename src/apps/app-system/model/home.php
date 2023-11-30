<?php
$is_admin       = is_admin_check();
$subscription   = company_subscription();

if(isset($_SESSION['user_id'])) {
  $user_id      = $_SESSION['user_id'];
  $user_qdta    = get_user_by_id($user_id);
}
