<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");
		
$mode=$_POST['mode'];
$nom = $_POST['nombre'];
$niv = $_POST['enlace'];
$per = $_POST['permisos'];

// tipo de accion
if($mode=="new"){	
	$q = "INSERT INTO usuarios_niveles (nombre, nivel_enlace, permisos) VALUES('$nom', '$niv', '$per')";
	if($objDataBase->Consultar($q)){		
		$ultimo_id=mysql_insert_id();
				
		$enlace=G_SERVER.'/rb-admin/index.php?pag=nivel&opc=edt&id='.$ultimo_id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}
}elseif($mode=="update"){
	$id=$_POST['id'];
	$q = "UPDATE usuarios_niveles SET nombre = '$nom', nivel_enlace = '$niv', permisos = '$per' WHERE id= $id";
	if($objDataBase->Consultar($q)){			
		$enlace=G_SERVER.'/rb-admin/index.php?pag=nivel&opc=edt&id='.$id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}			
}
?>