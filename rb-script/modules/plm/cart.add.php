<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST['product_id'];
	$cant = $_POST['cantidad'];
	// verificar si existe
	if (array_key_exists($id, $_SESSION['carrito'])) {
		//si exsite captura cantidad anterior;
    $cant_ant = $_SESSION['carrito'][$id];
		$_SESSION['carrito'][$id] = $cant_ant + $cant;
		$cant_cart = count($_SESSION['carrito']); // cantidad de elementos en carrito
	}else{
		// agregando elemento a array
		$_SESSION['carrito'][$id] = $cant;
		$cant_cart = count($_SESSION['carrito']); // cantidad de elementos en carrito
	}
	$arr = ['resultado' => true, 'contenido' => 'Producto agregado al carrito de compras', 'cant_new' => $cant_cart ];
}else{
	$arr = ['resultado' => false, 'contenido' => 'No se recibieron parametros.'];
}
die(json_encode($arr));
?>
