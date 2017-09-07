<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$pto_id = $_GET['pto_id'];
$dia = $_GET['dia'];
$horini = $_GET['horini'];
$usu_id = $_GET['usu_id'];

$objDataBase->Consultar("DELETE FROM metro_horarios WHERE punto_id=$pto_id AND dia=$dia AND horainicio='$horini' AND usuario_id=$usu_id");

if(isset($_GET['ajax'])): // Ajax
	$arr = array('resultado' => 'ok', 'contenido' => '<h2 style="color:green">Se actualizó el horario</h2>' );
	header('Content-type: application/json; charset=utf-8');
	die(json_encode($arr));
else:
	$urlreload=G_SERVER.'/rb-admin/module.php?pag=predi_hor&id='.$pto_id;
	header('Location: '.$urlreload);
endif;
?>
