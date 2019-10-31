<?php
// Remueve foto de una galeria de fotos
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$value_id = $_GET['id'];

$r = $objDataBase->Ejecutar("UPDATE ".G_PREFIX."files SET album_id = 0 WHERE id = ".$value_id);
header('Content-type: application/json; charset=utf-8');
if($r){
  $arr = array('result' => 1, 'url' => G_SERVER );
  die(json_encode($arr));
}else{
  $arr = array('result' => 0, 'url' => G_SERVER );
  die(json_encode($arr));
}
?>
