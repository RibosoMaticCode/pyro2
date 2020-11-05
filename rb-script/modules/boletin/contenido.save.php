<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

// Verificamos inicio de sesion
if(G_ACCESOUSUARIO == 0){
	$arr = ['result' => false, 'message' => 'Usuario necesita iniciar sesion'];
	die(json_encode($arr));
}

// Captura de valores
$id = $_POST['id'];
$titulo = trim($_POST['titulo']);
$categoria_id = trim($_POST['categoria_id']);
$contenido = $_POST['contenido'];

/*$acceso = 0;
if( isset($_POST['acceso_permitir']) ){
	$acceso = 1;
}
$users_ids = "";
if(isset($_REQUEST['users_ids'])){
	$users_ids =  implode (",",  $_REQUEST['users_ids']);
}*/


// Asignacion de valores a array de datos a enviar: nombre_columna => valor
$data = [
	'fecha_creacion' => date('Y-m-d G:i:s'),
	'titulo' => $titulo,
	'url' => rb_cambiar_nombre(utf8_encode(trim($titulo))),
	'contenido' => $contenido,
	'autor_id' => G_USERID,
	'categoria_id' => $categoria_id,
	'imagen_id' => $_POST['imagen_id'],
	'pdfs' => $_POST['pdfs'],
	'videos' => $_POST['videos'],
	'video_live' =>  $_POST['video_live']
	/*'tipo' => $tipo,
	'padre_id' => $padre_id,
	'acceso_permitir' => $acceso,
	'allow_users_ids' => $users_ids*/
];

// Nuevo
if($id=="0"){
	$r = $objDataBase->Insert("boletin_contenidos", $data);
	if($r['result']){
		$ultimo_id = $r['insert_id'];
		$arr = ['result' => true, 'message' => 'Contenido guardado', 'id' => $r['insert_id']];
	}else{
		$arr = ['result' => false, 'message' => $r['error']];
	}
	die(json_encode($arr));

// Editar
}else{
	$id=$_POST['id'];
	$r = $objDataBase->Update("boletin_contenidos", $data, ["id" => $id]);
	if($r['result']){
		$arr = ['result' => true, 'message' => 'Contenido actualizado', 'id' => $id];
	}else{
		$arr = ['result' => false, 'message' => $r['error']];
	}
	die(json_encode($arr));
}
?>
