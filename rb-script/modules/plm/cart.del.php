<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/modules/plm/funcs.php';

$product_id = $_GET['id'];
$variant_id = "";

if(isset($_GET['variant_id']) && $_GET['variant_id'] > 0 && $_GET['variant_id']!=""){ // eliminar product con variante
	$variant_id = $_GET['variant_id'];
}

$response = searchForId($product_id.$variant_id, $_SESSION['carrito']);
if ($response['result']) {
	$key = $response['key'];
	unset($_SESSION['carrito'][$key]);

	// Ajustar total con descuento
	if(isset($_SESSION['discount']) && count($_SESSION['discount']) > 0){
		discount_adjust($_SESSION['discount']['coupon']['code']);
	}
}

if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) == 0){
	unset($_SESSION['discount']);
}

// redireccionar la pagina de pedido
if(G_ENL_AMIG) $urlreload = G_SERVER."shopping-cart/";
else $urlreload = G_SERVER."?shopping-cart";

header('Location: '.$urlreload);
?>
