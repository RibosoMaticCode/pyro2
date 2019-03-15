<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

if(!G_ACCESOUSUARIO){
	$arr = array('result' => false, 'message' => 'No puede completarse esta accion', 'detail' => 'Usuario no inicio sesion' );
  die(json_encode($arr));
}
if(!isset($_GET['id']) || $_GET['id']==0 || $_GET['id']==""){
	$arr = array('result' => false, 'message' => 'No puede completarse esta accion', 'detail' => 'No hay valor a eliminar' );
  die(json_encode($arr));
}
$value_id = $_GET['id'];
$q = "SELECT * FROM photo WHERE id=".$value_id;
$qr = $objDataBase->Ejecutar($q);
$r = $qr->fetch_assoc();

if(G_USERID<>$r['usuario_id']){
	$arr = array('result' => false, 'message' => 'No puede completarse esta accion', 'detail' => 'Usuario no es el propietario' );
  die(json_encode($arr));
}
$src_img = $r['src'];
$fileType = $r['type'];

// eliminar foto fisica
$ruta_image = ABSPATH.'rb-media/gallery/'.$src_img;
$ruta_tn = ABSPATH.'rb-media/gallery/tn/'.$src_img;
unlink($ruta_image);
if($fileType == "image/png" || $fileType == "image/jpeg" || $fileType == "image/gif") unlink($ruta_tn);

$r = $objDataBase->Ejecutar("DELETE FROM photo WHERE id = $value_id");

header('Content-type: application/json; charset=utf-8');
if($r){
  $arr = array('result' => 1, 'url' => G_SERVER );
  die(json_encode($arr));
}else{
  $arr = array('result' => 0, 'url' => G_SERVER );
  die(json_encode($arr));
}
?>
