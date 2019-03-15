<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_GET['id'];
$value = $_GET['value'];
$field = $_GET['field'];

$r = $objDataBase->Update('plm_comments', [$field=> $value], ['id' => $id]);
if($r){
	$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado'];
}else{
	$arr = ['resultado' => false, 'contenido' => $r['error']];
}
die(json_encode($arr));
?>
