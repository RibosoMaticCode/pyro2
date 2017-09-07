<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/class/rb-database.class.php';

// Modo
$mode=$_POST['mode'];

// DEFINICION DE VARIABLES
$nom=$_POST['nom'];
$des=$_POST['des'];
$src=$_POST['src_id'];
//$cor=$_POST['cor'];
$ubi=$_POST['ubi'];
$alm=$_POST['alm'];
$mod=$_POST['mod'];
//$almn=$_POST['almn'];
$aux_id=$_POST['aux_id'];

// validates
if($nom=="") die("Asigne un nombre al grupo");

// tipo de accion
if($mode=="new"){
	if($objDataBase->Consultar("INSERT INTO metro_puntos (nombre, descripcion, src, ubicacion, modalidad, almacen_id, auxiliar_id)
		VALUES ( '$nom','$des',$src,'$ubi',$alm,'$mod',$aux_id)")){

		$ultimo_id=mysql_insert_id();
		$enlace=G_SERVER.'/rb-admin/module.php?pag=predi_ptos&opc=edt&id='.$ultimo_id;
		header('Location: '.$enlace);
	}else{
		echo "Ocurrio un problema al ingresar la informacion";
	}
}elseif($mode=="update"){
	$id=$_POST['id'];

	if($objDataBase->Consultar("UPDATE metro_puntos
		SET nombre='$nom', descripcion='$des', src=$src, ubicacion='$ubi', modalidad='$mod',
		almacen_id=$alm, auxiliar_id=$aux_id
		WHERE id=".$id)){

		$enlace=G_SERVER.'/rb-admin/module.php?pag=predi_ptos&opc=edt&id='.$id;
		header('Location: '.$enlace);
	}else{
		echo "Ocurrio un problema al actualizar la informacion";
	}
}
?>
