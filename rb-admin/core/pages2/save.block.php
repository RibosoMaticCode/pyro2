<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$id = $_POST['block_id'];
$nom = $_POST['block_name'];
$cont = $_POST['block_content'];

$columns_vals = [
  'nombre' => $nom,
  'contenido' => $cont];
header('Content-type: application/json; charset=utf-8');
if($id==0):
	$result = $objDataBase->Insert('bloques', $columns_vals);
	if($result['result']){
		$arr = array('resultado' => true, 'contenido' => 'Informacion almacenada en base de datos', 'id' => $result['insert_id']);
		die(json_encode($arr));
	}else{
		$arr = array('resultado' => false, 'contenido' => $result['error']);
		die(json_encode($arr));
	}
else:
	$columns_vals = [
	  'contenido' => $cont];
	$condition = ['id' => $id];
	$result = $objDataBase->Update('bloques', $columns_vals, $condition);
	if($result['result']){
		$arr = array('resultado' => true, 'contenido' => 'Informacion actualizada en base de datos', 'id' => $id);
		die(json_encode($arr));
	}else{
		$arr = array('resultado' => false, 'contenido' => $result['error']);
		die(json_encode($arr));
	}
endif;
?>
