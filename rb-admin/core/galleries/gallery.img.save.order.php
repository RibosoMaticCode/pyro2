<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$jsonOrder = $_GET['jsonOrder'];
$arrayOrder = json_decode($jsonOrder, true);

foreach ($arrayOrder as $item => $value):
	$file_id = $value['id'];
	$file_order = $value['order'];
  if( !$objDataBase->Ejecutar ("UPDATE photo SET orden = $file_order WHERE id = $file_id") ) die("0");
endforeach;
die("1");
?>
