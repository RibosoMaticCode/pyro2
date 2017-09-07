<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$horaini = $_POST['horaini'];
$horafin = $_POST['horafin'];
$pto_id = $_POST['punto_id'];
$dia = $_POST['dia'];
$usuario_id = $_POST['usuario_id'];

if($objDataBase->Consultar("INSERT INTO metro_horarios (punto_id, dia, horainicio, horafin, usuario_id, fecha_mod) VALUES ( ".$pto_id.",".$dia.",'".$horaini."','".$horafin."',".$usuario_id.", NOW() )")):
	// Todo Ok
	if(isset($_POST['ajax'])): // Ajax
		$arr = array('resultado' => 'ok', 'contenido' => '<h2 style="color:green">Publicador asignado al horario</h2>' );
		header('Content-type: application/json; charset=utf-8');
		die(json_encode($arr));
	else: // No ajax
		$urlreload=G_SERVER.'/rb-admin/module.php?pag=predi_hor&id='.$pto_id;
		header('Location: '.$urlreload);
	endif;
else:
	// Todo mal
	if(isset($_POST['ajax'])): // Ajax
		$arr = array('resultado' => 'bad', 'contenido' => '<h2 style="color:red">Problemas al grabar</h2>' );
		header('Content-type: application/json; charset=utf-8');
		die(json_encode($arr));
	else: // No ajax
		die("Error");
	endif;
endif;
?>
