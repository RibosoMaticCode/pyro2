<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

if(!G_ACCESOUSUARIO):
  $arr = ['result' => false, 'message' => 'No puede efectuar esta operacion.'];
  die(json_encode($arr));
endif;

$id = $_GET['id'];
$r = $objDataBase->Ejecutar('DELETE FROM staff WHERE id='.$id);
if($r){
	$arr = ['result' => true, 'message' => 'Elemento eliminado' ];
}else{
	$arr = ['result' => false, 'message' => $r['error']];
}
die(json_encode($arr));
?>
?>
