<?php
require_once __DIR__ .'/email_config.php';
require_once $config['LIB_EMAIL'] . 'mail_functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Etc/UTC');

if(!class_exists('MailClass')){

  /** Email Class **/
  class MailClass
  {
    public $mail;

    function __construct($excetions = true)
    {
      $this -> mail =  new PHPMailer($excetions);

      $this->mail->isSMTP();
      $this->mail->SMTPDebug    = MAIL_DBUG;
	    // Set the hostname of the mail server
	    $this->mail->Host         = $_ENV["MAIL_HOST"];
	    // Set the SMTP port number - likely to be 25, 465 or 587
	    $this->mail->Port         = MAIL_PORT;
	    // Whether to use SMTP authentication
	    $this->mail->SMTPAuth     = MAIL_AUTH;
      
      $this->mail->clearAllRecipients();
      $this->mail->clearAttachments();
      $this->mail->clearCustomHeaders();
	    // Username to use for SMTP authentication
	    $this->mail->Username     = $_ENV["MAIL_MAIL"]; // user@user.com
      //  Password to use for SMTP authentication
	    $this->mail->Password     = $_ENV["MAIL_PASS"];
      //  TLS encryption to use for SMTP authentication
      $this->mail->SMTPSecure   = MAIL_SECR;
      $this->mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );
    }

    public function mail($to = array(), $subject = '', $html = '', $from = array(), $plaintext = false, $cc = array(), $bcc = array(), $attachments = array())
    {
      if(empty($to) || empty($subject) || empty($html) || empty($from) )
      {
        die("There are some missing parameters");
      }

      // sender
      $this->mail->setFrom($from['email'], $from['name']); //Set who the message is to be sent from
      $this->mail->addReplyTo($from['email'], $from['name']); //Set an alternative reply-to address

      // Recipient
      if(!empty($to))
      {
        foreach ($to as $recipient) {
          $this->mail->addAddress($recipient['email'], $recipient['name']);
        }
      }
      // Recipient
      if(!empty($cc))
      {
        foreach ($cc as $recipient) {
          $this->mail->addCC($recipient);
        }
      }

      // BCC
      if(!empty($bcc))
      {
        foreach ($bcc as $recipient) {
          $this->mail->addBCC($recipient);
        }
      }

      // Attachments
      if(!empty($attachments))
      {
        foreach ($attachments as $attachment) {
          $this->mail->addBCC($recipient);
        }
      }

      // HTML email
      $this->mail->isHTML(true);
      $this->mail->Subject  = $subject;
      $this->mail->Body     = $html;
      // Read an HTML message body from an external file, convert referenced images to embedded,
      // convert HTML into a basic plain-text alternative body
      // $mail->msgHTML(file_get_contents('contents.html'), __DIR__);

      // Plain Teaxt Version
      if(false !== $plaintext)
      {
        $this->mail->AltBody = $plaintext;
      }

      // Send eMail
      try {
        $this->mail->send();
        return TRUE;
      } catch (\Exception $e) {
        // echo "Message could not be sent, Message error: " . $this->mail->ErrorInfo;
        // return "Message could not be sent, Message error: " . $this->mail->ErrorInfo;
        return FALSE;
      }
    }
  }

}

$mailer = new MailClass();

// format of recipient emais
// $to = array(
//   array(
//     "name" => "Mhlanga Willows",
//     "email" => "mhlangawillington@yahoo.com"
//   ),
// );

// $to = array(
//   array("name" => "Willington Mhlanga", "email" => "mhlangawillington@yahoo.com"),
// );
//
// $subject  = "The Test Mail";
// $html     = "<h3>Shit just got real my Niga</h3>";
// $html     .= "<p>You are kindly advice to allow this email as a test email</p>";
// $html     .= "<a href=\"www.example.com\" class=\"btn btn-info\">click to <b>accept</b></a>";
// $from     = G_FROM;
// if($mailer->mail($to, $subject, $html, $from)){
//   echo "success";
// }
