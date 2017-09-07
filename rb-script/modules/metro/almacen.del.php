<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$id = $_GET['id'];

if($objDataBase->Consultar("DELETE FROM metro_almacen WHERE id=$id")):
	$arr = array('resultado' => 'ok', 'contenido' => '<h2 style="color:green">Se elimino el dato</h2>' );
else:
	$arr = array('resultado' => 'bad', 'contenido' => '<h2 style="color:green">Algo salio mal</h2>' );
endif;
$arr = array('resultado' => 'ok', 'contenido' => 'Se elimino el dato' );
die(json_encode($arr));
?>
