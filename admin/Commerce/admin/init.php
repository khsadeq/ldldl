<?php
include 'connect.php';
#routes

$tpl='includes/templa/';
$lang='includes/languages/';
$func='includes/functions/';
$js='layout/js/';
$css='layout/css/';


include $func .'function.php';
include $lang . 'english.php';
include $tpl . 'header.php';
//  include $tpl . 'navbar.php';

include $tpl . 'footer.php';
if(!isset($noNavbar)){include $tpl . 'navbar.php';}