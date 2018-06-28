<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$mode=$_POST['mode'];
$columns_vals = [
	'name' => trim($_POST['name']),
	'estructure' => htmlentities(trim($_POST['estructure'])),
	'validations' => addslashes($_POST['validations']),
	'user_id' => G_USERID
];

// tipo de accion
if( $mode=="new" ){
	$columns_vals['name_id'] => rb_cambiar_nombre( utf8_encode( trim($_POST['name']) ) );
	$result = $objDataBase->Insert('forms', $columns_vals);
	if( $result['result'] ){
		//$ultimo_id=$result['insert_id'];
		//$enlace=G_SERVER.'/rb-admin/module.php?pag=forms&opc=edt&id='.$ultimo_id."&m=ok";
		//header('Location: '.$enlace);
		$arr = array('result' => true, 'message' => 'Formulario guardado', 'url' => G_SERVER, 'last_id' => $result['insert_id'] );
	}else{
		$arr = array('result' => false, 'message' => $result['error']);
	}
}elseif( $mode=="update" ){
	$id = $_POST['id'];
	$result = $objDataBase->Update('forms', $columns_vals, ['id' => $id]);
	if( $result['result'] ){
		/*$enlace=G_SERVER.'/rb-admin/module.php?pag=forms&opc=edt&id='.$id."&m=ok";
		header('Location: '.$enlace);*/
		$arr = array('result' => true, 'message' => 'Formulario actualizado', 'url' => G_SERVER, 'last_id' => $id );
	}else{
		$arr = array('result' => false, 'message' => $result['error']);
	}
}
die(json_encode($arr));
?>
