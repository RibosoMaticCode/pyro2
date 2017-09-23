<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");
require_once(ABSPATH."rb-script/funciones.php");
		
$mode=$_POST['mode'];

$usuario_id = $_POST['usuario_name_id']; //usuario_id (antes)
$mes = $_POST['mes'];
$anio = $_POST['anio'];
$pub = $_POST['pub'];
$vid = $_POST['vid'];
$hor = $_POST['hor'];
$rev = $_POST['rev'];
$est = $_POST['est'];
$obs = $_POST['obs'];
$servi = $_POST['servi'];
$respo = $_POST['respo'];
$id = 0;
$message;

// tipo de accion
if($mode=="new"){	
	$q = "INSERT INTO informes (mes, anio, usuario_id, pub, vid, hor, rev, est, obs, fecha_registro, servi, respo ) VALUES ($mes, $anio, $usuario_id, $pub, $vid, $hor, $rev, $est, '$obs', NOW(), '$servi', '$respo')";
	if($objDataBase->Consultar($q)){		
		$id = mysql_insert_id(); // ultimo_id
		$message = "Se ingresaron los datos con exito";
	}else{
		$rspta = Array(
			"codigo" => 0,
			"mensaje" => "Nro. Error: ".mysql_errno().", descripcion: ".mysql_error().". Vuelva a intentar o actualiza la página."
		);
		die( json_encode ($rspta) );
	}
}elseif($mode=="update"){
	$id=$_POST['id'];
	$q = "UPDATE informes SET mes=$mes, anio= $anio, usuario_id=$usuario_id, pub=$pub, vid=$vid, hor=$hor, rev=$rev, est=$est, obs='$obs', servi='$servi', respo='$respo' WHERE id= $id";
	if($objDataBase->Consultar($q)){			
		$message = "Se actualizacon los datos con exito";
	}else{
		$rspta = Array(
			"codigo" => 0,
			"mensaje" => "Nro. Error: ".mysql_errno().", descripcion: ".mysql_error().". Vuelva a intentar o actualiza la página."
		);
		die( json_encode ($rspta) );
	}			
}

$rspta = Array(
	"codigo" => 1,
	"mensaje" => $message,
	"id" => $id
);
die( json_encode ($rspta) );
?>