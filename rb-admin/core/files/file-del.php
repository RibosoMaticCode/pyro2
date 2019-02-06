<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$value_id = $_GET['id'];

$q = $objDataBase->Ejecutar("SELECT src, type FROM photo WHERE id=$value_id");
$r = $q->fetch_assoc();
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
