<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

if(!isset($_REQUEST['items'])) {
  print "[!] Debe seleccionar alguna imagen ... !!!";
  die();
}
$array_images = $_REQUEST['items'];

foreach($array_images as $image){
  $objDataBase->Ejecutar("UPDATE ".G_PREFIX."files SET album_id =".$_POST['album_id']." WHERE id=".$image);
}
$urlreload=G_SERVER.'rb-admin/index.php?pag=gal&album_id='.$_POST['album_id']."&m=ok";
header('Location: '.$urlreload);
?>
