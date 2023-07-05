<?php
//error reporting
ini_set('display_error', 'on');
error_reporting(E_ALL);

include 'admin/connect.php';

$sessionuser = '';
if(isset($_SESSION['user'])){
    $sessionuser = $_SESSION['user'];
}
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
