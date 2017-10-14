<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$value_id = $_GET['id'];
$r = $objDataBase->Ejecutar("DELETE FROM articulos WHERE id = $value_id");
header('Content-type: application/json; charset=utf-8');
if($r){
	$objDataBase->Ejecutar("DELETE FROM articulos_albums WHERE articulo_id = $value_id");
	$objDataBase->Ejecutar("DELETE FROM articulos_articulos WHERE articulo_id_padre = $value_id");
	$objDataBase->Ejecutar("DELETE FROM articulos_categorias WHERE articulo_id = $value_id");
	$objDataBase->Ejecutar("DELETE FROM objetos WHERE articulo_id = $value_id");
  $arr = array('result' => 1, 'url' => G_SERVER );
  die(json_encode($arr));
}else{
  $arr = array('result' => 0, 'url' => G_SERVER );
  die(json_encode($arr));
}
?>
