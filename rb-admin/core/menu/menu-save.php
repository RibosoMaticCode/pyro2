<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$volver = "false";
if (isset($_POST['guardar_volver'])) $volver = "true";

$mode=$_POST['mode'];
$nom=$_POST['nombre'];

$valores = [
	'nombre' => $nom
];

if($nom=="") die("Falta nombre del item");
if($mode=="new"){
	$response = $objDataBase->Insert(G_PREFIX.'menus', $valores);
  if($response['result']) $ultimo_id=$response['insert_id'];
  else die("Error: ".$response['error']);
  $enlace=G_SERVER.'rb-admin/index.php?pag=menus&opc=edt&id='.$ultimo_id;
  header('Location: '.$enlace);
}elseif($mode=="update"){
  $id=$_POST['id'];
	$response = $objDataBase->Update(G_PREFIX.'menus', $valores, ['id' => $id]);
	if(!$response['result']) die("Error: ".$response['error']);
  $enlace=G_SERVER.'rb-admin/index.php?pag=menus&opc=edt&id='.$id;
  header('Location: '.$enlace);
}
?>
