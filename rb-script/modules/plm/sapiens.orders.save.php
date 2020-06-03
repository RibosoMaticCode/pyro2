<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];
$sendmail = $_POST['sendmail'];

// Validar campos vacios
if(isset($_POST['names']) && strlen($_POST['names']) < 3){
	$arr = ['resultado' => false, 'contenido' => 'Campo Nombres no debe quedar vacio, minimo caracteres 3', 'continue' => false ];
	die(json_encode($arr));
}
if(empty($_POST['email'])){
	$arr = ['resultado' => false, 'contenido' => 'Campo Correo no debe quedar vacio', 'continue' => false ];
	die(json_encode($arr));
}
if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
	$arr = ['resultado' => false, 'contenido' => 'Formato de correo es invalido', 'continue' => false ];
	die(json_encode($arr));
}
if(isset($_POST['phone']) && strlen($_POST['phone']) < 9){
	$arr = ['resultado' => false, 'contenido' => 'Campo Celular no debe quedar vacio, minimo caracteres 9', 'continue' => false ];
	die(json_encode($arr));
}

// Asignando valores
$valores = [
	'date' => date('Y-m-d G:i:s'),
	//'book_title' => $_POST['book_title'],
	//'book_url' => $_POST['book_url'],
	'names' => isset($_POST['names']) ? trim($_POST['names']) : "sin nombre",
	'lastnames' => isset($_POST['lastnames']) ? trim($_POST['lastnames']) : "sin nombre",
	'email' => isset($_POST['email']) ? trim($_POST['email']) : "sin correo",
	'phone' => isset($_POST['phone']) ? trim($_POST['phone']) : "sin fono",
	'career' => $_POST['career'],
	'school' => $_POST['school'],
	'total' => $_POST['total'],
	'order_details' => $_POST['order_details']
];

if( isset($_POST['delivery']) && $_POST['delivery']==""){
	$arr = ['resultado' => false, 'contenido' => 'Seleccione modo de entrega', 'continue' => false ];
	die(json_encode($arr));
} elseif( isset($_POST['delivery'])){
	$valores['delivery'] = $_POST['delivery'];
}
if( isset($_POST['delivery']) && $_POST['delivery']=="0" && $_POST['address'] == ""){
	$arr = ['resultado' => false, 'contenido' => 'Escriba su dirección', 'continue' => false ];
	die(json_encode($arr));
} elseif( isset($_POST['delivery'])){
	$valores['address'] = $_POST['address'];
}

if( isset($_POST['num_operacion']) ){
	$valores['num_operation'] = $_POST['num_operacion'];
}
if( isset($_POST['costo_delivery']) ){
	$valores['delivery_cost'] = $_POST['costo_delivery'];
}

// Validar mail
/*if($_POST['mode']=="new"){
	$q = $objDataBase->Ejecutar("SELECT * FROM sapiens_orders WHERE email='".$valores['email']."'");
	if($q->num_rows > 0){
		$arr = ['resultado' => false, 'contenido' => 'Correo existente en la base de datos.', 'continue' => false ];
		die(json_encode($arr));
	}
}*/

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('sapiens_orders', $valores);
	if($r['result']){
		// Registrar numero de pedido
		$num_order = date('Y').date('m').date('d').str_pad($r['insert_id'], 4, "0", STR_PAD_LEFT);
		$objDataBase->Update('sapiens_orders', ["num_order" => $num_order] , ["id" => $r['insert_id']]);

		// Send mail
		if($sendmail==1){
			require_once 'sapiens.orders.sendmail.php';
		}

		unset($_SESSION['carrito']);

		$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'id' => $r['insert_id'], 'continue' => true ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('sapiens_orders', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Pedido actualizado', 'continue' => true ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
