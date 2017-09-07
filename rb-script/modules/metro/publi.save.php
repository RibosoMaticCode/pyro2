<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$pub_id = $_POST['pub_id'];
$cod = $_POST['codigo'];
$tit = $_POST['titulo'];
$img_id = $_POST['image_id'];

header('Content-type: application/json; charset=utf-8');
if($pub_id==0):
	if($objDataBase->Consultar("INSERT INTO metro_publicacion (codigo, titulo, image_id) VALUES ( '$cod', '$tit', $img_id )")):
		$arr = array('resultado' => 'ok', 'contenido' => 'Publicacion guardada' );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => 'Error al guardar' );
		die(json_encode($arr));
	endif;
else:
	if($objDataBase->Consultar("UPDATE metro_publicacion SET codigo = '$cod', titulo = '$tit', image_id = $img_id WHERE id = $pub_id")):
		$arr = array('resultado' => 'ok', 'contenido' => 'Publicacion actualizada' );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => 'Error al guardar' );
		die(json_encode($arr));
	endif;
endif;
?>
