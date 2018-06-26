<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/funciones.php';
$r = rb_set_values_options('objetos',$_POST['objetos']);

if($r==true){
	$arr = array('result' => true );
}else {
	$arr = array('result' => false );
}
die(json_encode($arr));
?>
