<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$volver = "false";
if (isset($_POST['guardar_volver'])) $volver = "true";
$mode=$_POST['mode'];
$nom=$_POST['nombre'];
if($nom=="") die("Falta nombre del item");
if($mode=="new"){
  $response = $objDataBase->Insertar("INSERT INTO menus (nombre) VALUES('$nom')");
  if($response['result']) $ultimo_id=$response['insert_id'];
  else die("Error");
  $enlace=G_SERVER.'/rb-admin/index.php?pag=menus&opc=edt&id='.$ultimo_id;
  header('Location: '.$enlace);
}elseif($mode=="update"){
  $id=$_POST['id'];
  $objMenu->Consultar("UPDATE menus SET nombre = '$nom' WHERE id = $id");
  $enlace=G_SERVER.'/rb-admin/index.php?pag=menus&opc=edt&id='.$id;
  header('Location: '.$enlace);
}
?>
