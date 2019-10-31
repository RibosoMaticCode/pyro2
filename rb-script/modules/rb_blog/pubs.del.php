<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$value_id = $_GET['id'];
$r = $objDataBase->Ejecutar("DELETE FROM blog_posts WHERE id = $value_id");
header('Content-type: application/json; charset=utf-8');
if($r){
	$objDataBase->Ejecutar("DELETE FROM blog_posts_posts WHERE articulo_id_padre = $value_id");
	$objDataBase->Ejecutar("DELETE FROM blog_posts_categories WHERE articulo_id = $value_id");
	$objDataBase->Ejecutar("DELETE FROM blog_fields WHERE articulo_id = $value_id");
  $arr = array('result' => 1, 'url' => G_SERVER );
  die(json_encode($arr));
}else{
  $arr = array('result' => 0, 'url' => G_SERVER );
  die(json_encode($arr));
}
?>
