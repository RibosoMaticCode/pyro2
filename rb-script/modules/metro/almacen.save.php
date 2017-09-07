<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$alm_id = $_POST['alm_id'];
$nom = $_POST['nombre'];
$det = $_POST['detalles'];
$cor = $_POST['coordenadas'];
$img_id = $_POST['image_id'];

header('Content-type: application/json; charset=utf-8');
if($alm_id==0):
	if($objDataBase->Consultar("INSERT INTO metro_almacen (nombre_almacen, detalles, coordenadas, foto_id) VALUES ( '$nom', '$det', '$cor', $img_id )")):
		$arr = array('resultado' => 'ok', 'contenido' => 'Publicacion guardada' );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => mysql_error() );
		die(json_encode($arr));
	endif;
else:
	if($objDataBase->Consultar("UPDATE metro_almacen SET nombre_almacen = '$nom', detalles = '$det', coordenadas = '$cor', foto_id = $img_id WHERE id = $alm_id")):
		$arr = array('resultado' => 'ok', 'contenido' => 'Publicacion actualizada' );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => mysql_error() );
		die(json_encode($arr));
	endif;
endif;
?>
