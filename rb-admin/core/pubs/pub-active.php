<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';
$article_id	= $_GET['article_id'];

$sql = $objDataBase->Ejecutar("SELECT activo FROM articulos WHERE id=$article_id");
$row = $sql->fetch_assoc();

if($row['activo']=='D'){
	$objDataBase->EditarPorCampo("articulos", "activo","A",$article_id);
}else{
	$objDataBase->EditarPorCampo("articulos", "activo","D",$article_id);
}

$result = $objDataBase->Ejecutar("SELECT activo FROM articulos WHERE id=$article_id");
$row = $result->fetch_assoc();

$arr = array('estado' => $row['activo'], 'error' => 'none' );
die(json_encode($arr));
?>
