<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

unset($_SESSION['carrito'][$_GET['id']]);

// redireccionar la pagina de pedido
if(G_ENL_AMIG) $urlreload = G_SERVER."/shopping-cart/";
else $urlreload = G_SERVER."/?shopping-cart";

header('Location: '.$urlreload);
?>
