<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH."rb-script/class/rb-database.class.php";

$mode=$_POST['mode'];
$columns_vals = [
	'name' => trim($_POST['name']),
	'name_id' => rb_cambiar_nombre( utf8_encode( trim( $_POST['name'] ) ) ),
	'estructure' => htmlentities(trim($_POST['estructure'])),
	'validations' => addslashes($_POST['validations']),
	'mails' => $_POST['mails'],
	'user_id' => G_USERID,
	'intro' => $_POST['intro'],
	'respuesta' => $_POST['rspta']
];

if(!isset($_POST['name']) || $_POST['name']==""){
	$arr = array('result' => false, 'message' => 'Campo asunto requerido');
	die(json_encode($arr));
}
if(!isset($_POST['estructure']) || $_POST['estructure']==""){
	$arr = array('result' => false, 'message' => 'La estructura del formulario requerido');
	die(json_encode($arr));
}

// tipo de accion
if( $mode=="new" ){
	//$columns_vals['name_id'] = rb_cambiar_nombre( utf8_encode( trim( $_POST['name'] ) ) );
	$result = $objDataBase->Insert(G_PREFIX.'forms', $columns_vals);
	if( $result['result'] ){
		$arr = array('result' => true, 'message' => 'Formulario guardado', 'url' => G_SERVER, 'last_id' => $result['insert_id'] );
	}else{
		$arr = array('result' => false, 'message' => $result['error']);
	}
}elseif( $mode=="update" ){
	$id = $_POST['id'];
	//$columns_vals['name_id'] = rb_cambiar_nombre( utf8_encode( trim( $_POST['name'] ) ) );
	$result = $objDataBase->Update(G_PREFIX.'forms', $columns_vals, ['id' => $id]);
	if( $result['result'] ){
		$arr = array('result' => true, 'message' => 'Formulario actualizado', 'url' => G_SERVER, 'last_id' => $id );
	}else{
		$arr = array('result' => false, 'message' => $result['error']);
	}
}
die(json_encode($arr));
?>
