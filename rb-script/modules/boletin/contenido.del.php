<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_GET['id'];

// Borrar de la DB
if(G_ACCESOUSUARIO){
	$r = $objDataBase->Ejecutar('DELETE FROM boletin_contenidos WHERE id='.$id);
	if($r){
		$arr = ['resultado' => true, 'contenido' => 'Contenido eliminado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{
	$arr = ['resultado' => false, 'contenido' => 'No ha iniciado sesion'];
}
die(json_encode($arr));
?>
