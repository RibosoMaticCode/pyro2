<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

$valores = [
  'nombres' => $_POST['nombres'],
  'apellidos' => $_POST['apellidos'],
  'correo' => trim($_POST['correo']),
  'telefono' => trim($_POST['telefono']),
  'fecharegistro' => date('Y-m-d G:i:s')
];

if($id==0){ // Nuevo
	// Validar mail
	if($valores['correo']!=""){
		$q = $objDataBase->Ejecutar("SELECT * FROM crm_customers WHERE correo='".$valores['correo']."'");
		if($q->num_rows > 0){
			$arr = ['resultado' => false, 'contenido' => 'Correo existente en la base de datos.', 'continue' => true ];
			die(json_encode($arr));
		}
	}

	$r = $objDataBase->Insert('crm_customers', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Cliente añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('crm_customers', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Cliente actualizado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
