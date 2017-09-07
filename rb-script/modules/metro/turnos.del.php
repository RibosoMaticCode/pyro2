<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$pto_id = $_GET['pto_id'];
$horini = $_GET['horini'];

if($objDataBase->Consultar("delete from metro_turnos where punto_id=".$pto_id." AND turno_inicio='".$horini."'")){
	$objDataBase->Consultar("delete from metro_horarios where punto_id=".$pto_id." AND horainicio='".$horini."'");
}

$urlreload=G_SERVER.'/rb-admin/module.php?pag=predi_tur&pto_id='.$pto_id;
header('Location: '.$urlreload);
?>
