<?php
require 'phpmailer.php';

function user_feedback($to, $data = array())
{
  global $social_media;
  $output = '';
  $output .= '<h4 style=""><span style="font-weight: normal;">Hello</span> ' . $to . ',</h4>';
  $output .= '<p>Thank you for giving us your feedback, we will get in touch with you shortly if there is a need to do so </p>';

  $output .= '<h4>The Following message has been captured :</h4>';
  $output .= '<p>' . $data['message'] . '</p>';
  // $output .= '<br>';
  // $output .= '<p>Let\'s catch up on &nbsp; | &nbsp; ';
  foreach ($social_media as $key => $social) :
    // $output .= '<a href="' . $social['link'] . '">' . $social['name'] . '</a> &emsp;';
  endforeach;
  $output .= '<br>';
  $output .= '<p>Regards,</p>';
  $output .= $_ENV['MAIL_USER'];
  $output .= '<br>';

  return $output;
}

function user_feedback_notifify($to, $data = array())
{

  $output = '';
  $output .= '<h4 style=""><span style="font-weight: normal;">Hello</span> ' . $to . ',</h4>';
  $output .= '<p>There is a new feedback message from your website</p>';

  $output .= '<h4>The Following information has been captured :</h4>';

  $output .= '<table style="border: 1px solid #aaa; text-align/: center; border-radius: 7px; padding: 15px;"><tbody>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Name</th>';
  $output .= '<td style="padding: 3px;">' . $data['name'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Email</th>';
  $output .= '<td style="padding: 3px;">' . $data['email'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Message</th>';
  $output .= '<td style="padding: 3px;">' . $data['message'] . '</td>';
  $output .= '<tr>';

  $output .= '</tbody></table>';
  $output .= '<br>';

  return $output;
}

function quote_notification ($data) {
  global $social_media;
  ob_start();
?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= PROJECT_LOGO ?>">
    <link rel="canonical" href="<?= $_SERVER['REQUEST_URI'] ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <body>
    <div style="background: white; padding: 25px;">

      <article>
        <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
          <center>
            <table style="border-collapse:collapse;border:none;">
              <tbody>
                <tr style="padding: 5px;">
                  <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
                      <span style="font-size: 14.0pt; line-height: 107%;">Hello <?= ((!isset($data['name']) && !empty($data['name'])) ? ' ' . $data['name'] : ((isset($data['last_name']) && !empty($data['last_name']))? $data['last_name']: '')) ?>,</span>
                    </p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                    <?php if (isset($data['code'])) : ?>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> Here is your Parcel Tracking Number </span></p>
                      <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:25px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <b><?= $data['code'] ?></b> &nbsp;</span></p>
                      <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> Use the link below to track your parcel: &nbsp;</span></p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'>  <?= $data['code_link'] ?> </span></p>
                    <?php endif; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </p>
      </article>

      <article>
        <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
          <center>
            <table style="border-collapse:collapse;border:none;">
              <tbody>
                <tr style="padding: 5px;">
                  <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'>You can contact us this email: <a href="<?= $_ENV['MAIL_MAIL'] ?>"><?= $_ENV['MAIL_MAIL'] ?></a>&nbsp;</span></p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
                      <span style='font-family:"Arial",sans-serif;color:#222222;'>Or reach us from social media: <br> </span>

                      <?php foreach ($social_media as $key => $social) : ?>
                        <a class="" style="font-size: .9rem; padding-right: 7px" href="<?= $social['link'] ?>" target="_blank"> <?= $social['name'] ?> </a>
                      <?php endforeach; ?>

                    </p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'> <span style='font-family:"Arial",sans-serif;color:#222222'>Thanks,<br><?= PROJECT_TITLE ?> </span> </p>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </p>
      </article>

      <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:12px;font-family:"Calibri",sans-serif;text-align:center;'>
        <span style="color:#262626;">Please note that this is an automated email. Emails sent to this address may not be attended.</span>
      </p>
      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:12px;font-family:"Calibri",sans-serif;text-align:center;'>
        <strong><span style="color:#262626;"><a href="<?= SERVER_HOST ?>" target="_blank"><span style="color:#262626;"><?= PROJECT_TITLE ?></span></a></span></strong>
        <span style="color:#262626;">&nbsp; &nbsp;| &nbsp; Powered by&nbsp;</span><span style="color:#ED7D31;"><a href="http://tda.tralon.co.za/" target="_blank"><span style="color:#ED7D31;">TDA</span></a></span>
        <span style="color:#262626;">.</span>
      </p>

    </div>
  </body>

  </html>

<?php
  $mail = ob_get_clean();

  return $mail;
}

function event_notification($data, $altdata = array())
{
  global $social_media;
  ob_start();
?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= PROJECT_LOGO ?>">
    <link rel="canonical" href="<?= $_SERVER['REQUEST_URI'] ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <body>
    <div style="background: white; padding: 25px;">

      <article>
        <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
          <center>
            <table style="border-collapse:collapse;border:none;">
              <tbody>
                <tr style="padding: 5px;">
                  <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
                      <span style="font-size: 14.0pt; line-height: 107%;">Hello <?= ((isset($data['name']) && !empty($data['name'])) ? ' ' . $data['name'] : ((isset($data['last_name']) && !empty($data['last_name']))? $data['last_name']: '')) ?>,</span>
                    </p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                    <?php if (isset($data['message_text_1']) && !empty($data['message_text_1'])) : ?>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <?= $data['message_text_1'] ?> &nbsp;</span></p>
                    <?php endif; ?>

                    <?php if (isset($data['message_text_2']) && !empty($data['message_text_2'])) : ?>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <?= $data['message_text_2'] ?> &nbsp;</span></p>
                    <?php endif; ?>

                    <?php if (isset($data['message_text_3']) && !empty($data['message_text_3'])) : ?>
                      <p style='text-align: center; margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <?= $data['message_text_3'] ?> &nbsp;</span></p>
                    <?php endif; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </p>
      </article>

      <?php if ( isset($data['message_type']) && $data['message_type'] == 'admin' && (!isset($data['message_notif']))) : ?>
        <article style="background: #e2dfdf; padding: 25px; border-radius: 25px; border: 1px solid #ddd;">
  
          <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
            <center>
              <table style="border-collapse:collapse;border:none;">
                <tbody>
                  <tr style="padding: 5px 0;">
                    <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                      <table style="border-collapse:collapse;border:none;">
                        <tbody>
                          <?php if ( isset($data['name']) && !empty($data['name'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Name</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['name'] ?> </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['last_name']) && !empty($data['last_name'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Last Name</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['last_name'] ?> </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['email']) && !empty($data['email'])) : ?>
                            <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Email</p>
                              </td>
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['email'] ?> </p>
                              </td>
                            </tr>
                          <?php endif; ?>
                          
                          <?php if ( isset($data['contact']) && !empty($data['contact'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Contact Number</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['contact'] ?></p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if (isset($data['alt_name']) && !empty($data['alt_name'])): ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                               Other Name
                              </p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                <?= $data['alt_name'] ?>
                              </p>
                            </td>
                          </tr>
                          <?php endif; ?>
                          
                          <?php if (isset($data['alt_last_name']) && !empty($data['alt_last_name'])): ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                Other Last Name
                              </p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p
                                style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                <?= $data['alt_last_name'] ?>
                              </p>
                            </td>
                          </tr>
                          <?php endif; ?>
                          
                          <?php if (isset($data['alt_email']) && !empty(isset($data['alt_email']))): ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                Other Email
                              </p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                <?= $data['alt_email'] ?>
                              </p>
                            </td>
                          </tr>
                          <?php endif; ?>
                          
                          <?php if (isset($data['alt_contact']) && !empty($data['alt_contact'])): ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                Other Contact Number</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>
                                <?= $data['alt_contact'] ?>
                              </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['company']) && !empty($data['company'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Company Name</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['company'] ?> </p>
                            </td>
                          </tr>
                          <?php endif; ?>
                          
                          <?php if ( isset($data['event_type']) && !empty($data['event_type'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> Type</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['event_type'] ?> </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['dell_address']) && !empty($data['description'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> Description</p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['description'] ?> </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['coll_address']) && !empty($data['coll_address'])) : ?>
                            <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Collection Address</p>
                              </td>
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['coll_address'] ?> </p>
                              </td>
                            </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['dell_address']) && !empty($data['dell_address'])) : ?>
                            <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Delivery Address</p>
                              </td>
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['dell_address'] ?> </p>
                              </td>
                            </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['event_town']) && !empty($data['event_town'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> 
                                Town 
                              </p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> 
                                <?= $data['event_town'] ?> 
                              </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['event_city']) && !empty($data['event_city'])) : ?>
                            <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>City</p>
                              </td>
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['event_city'] ?> </p>
                              </td>
                            </tr>
                          <?php endif; ?>
  
                          <?php if ( isset($data['event_country']) && !empty($data['event_country'])) : ?>
                            <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'>Country</p>
                              </td>
                              <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['event_country'] ?> </p>
                              </td>
                            </tr>
                          <?php endif; ?>
                          
                          <?php if ( isset($data['event_date']) && !empty($data['event_date'])) : ?>
                          <tr style="border-bottom: 1px solid #eee; padding: 12px 0;">
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> Date </p>
                            </td>
                            <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                              <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['event_date'] ?> </p>
                            </td>
                          </tr>
                          <?php endif; ?>
  
                        </tbody>
                      </table>
                    </td>
                  </tr>
  
                  <?php if ( isset($data['message']) && !empty($data['message'])) : ?>
                  <tr>
                    <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>
                    <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'>
                      <span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>  The following message was submitted:</span>
                    </p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:-5.65pt;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'> <?= $data['message'] ?> </p>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
  
            </center>
          </p>
  
        </article>
      <?php endif; ?>

      <?php if ( isset($data['message_type']) && $data['message_type'] != 'admin') : ?>
        <article>
          <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
            <center>
              <table style="border-collapse:collapse;border:none;">
                <tbody>
                  <tr style="padding: 5px;">
                    <td style="width: 225.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'>If you don&rsquo;t hear from us within 48 hours, you may email us on: <a href="<?= $_ENV['MAIL_MAIL'] ?>"><?= $_ENV['MAIL_MAIL'] ?></a>&nbsp;</span></p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
                        <span style='font-family:"Arial",sans-serif;color:#222222;'>Or reach us from social media: <br> </span>
  
                        <?php foreach ($social_media as $key => $social) : ?>
                          <a class="" style="font-size: .9rem; padding-right: 7px" href="<?= $social['link'] ?>" target="_blank"> <?= $social['name'] ?> </a>
                        <?php endforeach; ?>
  
                      </p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'> <span style='font-family:"Arial",sans-serif;color:#222222'>Thanks,<br><?= PROJECT_TITLE ?> </span> </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
          </p>
        </article>
      <?php endif; ?>

      <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:12px;font-family:"Calibri",sans-serif;text-align:center;'>
        <span style="color:#262626;">Please note that this is an automated email. Emails sent to this address may not be attended.</span>
      </p>
      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:12px;font-family:"Calibri",sans-serif;text-align:center;'>
        <strong><span style="color:#262626;"><a href="<?= SERVER_HOST ?>" target="_blank"><span style="color:#262626;"><?= PROJECT_TITLE ?></span></a></span></strong>
        <span style="color:#262626;">&nbsp; &nbsp;| &nbsp; Powered by&nbsp;</span><span style="color:#ED7D31;"><a href="http://tda.tralon.co.za/" target="_blank"><span style="color:#ED7D31;">TDA</span></a></span>
        <span style="color:#262626;">.</span>
      </p>

    </div>
  </body>
  </html>

<?php
  $mail = ob_get_clean();

  return $mail;
}

function user_event_notifify($to, $data = array())
{

  $output = '';
  $output .= '<h4 style=""><span style="font-weight: normal;">Hello</span> ' . $to . ',</h4>';
  $output .= '<p>There is a new event booking from your website</p>';

  $output .= '<h4>The Following information has been captured :</h4>';

  $output .= '<table style="border: 1px solid #aaa; text-align/: center; border-radius: 7px; padding: 15px;"><tbody>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Name</th>';
  $output .= '<td style="padding: 3px;">' . $data['name'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Email</th>';
  $output .= '<td style="padding: 3px;">' . $data['email'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Address</th>';
  $output .= '<td style="padding: 3px;">' . $data['address'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Description</th>';
  $output .= '<td style="padding: 3px;">' . $data['description'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Message</th>';
  $output .= '<td style="padding: 3px;">' . $data['message'] . '</td>';
  $output .= '<tr>';

  $output .= '<tr style="border: 1px solid #aaa; padding: 3px;">';
  $output .= '<th style="padding: 3px;">Date</th>';
  $output .= '<td style="padding: 3px;">' . $data['event_date'] . '</td>';
  $output .= '<tr>';

  $output .= '</tbody></table>';
  $output .= '<br>';

  return $output;
}

function email_subscription($to, $data = array())
{
  global $social_media;
  $social_len = count($social_media);
  $count = 0;

?>

  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'>&nbsp;</p>
  <div>
    <center style="background:#F2F2F2; border-radius: 25px">
      <table style="background:#F2F2F2;border-collapse:collapse;border:none;">
        <tbody>
          <tr>
            <td style="width: 450.8pt;padding: 0cm 5.4pt;vertical-align: top;">
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;">Dear <?= $to ?>,</span></p>
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;">Thanks for subscribing to our newsletter. We hope you enjoy.</span></p>
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
              
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>
                <span style="color:black;">Please connect on </span>
                <?php foreach ($social_media as $key => $social) : ?>
                  <?php $count ++ ?>
                  <span><a href="<?= $social['link'] ?>"><span style="color:#44546A;"> <?= ($count == $social_len) ? 'and':'' ?> &nbsp; <?= $key ?> </span> </a></span> &emsp;
                <?php endforeach; ?>
                and don&apos;t hesitate to get in touch!
              </p>
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
              <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;">Regards,</span><br><span style="color:black;"><?= PROJECT_TITLE ?><br>&nbsp;</span></p>
            </td>
          </tr>
        </tbody>
      </table>
    </center>
  </div>
  <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;border:none;border-bottom:solid #A6A6A6 1.0pt;padding:0cm 0cm 1.0pt 0cm;'>
    <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;border:none;padding:0cm;'>&nbsp;</p>
  </div>
  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:105%;text-align:center;background:white;'><span style="font-size:12px;line-height:105%;color:#44546A;">This message was sent to &nbsp;&nbsp;</span><span style="color:black;"><a href="mailto:<?= $data['email'] ?>" target="_blank"><span style="font-size:12px;line-height:105%;color:#44546A;"><?= $data['email'] ?> &nbsp;</span></a></span><span style="font-size:12px;line-height:105%;color:#44546A;">&nbsp;from our subscription emailing list.<br>&nbsp;If you would like to unsubscribe, click&nbsp;</span><span style="color:black;"><a href="<?= ((isset($data['url_reset']) && !empty($data['url_reset'])) ? $data['url_reset'] : '') ?>" target="_blank"><span style="font-size:12px;line-height:105%;color:#44546A;">Unsubscribe&nbsp;</span></a></span><span style="font-size:12px;line-height:105%;color:#44546A;">.&nbsp;</span></p>
  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'>&nbsp;</p>
<?php
  $mail = ob_get_clean();

  return $mail;
}

function email_subscription_notify($to, $data = array())
{
  $output = '';
  $output .= '<h4 style=""><span style="font-weight: normal;">Hello</span> ' . $to . ',</h4>';
  $output .= '<p>There is a new <b>email subscription</b> to <b>' . PROJECT_TITLE . '\'s</b> newsletter. </p>';

  $output .= '<h4>The Following information has been captured :</h4>';
  $output .= '<p>Full Name &emsp; | ' . ((isset($data['name'])) ? $data['name'] : '') . '</p>';
  $output .= '<p>User Email &emsp; | ' . ((isset($data['email'])) ? $data['email'] : '') . '</p>';
  $output .= '<br>';

  return $output;
}

function confirmation_mail($to, $data = array())
{
  // style
  $output = '';
  $output .= '<style media="screen">';
  $output .= '.btn_ {text-decoration: none;cursor: pointer;display: inline-block;margin: 0;height: auto;border: 1px solid #40e0d0;vertical-align: middle;-webkit-appearance: none;color: inherit;background-color: #40e0d0;}';
  $output .= '.btn_:hover {text-decoration: none;background-color: #2BBBAD;color: #fff}';
  $output .= '.btn_:focus {outline: none;border-color: #00695c;box-shadow: 0 0 0 3px #ddd;}';
  $output .= '::-moz-focus-inner {border: 0;padding: 0;}';
  $output .= '.btn-primary_ {color: #ddd;background-color: #01baa3 /* #00695c*/;border-radius: 7px;}';
  $output .= '.btn-primary_:hover {box-shadow: inset 0 0 0 20rem var(--darken-1);}';
  $output .= '.btn-primary_:active {box-shadow: inset 0 0 0 20rem var(--darken-2),  inset 0 3px 4px 0 var(--darken-3),  0 0 1px var(--darken-2);}';
  $output .= '.btn-primary_:focus{background-color: #00695c;outline: none;border-color: #00695c;box-shadow: 0 0 0 3px #ddd;}';
  $output .= '';
  $output .= '</style>';

  // body content
  $output .= '<div>';
  $output .= '<center>';
  $output .= '<h4>Hello ' . $to . '</h4>';
  $output .= '<p>' . $data["message"] . '</p>';
  $output .= '<h3>';
  $output .= '<a href="' . $data['url'] . '" class="btn_ btn-primary_" target="_blank" style="color: #777777; border: 1px solid #ddd; padding: 3px 25px; border-radius: 7px;">';
  $output .= '<span type="" name="button">Confirm</span>';
  $output .= '</a> ';
  $output .= '</h3>';
  $output .= '</center>';
  $output .= '</div>';
  $output .= '';

  return $output;
}

function general_mail($data = array())
{
  global $social_media;
  ob_start();

  $req_res = $data['mail_data'];

?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= PROJECT_LOGO ?>">
    <link rel="canonical" href="<?= $_SERVER['REQUEST_URI'] ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <body>

    <div style="background: white; padding: 25px;">

      <p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center">
        <span style="font-size: 14.0pt; line-height: 107%;">Dear<?= ((!empty($data['name'])) ? ' ' . ucfirst($data['name']) : '') ?>,</span>
      </p>
      <p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center">&nbsp;</p>

      <div align="center">
        <?= PAGE_SETTINGS['setting_email_header']  ?>
      </div>

      <p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center">&nbsp;</p>

      <article style="background: #e2dfdf; padding: 25px; border-radius: 25px; border: 1px solid #ddd;">
        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
          <strong><span style='font-size:22px;font-family:"Lato",serif;color:#44546A;'> <?= ((!empty($data['title']) && $data['title'] != '') ? html_entity_decode($data['title']) : '') ?> </span></strong>
        </p>
        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'>
          <?php if (isset($data['date']) && $data['date'] != '') : ?>
            <em><span style='font-size:13px;font-family:"Segoe UI",sans-serif;color:#44546A;'>Published on</span></em>
            <em><span style='font-size:13px;font-family:"Segoe UI",sans-serif;color:#212529;'>&nbsp; &nbsp;</span></em>
            <span style='font-size:13px;font-family:"Segoe UI",sans-serif;color:#C55A11;'>
              <a href="" target="_blank">
                <span style="color:#C55A11;"> <?= $data['date'] ?> </span>
              </a>&nbsp;
            </span>
          <?php endif; ?>
          <span style='font-size:13px;font-family:"Segoe UI",sans-serif;color:#44546A;'>&nbsp; | &nbsp; <em>by</em>&nbsp; &nbsp; <strong> <?= PROJECT_TITLE ?> <?= ($data['author'] != '') ? ', ' . $data['author'] : '' ?> </strong> </span>
        </p>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'>
          <span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#212529;'>
            <?php if (isset($data['image']) && !empty($data['image'])) : ?>
              <img style="border: 2px solid #ddd; padding 3px; border-radius: 25px;" height="350" src="<?= $data['image'] ?>" alt="Article image">
            <?php endif; ?>
            <div class="" align="center">
              <?php if (isset($req_res['article_source']) && $req_res['article_source'] != '') : ?>
                <small class="text-muted"> <?= $req_res['article_source'] ?></small>
              <?php endif; ?>
            </div>
          </span>
        </p>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
        <?php if (!empty($data['message'])) : ?>
          <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
            <!-- article content -->
            <center>
              <table>
                <tbody>
                  <tr>
                    <td>
                      <?= $data['message'] ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
          </p>
        <?php endif; ?>

        <?php if (isset($data["url_info"]) && !empty($data["url_info"])) : ?>
          <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'>
            <span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#C55A11;'>
              <a href="<?= ((isset($data["url_info"]["url_link"])) ? $data["url_info"]["url_link"] : "") ?>">
                <span style="color:#C55A11;"><?= ((isset($data["url_info"]["url_title"])) ? $data["url_info"]["url_title"] : 'Link') ?> </span>
              </a>
            </span>
          </p>
        <?php endif; ?>

        <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

        <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
          <span style="color:#44546A;">Follow us on social media:</span>
        </p>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
          <?php foreach ($social_media as $key => $social) : ?>
            <span><a href="<?= $social['link'] ?>"><span style="color:#44546A;"> <img height="24" width="24" src="<?= $social['lnk2'] ?>" style="height: 24px; width: 24px;" alt=""> &nbsp; <?= ucfirst($key) ?> </span> </a></span> &emsp;
          <?php endforeach; ?>
        </p>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
        <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;border-top:none;border-left:none;border-bottom:dotted #AEAAAA 1.0pt;padding:0cm 4.0pt 1.0pt 0cm;'>
          <?= PAGE_SETTINGS['setting_email_footer'] ?>
        </div>

        <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
          <span style="font-size:12px;line-height:107%;color:#44546A;">This message was sent to &nbsp;
            <a href="mailto:<?= $data['email'] ?>" target="_blank" rel="noopener"><span style="color:#44546A;"> <?= $data['email'] ?> &nbsp;</span></a>
            from our subscription emailing list.<br> If you would like to unsubscribe, click
            <a href="<?= ((isset($data['url_info']['url_reset']) && !empty($data['url_info']['url_reset'])) ? $data['url_info']['url_reset'] : '') ?>" target="_blank"><span style="color:#44546A;">Unsubscribe&nbsp;</span></a>.
          </span>
        </p>

      </article>

      <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
        <strong><span style="color:#262626;"><a href="<?= SERVER_HOST ?>" target="_blank"><span style="color:#262626;"><?= PROJECT_TITLE ?></span></a></span></strong>
        <span style="color:#262626;">&nbsp; &nbsp;| &nbsp; Powered by&nbsp;</span><span style="color:#ED7D31;"><a href="http://tda.tralon.co.za/" target="_blank"><span style="color:#ED7D31;">TDA</span></a></span>
        <span style="color:#262626;">.</span>
      </p>

    </div>

  </body>
  </html>

<?php
  $mail = ob_get_clean();

  return $mail;
}

function main_general_mail($data = array())
{
  global $social_media;
  ob_start();

  ?>

    <!DOCTYPE html>
    <html lang="en" dir="ltr">

    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
      <link rel="shortcut icon" href="<?= PROJECT_LOGO ?>">
      <link rel="canonical" href="<?= $_SERVER['REQUEST_URI'] ?>">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>

      <div style="background: white; padding: 25px;">

        <p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center">
          <span style="font-size: 14.0pt; line-height: 107%;">Dear<?=((!empty($data['name'])) ? ' ' . ucfirst($data['name']) : '') ?>,</span>
        </p>
        <p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center">&nbsp;</p>

        <p style='text-align: center; margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
        <?php if (isset($data['message_text_1'])) : ?>
          <p style='text-align: center; margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <?= $data['message_text_1'] ?> &nbsp;</span></p>
        <?php endif; ?>

        <?php if (isset($data['message_text_2']) && !empty($data['message_text_2'])) : ?>
          <p style='text-align: center; margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <?= $data['message_text_2'] ?> &nbsp;</span></p>
        <?php endif; ?>

        <p style='text-align: center; margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
        <?php if (isset($data['message_text_3']) && !empty(isset($data['message_text_3']))) : ?>
          <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;color:#222222'> <?= $data['message_text_3'] ?> &nbsp;</span></p>
        <?php endif; ?>

        <?php if (!empty($data['message'])): ?>
          <p style='margin-right:-19.25pt;margin-left:-19.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:normal;text-align:center;'>
            <center>
              <table>
                <tbody>
                  <tr>
                    <td>
                      <?= $data['message'] ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
          </p>
        <?php endif; ?>

        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
        <center>
          <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;border-top:none;border-left:none;border-bottom:dotted #AEAAAA 1.0pt;padding:0cm 4.0pt 1.0pt 0cm;'>
          <?= PAGE_SETTINGS['setting_email_footer'] ?>
        </div>
        </center>

        <p style="text-align: center; margin: 0cm 0cm 8pt; line-height: 107%; font-size: 11pt; font-family: Calibri, sans-serif;" align="center">&nbsp;</p>

        <article style="background: #e2dfdf; padding: 25px; border-radius: 25px; border: 1px solid #ddd;">
          <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

          <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
            <span style="color:#44546A;">Follow us on social media:</span>
          </p>

          <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
          <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'>
            <?php foreach ($social_media as $key => $social): ?>
                <span><a href="<?= $social['link'] ?>"><span style="color:#44546A;"> <img height="24" width="24" src="<?= $social['lnk2'] ?>" style="height: 24px; width: 24px;" alt=""> &nbsp; <?= ucfirst($key) ?> </span> </a></span> &emsp;
              <?php endforeach; ?>
          </p>

          <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

          <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
            <span style="font-size:12px;line-height:107%;color:#44546A;">This message was sent to &nbsp;
              <a href="mailto:<?= $data['email'] ?>" target="_blank" rel="noopener"><span style="color:#44546A;"> <?= $data['email'] ?> &nbsp;</span></a>.
            </span>
          </p>

        </article>

        <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'><span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#555555;'>&nbsp;</span></p>

        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
          <strong><span style="color:#262626;"><a href="<?= SERVER_HOST ?>" target="_blank"><span style="color:#262626;"><?= PROJECT_TITLE ?></span></a></span></strong>
          <span style="color:#262626;">&nbsp; &nbsp;| &nbsp; Powered by&nbsp;</span><span style="color:#ED7D31;"><a href="http://tda.tralon.co.za/" target="_blank"><span style="color:#ED7D31;">TDA</span></a></span>
          <span style="color:#262626;">.</span>
        </p>

      </div>

    </body>
    </html>
  <?php
  $mail = ob_get_clean();

  return $mail;
}


// gegistry email
function email_registry($to, $data = array())
{
  ob_start();

?>

<!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= PROJECT_LOGO ?>">
    <link rel="canonical" href="<?= $_SERVER['REQUEST_URI'] ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <body>

    <div style="background: white; padding: 25px;">

      <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'>&nbsp;</p>
      <div>
        <center style="background:#F2F2F2; border-radius: 25px">
          <table style="background:#F2F2F2;border-collapse:collapse;border:none;">
            <tbody>
              <tr>
                <td style="width: 450.8pt;padding: 0cm 5.4pt;vertical-align: top;">
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;">Dear <?= $to ?>,</span></p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black; font-weight: bold;">You have received the following message from the Office Registrar:</span></p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;"> <?= (isset($data['msg_data']) && !empty($data['msg_data'])) ? $data['msg_data'] : '' ?> </span></p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;"> <?= (isset($data['message']) && !empty($data['message'])) ? $data['message'] : '' ?> </span></p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <?php if (isset($data["url_info"]) && !empty($data["url_info"])) : ?>
                    <p style='margin-right:-11.25pt;margin-left:-11.25pt;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;text-align:center;'>
                      <span style='font-size:16px;font-family:"Segoe UI",sans-serif;color:#C55A11;'>
                        <a href="<?= ((isset($data["url_info"]["url_link"])) ? $data["url_info"]["url_link"] : "") ?>">
                          <span style="color:#C55A11;"><?= ((isset($data["url_info"]["url_title"])) ? $data["url_info"]["url_title"] : 'Link') ?> </span>
                        </a>
                      </span>
                    </p>
                  <?php endif; ?>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'>&nbsp;</p>
                  <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:0cm;line-height:normal;'><span style="color:black;">Kind Regards,</span><br><span style="color:black;"> <?= PROJECT_TITLE ?> <br>&nbsp;</span></p>
                </td>
              </tr>
            </tbody>
          </table>
        </center>
      </div>
      <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;border:none;border-bottom:solid #A6A6A6 1.0pt;padding:0cm 0cm 1.0pt 0cm;'>
        <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;border:none;padding:0cm;'>&nbsp;</p>
      </div>
      <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:105%;text-align:center;background:white;'><span style="font-size:12px;line-height:105%;color:#44546A;">This message was sent to &nbsp;&nbsp;</span><span style="color:black;"><a href="mailto:<?= $data['email'] ?>" target="_blank"><span style="font-size:12px;line-height:105%;color:#44546A;"><?= $data['email'] ?> &nbsp;</span></a></span><span style="font-size:12px;line-height:105%;color:#44546A;">&nbsp;from our subscription emailing list.<br>&nbsp;If you would like to unsubscribe, click&nbsp;</span><span style="color:black;"><a href="<?= ((isset($data['url_reset']) && !empty($data['url_reset'])) ? $data['url_reset'] : '') ?>" target="_blank"><span style="font-size:12px;line-height:105%;color:#44546A;">Unsubscribe&nbsp;</span></a></span><span style="font-size:12px;line-height:105%;color:#44546A;">.&nbsp;</span></p>
      <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'>&nbsp;</p>
    </div>
    
  </body>
  </html>
<?php
  $mail = ob_get_clean();

  return $mail;
}

// notification email
function account_notification_mail($data)
{
  ob_start();
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= PROJECT_LOGO ?>">
    <link rel="canonical" href="<?= host_url('') ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <style>
    @font-face {
      font-family: Myfont;
      src: url('http://tda.tralon.co.za/fonts/tralon-Regular.ttf');
    }
  </style>

  <body>

    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;line-height:107%;font-family:Myfont;">&nbsp;</span></p>
    <div align="center" style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
      <p><br></p>
      <center>
        <table style="width:198.0pt;border-collapse:collapse;border:none;">
          <tbody>
            <tr>
              <td style="width: 99pt;padding: 0cm 3pt;height: 30.0pt;vertical-align: top;">
                <!-- <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;background-color:white;'>
                  <img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANIAAAA9CAYAAADYizcVAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAAAyNaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzE0OCA3OS4xNjQwMzYsIDIwMTkvMDgvMTMtMDE6MDY6NTcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDIzLTA3LTE2VDA2OjU2OjI0KzAyOjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIzLTA3LTE2VDIxOjAzOjUwKzAyOjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMy0wNy0xNlQyMTowMzo1MCswMjowMCIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9InNSR0IgSUVDNjE5NjYtMi4xIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5M2I4ZTFiNi02N2QxLWEzNDgtYmM3YS1lODljNWVmZDQ4OGYiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDoyMzE0YzIwNC02NzVkLWNkNDItOTUyMi0xMTI5Y2VmM2Q3MDEiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3NWFkNmFmNy1hZDY0LWI2NDYtODZmNi00NmE2NjlmNWY4ZDIiPiA8cGhvdG9zaG9wOlRleHRMYXllcnM+IDxyZGY6QmFnPiA8cmRmOmxpIHBob3Rvc2hvcDpMYXllck5hbWU9IkNIQVVLRSBCIEFUVE9STkVZUyIgcGhvdG9zaG9wOkxheWVyVGV4dD0iQ0hBVUtFIEIgQVRUT1JORVlTIi8+IDxyZGY6bGkgcGhvdG9zaG9wOkxheWVyTmFtZT0iTk9UQVJJRVMgJmFtcDsgQ09OVkVZQU5DRVJTIiBwaG90b3Nob3A6TGF5ZXJUZXh0PSJOT1RBUklFUyAmYW1wOyBDT05WRVlBTkNFUlMiLz4gPHJkZjpsaSBwaG90b3Nob3A6TGF5ZXJOYW1lPSJDYXNlQm94IiBwaG90b3Nob3A6TGF5ZXJUZXh0PSJDYXNlQm94Ii8+IDxyZGY6bGkgcGhvdG9zaG9wOkxheWVyTmFtZT0iQ2FzZUJveCIgcGhvdG9zaG9wOkxheWVyVGV4dD0iQ2FzZUJveCIvPiA8cmRmOmxpIHBob3Rvc2hvcDpMYXllck5hbWU9IkNIQVVLRSBCIEFUVE9STkVZUyIgcGhvdG9zaG9wOkxheWVyVGV4dD0iQ0hBVUtFIEIgQVRUT1JORVlTIi8+IDxyZGY6bGkgcGhvdG9zaG9wOkxheWVyTmFtZT0iTk9UQVJJRVMgJmFtcDsgQ09OVkVZQU5DRVJTIiBwaG90b3Nob3A6TGF5ZXJUZXh0PSJOT1RBUklFUyAmYW1wOyBDT05WRVlBTkNFUlMiLz4gPC9yZGY6QmFnPiA8L3Bob3Rvc2hvcDpUZXh0TGF5ZXJzPiA8cGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8cmRmOkJhZz4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6MjJkY2RlN2QtZjUwZC04NjQzLWFkYzItMDJjMTA1MTE1NTI3PC9yZGY6bGk+IDwvcmRmOkJhZz4gPC9waG90b3Nob3A6RG9jdW1lbnRBbmNlc3RvcnM+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNyZWF0ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NzVhZDZhZjctYWQ2NC1iNjQ2LTg2ZjYtNDZhNjY5ZjVmOGQyIiBzdEV2dDp3aGVuPSIyMDIzLTA3LTE2VDA2OjU2OjI0KzAyOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjM2YTYzMDY2LTgxMjctYmI0My05OTI4LTRmZDBlMzVlYzAwOCIgc3RFdnQ6d2hlbj0iMjAyMy0wNy0xNlQwNzowMzowMSswMjowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIDIxLjAgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDoxNzM0YzQ4Ni1hMWU1LTA5NDItODdjMC00MWI0OTUzN2YwNzQiIHN0RXZ0OndoZW49IjIwMjMtMDctMTZUMjE6MDM6NTArMDI6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpw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'/>
                </p> -->
              </td>
            </tr>
          </tbody>
        </table>

        <table style="border-collapse:collapse;border:none;">
          <tbody>
            <tr>
              <td style="width: 450.8pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                <div style="background:#efefef;width:100%;padding:15px">
                  <!-- welcome message -->
                  <?php if (isset($data['msg_welcome']) && !empty($data['msg_welcome'])) : ?>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:24px;line-height:107%;font-family:"Segoe UI",sans-serif;'><?= $data['msg_welcome'] ?></span></p>
                  <?php endif; ?>
                  <!-- into message -->
                  <?php if (isset($data['msg_intro']) && !empty($data['msg_intro'])) : ?>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Segoe UI",sans-serif;'><?= $data['msg_intro'] ?></span></p>
                  <?php endif; ?>
                  <!-- body message -->
                  <?php if (isset($data['msg_top_body']) && !empty($data['msg_top_body'])) : ?>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Segoe UI",sans-serif;'><?= $data['msg_top_body'] ?></span></p>
                  <?php endif; ?>

                  <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'>&nbsp;</span></p>
                  <?php if (isset($data['url_info']) && !empty($data['url_info'])) : ?>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>
                      <?php if (isset($data['url_info']['url_link']) && !empty($data['url_info']['url_link'])) : ?>
                        <span style='font-family:"Segoe UI",sans-serif;'>
                          <a href="<?= ((isset($data['url_info']['url_link'])) ? $data['url_info']['url_link'] : '') ?>" style="background:#344767;text-decoration: none; padding: 5px 25px; border-radius: 12px;">
                            <span style="font-size:15px;color:white;border:solid #344767 1.0pt;"><?= ((isset($data['url_info']['url_message'])) ? $data['url_info']['url_message'] : '') ?></span>
                          </a>
                        </span>
                      <?php endif; ?>
                    </p>
                  <?php endif; ?>
                  <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                </div>

                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Segoe UI",sans-serif;'>&nbsp;</span></p>
                <?php if (isset($data['msg_paragraph_1']) && !empty($data['msg_paragraph_1'])) : ?>
                  <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'><?= $data['msg_paragraph_1'] ?></span></p>
                <?php endif; ?>

                <?php if (isset($data['msg_paragraph_2']) && !empty($data['msg_paragraph_2'])) : ?>
                  <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'><?= $data['msg_paragraph_2'] ?></span></p>
                <?php endif; ?>

                <?php if (isset($data['msg_paragraph_3']) && !empty($data['msg_paragraph_3'])) : ?>
                  <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'><?= $data['msg_paragraph_3'] ?></span></p>
                <?php endif; ?>

                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'>&nbsp;</span></p>
              </td>
            </tr>
          </tbody>
        </table>

      </center>

      <article style="background:#FFF;">
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'>&nbsp;</span></p>
        <span style='font-size:12px;line-height:107%;font-family:"Segoe UI",sans-serif;'>This email was sent to </span>
        <a href="mailto:<?= ((isset($data['email']) && !empty($data['email'])) ? $data['email'] : '') ?>" target="_blank">
          <span style='font-size:12px;line-height:107%;font-family:"Arial",sans-serif;color:000;'><strong><?= ((isset($data['email']) && !empty($data['email'])) ? $data['email'] : '') ?></strong></span>
        </a>
        <span>, which is associated with a <?= PROJECT_TITLE ?> account.</span>
        </p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Segoe UI",sans-serif;'>&nbsp;</span></p>
      </article>
      <center>
        <div style='background:#344767;margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;border:none;border-top:solid #AEAAAA 1.0pt;padding:1.0pt 0cm 0cm 0cm;'>
          <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'><span style='font-size:12px;line-height:107%;font-family:"Arial",sans-serif;color:#ccc;'>Please do not reply to this message. Emails sent to this address will not be attended to.</span></p>
          <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;border:none;padding:0cm; color:#ccc;'><span style='font-size:11px;line-height:107%;font-family:"Segoe UI",sans-serif,color:#ccc;'>&copy; <?= date('Y') ?> <?= PROJECT_TITLE ?> (Pty) Ltd, All Rights Reserved<br>&nbsp;</span></p>
        </div>
      </center>
    </div>

  </body>

  </html>

<?php
  $mail = ob_get_clean();

  return $mail;
}