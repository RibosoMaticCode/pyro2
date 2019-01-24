<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

if($_POST['customer_id']==0){
    $arr = ['resultado' => false, 'contenido' => 'Seleccione un cliente de la lista' ];
    die(json_encode($arr));
}

$valores = [
  'customer_id' => $_POST['customer_id'],
  'fecha_visita' => $_POST['fecha_visita'],
  'observaciones' => trim($_POST['observaciones'])
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('crm_visits', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Visita añadida', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('crm_visits', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Visita actualizada' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
