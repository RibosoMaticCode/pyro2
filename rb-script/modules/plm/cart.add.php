<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST['product_id'];
	$cant = $_POST['cantidad'];
	$variant_id = $_POST['variant_id'];

	// verificar si existe
	$response = searchForId($id.$variant_id, $_SESSION['carrito']);
	if ($response['result']) {
		$key = $response['key']; // Obtenemos key del valor encontrado

		//capturamos cantidad anterior;
    $cant_ant = $_SESSION['carrito'][$key]['cant'];

		// Añadimos nueva cantidad
		$_SESSION['carrito'][$key]['cant'] = $cant_ant + $cant;
		 // cantidad de elementos en carrito
	}else{
		// agregando elemento nuevo a array
		$cart_item = [
			'id' => $id.$variant_id,
			'variant_id' => $variant_id,
			'product_id' => $id,
			'cant' => $cant
		];

		array_push($_SESSION['carrito'], $cart_item);
	}
	$cant_cart = count($_SESSION['carrito']);
	//print_r($_SESSION['carrito']);
	$arr = ['resultado' => true, 'contenido' => 'Producto agregado al carrito de compras', 'cant_new' => $cant_cart ];
}else{
	$arr = ['resultado' => false, 'contenido' => 'No se recibieron parametros.'];
}
die(json_encode($arr));
?>
