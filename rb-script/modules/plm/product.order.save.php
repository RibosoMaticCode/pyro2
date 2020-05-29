<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$jsonOrder = $_GET['jsonOrder'];
$arrayOrder = json_decode($jsonOrder, true);

foreach ($arrayOrder as $item => $value):
	$file_id = $value['id'];
	$file_order = $value['order'];
	$result = $objDataBase->Ejecutar("UPDATE plm_products SET orden = ".$file_order." WHERE id = ".$file_id);
  	if( !$result ){
  		$arr = ['result' => false, 'message' => 'Error al actualizar'];
  		die(json_encode($arr));
  	}
endforeach;

$arr = ['result' => true, 'message' => 'Orden guardado'];
die(json_encode($arr));
?>
