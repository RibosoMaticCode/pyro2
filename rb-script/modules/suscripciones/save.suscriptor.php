<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

$valores = [
  'nombres' => $_POST['nombres'],
	'correo' => trim($_POST['correo']),
  'fecha' => date('Y-m-d G:i:s')
];

// Validar mail
$q = $objDataBase->Ejecutar("SELECT * FROM suscriptores WHERE correo='".$valores['correo']."'");
if($q->num_rows > 0){
	$arr = ['resultado' => false, 'contenido' => 'Correo existente en la base de datos.' ];
	die(json_encode($arr));
}

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('suscriptores', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Suscriptor añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('suscriptores', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Suscriptor actualizado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
