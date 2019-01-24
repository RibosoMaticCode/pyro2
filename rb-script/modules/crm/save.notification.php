<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

if($_POST['customer_id']==0){
	$arr = ['resultado' => false, 'contenido' => 'Debe elegir un cliente valido' ];
	die(json_encode($arr));
}
$valores = [
  'customer_id' => $_POST['customer_id'],
  'mensaje' => $_POST['mensaje'],
  'sender_id' => G_USERID,
  'fecha_registro' => date('Y-m-d G:i:s')
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('crm_notification', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Notificacion añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('crm_notification', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Notificacion actualizado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
