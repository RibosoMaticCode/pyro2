<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

if(!isset($_GET['email'])){
    $arr = ['result' => false, 'message' => 'Correo no establecido' ];
	die(json_encode($arr));
}

if($_GET['email']==""){
    $arr = ['result' => false, 'message' => 'Escriba un correo valido' ];
	die(json_encode($arr));
}
$email = $_GET['email'];

$nickname = rb_generate_nickname($email);
$password = random(8,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");

$arr = ['result' => true, 'nickname' => $nickname, 'password' => $password, 'message' => 'Nick y pass generado con éxito' ];
die(json_encode($arr));
?>
