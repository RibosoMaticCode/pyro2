<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$id=$_GET['id'];
$q = "DELETE FROM ".G_PREFIX."users_groups WHERE id=". $id;
if($objDataBase->Ejecutar($q)){
	$enlace=G_SERVER.'/rb-admin/module.php?pag=gru';
	header('Location: '.$enlace);
}else{
	echo "[!] Problemas";
}
?>
