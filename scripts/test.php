<?php

$image_modify_paths = array('', 'square', 'rect');

// echo array_key_exists($image_modify_paths[3], $image_modify_paths);

if (empty($image_modify_paths[0])) {
    // echo 'string';
}


$social_media = array(
    'facebook' => array(
        'name' => 'facebook',
        'user' => '',
        'font' => 'fab fa-facebook',
        'link' => 'https://www.facebook.com/leadxtragroup',
        'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/facebook.png',
    ),
    'intagram' => array(
        'name' => 'instagram',
        'user' => '',
        'font' => 'fab fa-instagram',
        'link' => 'https://www.instagram.com/leadxtragroup/',
        'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/instagram.png',
    ),
    // 'linkedin'  => array(
    //   'name' => 'linkedin',
    //   'user' => '',
    //   'font' => 'fa-brands fa-linkedin-in',
    //   'link' => '',
    //   'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/linkedin.png',
    // ),
    'twitter' => array(
        'name' => 'twitter',
        'user' => 'leadxtragroup',
        'font' => 'fab fa-twitter',
        'link' => 'https://twitter.com/leadxtragroup',
        'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/twitter.png',
    ),
    'whatsapp' => array(
        'name' => 'whatsapp',
        'user' => '',
        'font' => 'fab fa-whatsapp',
        'link' => 'https://api.whatsapp.com/send?phone=27218793035',
        'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/twitter.png',
    ),
);

echo $social_media['twitter']['name'];