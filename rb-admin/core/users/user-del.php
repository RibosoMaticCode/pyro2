<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$value_id = $_GET['id'];
header('Content-type: application/json; charset=utf-8');
// REVISAR SI ES ADMIN, YA QUE ADMIN NO PUEDE SER ELIMINADO
$r = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE id = $value_id");
$row = $r->fetch_assoc();
if($row['nickname']=="admin"){
  $arr = array('result' => 0, 'message' => 'El usuario "admin" no puede eliminarse del sistema' );
  die(json_encode($arr));
}
$r = $objDataBase->Ejecutar("DELETE FROM usuarios WHERE id = $value_id");
if($r){
  $arr = array('result' => 1, 'message' => G_SERVER );
  die(json_encode($arr));
}else{
  $arr = array('result' => 0, 'message' => G_SERVER );
  die(json_encode($arr));
}
?>
