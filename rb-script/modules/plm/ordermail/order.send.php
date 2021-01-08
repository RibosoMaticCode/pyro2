<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

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

// Asignando valores -- para base de datos
$valores = [
	'date' => date('Y-m-d G:i:s'),
	'names' => isset($_POST['names']) ? trim($_POST['names']) : "sin nombre",
	'lastnames' => isset($_POST['lastnames']) ? trim($_POST['lastnames']) : "sin nombre",
	'email' => isset($_POST['email']) ? trim($_POST['email']) : "sin correo",
	'phone' => isset($_POST['phone']) ? trim($_POST['phone']) : "sin fono",
	'total' => $_POST['total'],
	'order_details' => $_POST['order_details']
];

require_once 'order.sendmail.php';

unset($_SESSION['carrito']);

//$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'id' => 1, 'continue' => true ]; // TEST

die(json_encode($arr));
?>
