<?php
/* parametros inciales */
$table_name = "plm_category";

/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once 'funcs.php';

$id = $_GET['id'];

$r = delete_category($id);
$objDataBase->Ejecutar("DELETE FROM $table_name WHERE id=".$id);
// Borrar de la DB
//$r = $objDataBase->Ejecutar("DELETE FROM $table_name WHERE id=".$id);
if($r){
	$arr = ['resultado' => true, 'contenido' => 'Elemento eliminado' ];
}else{
	$arr = ['resultado' => false, 'contenido' => $r['error']];
}
die(json_encode($arr));
?>
