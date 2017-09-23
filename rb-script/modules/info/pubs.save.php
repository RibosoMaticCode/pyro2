<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$user_id = $_POST['user_id'];
$fec_nac = $_POST['fec_nac'];
$fec_bau = $_POST['fec_bau'];
$respo = isset($_POST['responsabilidad']) ? $_POST['responsabilidad'] : "";
$servi = isset($_POST['servicio']) ? $_POST['servicio'] : "";
$observa = $_POST['observa'];

header('Content-type: application/json; charset=utf-8');

$qp = $objDataBase->Consultar("SELECT * FROM informes_publicador WHERE user_id=$user_id");
$row_info = mysql_fetch_array($qp);

if($row_info):
	if($objDataBase->Consultar("UPDATE informes_publicador SET 
		fecha_nacimiento = '$fec_nac',
		fecha_bautismo = '$fec_bau', 
		puesto_responsabilidad = '$respo', 
		puesto_servicio = '$servi',
		observaciones = '$observa'
		WHERE user_id = $user_id")):
		
		$arr = array('resultado' => 'ok', 'contenido' => 'Actualización realizada' );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => 'Error al guardar actualizar' );
		die(json_encode($arr));
	endif;
else:
	if($objDataBase->Consultar("INSERT INTO informes_publicador (user_id, fecha_nacimiento, fecha_bautismo, puesto_responsabilidad, puesto_servicio, observaciones) VALUES
	 ( '$user_id', '$fec_nac', '$fec_bau', '$respo', '$servi', '$observa')")):
		$arr = array('resultado' => 'ok', 'contenido' => 'Cambios realizados' );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => 'Error al guardar' );
		die(json_encode($arr));
	endif;
	
endif;
?>