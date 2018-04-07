<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$mode=$_POST['mode'];
$nom = $_POST['nombre'];
$des = $_POST['descripcion'];
$niv = $_POST['nivel_enlace'];
$subniv = $_POST['subnivel_enlace'];

// tipo de accion
if($mode=="new"){
	$q = "INSERT INTO usuarios_niveles (nombre, descripcion, nivel_enlace, subnivel_enlace) VALUES('$nom', '$des', '$niv', '$subniv')";
	$result = $objDataBase->Insertar($q);
	if($result){
		$ultimo_id=$result['insert_id'];
		$enlace=G_SERVER.'/rb-admin/index.php?pag=nivel&opc=edt&id='.$ultimo_id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}
}elseif($mode=="update"){
	$id=$_POST['id'];
	$q = "UPDATE usuarios_niveles SET nombre = '$nom', descripcion = '$des', nivel_enlace = '$niv', subnivel_enlace = '$subniv' WHERE id= $id";
	if($objDataBase->Ejecutar($q)){
		$enlace=G_SERVER.'/rb-admin/index.php?pag=nivel&opc=edt&id='.$id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}
}
?>
