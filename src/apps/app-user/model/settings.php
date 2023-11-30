<?php
$is_admin       = is_admin_check();
$subscription   = company_subscription();

if(!isset($_SESSION['is_admin']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == FALSE)):
    redirect_to('home');
endif;