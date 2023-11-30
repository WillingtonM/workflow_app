<?php
$is_admin       = is_admin_check();
$subscription   = company_subscription();
$tabbs_count    = 0;
$allowed_db     = array('associations', 'client_associations');


if (isset($_SESSION['user_id'])) {
    $user_id    = $_SESSION['user_id'];
}
