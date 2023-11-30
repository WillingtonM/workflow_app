<?php


// EMAIL Constants
define('MAIL_DBUG', 0); // | 0 = off (for production use) | 1 = client messages | 2 = client and server messages |
define('MAIL_PORT', 465);  // Set the SMTP port number - likely to be 25, 465 or 587
define('MAIL_AUTH', true);
define('MAIL_SECR', 'ssl');
define('MAIL_FROM', array("name"=> PROJECT_TITLE , "email" => $_ENV["MAIL_MAIL"]) );
define('MAIL_NOREPLY', array("name"=> $_ENV['MAIL_USER_NOREPLY'] , "email" => $_ENV["MAIL_MAIL_NOREPLY"]) );

