<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");
require_once(ABSPATH."rb-script/funciones.php");
		
$mode=$_POST['mode'];
$nom = $_POST['nombre'];
$niv = rb_cambiar_nombre(strip_tags(utf8_encode($_POST['nombre'])));

// tipo de accion
if($mode=="new"){	
	$q = "INSERT INTO usuarios_grupos (nombre, grupo_enlace) VALUES('$nom', '$niv')";
	if($objDataBase->Consultar($q)){		
		$ultimo_id=mysql_insert_id();
				
		$enlace=G_SERVER.'/rb-admin/index.php?pag=gru&opc=edt&id='.$ultimo_id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}
}elseif($mode=="update"){
	$id=$_POST['id'];
	$q = "UPDATE usuarios_grupos SET nombre = '$nom', grupo_enlace = '$niv' WHERE id= $id";
	if($objDataBase->Consultar($q)){			
		$enlace=G_SERVER.'/rb-admin/modules.php?pag=gru&opc=edt&id='.$id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo "[!] Problemas";
	}			
}
?>