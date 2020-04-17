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
$tipo = $_POST['tipo'];
$titulo = trim($_POST['titulo']);
$contenido = $_POST['contenido'];
$padre_id = $_POST['padre_id'];
$acceso = 0;
if( isset($_POST['acceso_permitir']) ){
	$acceso = 1;
}

// Asignacion de valores a array de datos a enviar: nombre_columna => valor
$data = [
	'fecha_creacion' => date('Y-m-d G:i:s'),
	'titulo' => $titulo,
	'url' => rb_cambiar_nombre(utf8_encode(trim($titulo))),
	'contenido' => $contenido,
	'autor_id' => G_USERID,
	'tipo' => $tipo,
	'padre_id' => $padre_id,
	'acceso_permitir' => $acceso
];

// Nuevo
if($id=="0"){
	$r = $objDataBase->Insert("aula_contenidos", $data);
	if($r['result']){
		$ultimo_id = $r['insert_id'];
		$arr = ['result' => true, 'message' => 'Contenido guardado', 'id' => $r['insert_id'], 'tipo' => $tipo, 'padre_id' => $padre_id];
	}else{
		$arr = ['result' => false, 'message' => $r['error']];
	}
	die(json_encode($arr));

// Editar
}else{
	$id=$_POST['id'];
	$r = $objDataBase->Update("aula_contenidos", $data, ["id" => $id]);
	if($r['result']){
		$arr = ['result' => true, 'message' => 'Contenido actualizado', 'id' => $id, 'tipo' => $tipo, 'padre_id' => $padre_id];
	}else{
		$arr = ['result' => false, 'message' => $r['error']];
	}
	die(json_encode($arr));
}
?>
