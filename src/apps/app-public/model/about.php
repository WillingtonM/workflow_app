<?php

$practice = '';

if(isset($_GET['story'])){
  $practice = 'story';
}elseif (isset($_GET['promise'])) {
  $practice = 'promise';
}elseif (isset($_GET['testimonials'])) {
  $practice = 'testimonials';
}elseif (isset($_GET['estate_planning'])) {
  $practice = 'estate_planning';
}
