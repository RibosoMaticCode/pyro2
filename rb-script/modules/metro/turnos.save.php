<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$horaini = $_POST['horaini'];
$horafin = $_POST['horafin'];
$pto_id = $_POST['punto_id'];

/* Graba en base de datos*/
if($objDataBase->Consultar("insert into metro_turnos(punto_id, turno_inicio, turno_fin) values ('$pto_id','$horaini','$horafin')")){
	$urlreload=G_SERVER.'/rb-admin/module.php?pag=predi_tur&pto_id='.$pto_id;
	header('Location: '.$urlreload);
}else {
	echo "Error al ingresar data";
}


?>
