<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

// Asignacion valores
$valores = [
  	'code' => $_POST['code'],
  	'description' => $_POST['description'],
  	'type' => $_POST['type'],
  	'amount' => $_POST['amount'],
  	'date_expired' => $_POST['date_expired'],
  	'limit_by_user' => $_POST['limit_by_user'],
  	'expensive_min' => $_POST['expensive_min'],
  	'expensive_max' => $_POST['expensive_max'],
  	'status' => $_POST['status'],
  	'date_register' => date('Y-m-d G:i:s')
];

if($id==0){ // Nuevo

	$r = $objDataBase->Insert('plm_coupons', $valores);
	$last_id = $r['insert_id'];
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento añadido', 'id' => $last_id ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('plm_coupons', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado', 'id' => $id ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}
die(json_encode($arr));
?>
