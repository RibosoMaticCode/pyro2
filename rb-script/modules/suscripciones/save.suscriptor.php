<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

// Validar campos vacios
if(strlen($_POST['nombres']) < 3){
	$arr = ['resultado' => false, 'contenido' => 'Campo nombres no debe quedar vacio, minimo caracteres 3', 'continue' => false ];
	die(json_encode($arr));
}
if(empty($_POST['correo'])){
	$arr = ['resultado' => false, 'contenido' => 'Campo correo no debe quedar vacio', 'continue' => false ];
	die(json_encode($arr));
}
if( !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) ){
	$arr = ['resultado' => false, 'contenido' => 'Formato de correo invalido', 'continue' => false ];
	die(json_encode($arr));
}
if(strlen($_POST['telefono']) < 6){
	$arr = ['resultado' => false, 'contenido' => 'Campo telefono no debe quedar vacio, minimo caracteres 6', 'continue' => false ];
	die(json_encode($arr));
}

// Asignando valores
$valores = [
	'nombres' => $_POST['nombres'],
	'correo' => trim($_POST['correo']),
	'telefono' => isset($_POST['telefono']) ? trim($_POST['telefono']) : "",
  	'fecha' => date('Y-m-d G:i:s')
];

// Validar mail
$q = $objDataBase->Ejecutar("SELECT * FROM suscriptores WHERE correo='".$valores['correo']."'");
if($q->num_rows > 0){
	$arr = ['resultado' => false, 'contenido' => 'Correo existente en la base de datos.', 'continue' => false ];
	die(json_encode($arr));
}

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('suscriptores', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Suscriptor registrado', 'id' => $r['insert_id'], 'continue' => true ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('suscriptores', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Suscriptor actualizado', 'continue' => true ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
