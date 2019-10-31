<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");
require_once(ABSPATH."rb-script/funcs.php");

$mode=$_POST['mode'];
$nom = $_POST['nombre'];
$niv = rb_cambiar_nombre(strip_tags(utf8_encode($_POST['nombre'])));

// tipo de accion
if($mode=="new"){
	$q = "INSERT INTO ".G_PREFIX."users_groups (nombre, grupo_enlace) VALUES('$nom', '$niv')";
	$result = $objDataBase->Insertar($q);
	if($result){
		$ultimo_id=$result['insert_id'];

		$enlace=G_SERVER.'rb-admin/module.php?pag=gru&opc=edt&id='.$ultimo_id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}
}elseif($mode=="update"){
	$id=$_POST['id'];
	$q = "UPDATE ".G_PREFIX."users_groups SET nombre = '$nom', grupo_enlace = '$niv' WHERE id= $id";
	if($objDataBase->Ejecutar($q)){
		$enlace=G_SERVER.'rb-admin/module.php?pag=gru&opc=edt&id='.$id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}
}
?>
