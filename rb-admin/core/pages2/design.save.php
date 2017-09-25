<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-articulos.class.php';

$pagina_id = $_GET['pid'];
$tipo = $_GET['tip'];
$detalle = addslashes($_GET['det']);
$posicion = $_GET['pos'];

echo "INSERT INTO bloques (pagina_id, tipo, detalles, position) VALUES ($pagina_id, '$tipo', '$detalle', $posicion) ";
if($objArticulo->Consultar("INSERT INTO bloques (pagina_id, tipo, detalles, position) VALUES ($pagina_id, '$tipo', '$detalle', $posicion) ")):
	echo "Exito";
else:
	echo "Ocurrio un error";
endif;
?>