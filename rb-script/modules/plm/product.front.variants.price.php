<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$combo = $_GET['combo'];

$q = "SELECT * FROM plm_products_variants WHERE name='".$combo."'";

$qr = $objDataBase->Ejecutar($q);
if($qr->num_rows > 0){
  $variant = $qr->fetch_assoc();
  $precio_normal = $variant['price'];
  $descuento = $variant['discount'];
  $precio_final = $variant['price_discount'];
  $arr = ['result' => true, 'price' => $precio_normal, 'discount' => $descuento, 'price_discount' => $precio_final];
}else{
  $arr = ['result' => false, 'contenido' => 'Ninguna coincidencia'];
}

die(json_encode($arr));
?>
