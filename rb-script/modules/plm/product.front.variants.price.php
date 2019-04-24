<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$combo = $_GET['combo'];
$product_id = $_GET['product_id'];

$q = "SELECT * FROM plm_products_variants WHERE name='".$combo."' AND product_id=".$product_id;

$qr = $objDataBase->Ejecutar($q);
if($qr->num_rows > 0){
  $variant = $qr->fetch_assoc();
  $precio_normal = $variant['price'];
  $descuento = $variant['discount'];
  $precio_oferta = $variant['price_discount'];
	$variant_id = $variant['variant_id'];
	$image = rb_get_photo_details_from_id($variant['image_id']);
	$image_url = $image['file_url'];

  $html = '';
  if($descuento>0){
    $html .= '<div class="cols-container">
      <div class="cols-6-md">
        <strong>Precio normal:</strong>
      </div>
      <div class="cols-6-md">
        <span style="text-decoration:line-through">'.G_COIN.' '.number_format($precio_normal, 2).'</span>
      </div>
    </div>';
  }

  $html .= '<div class="cols-container">
    <div class="cols-6-md">
      <strong>Precio final:</strong>
    </div>
    <div class="cols-6-md">';

  if($descuento>0):
    $html .='<span class="highlight">'.G_COIN.' '.number_format($precio_oferta, 2).'</span>';
  else:
    $html .='<span class="highlight">'.G_COIN.' '.number_format($precio_normal, 2).'</span>';
  endif;

  $html .='</div></div>';

  if($descuento>0){
    $html .= '<div class="cols-container">
      <div class="cols-6-md">
        <strong>Ahorras:</strong>
      </div>
      <div class="cols-6-md">
        <span class="highlight">'.G_COIN.' '.number_format($precio_normal - $precio_oferta, 2).'</span> ('.$descuento.'%)
      </div>
    </div>';
  }

  $arr = [
		'result' => true,
		'price' => $precio_normal,
		'discount' => $descuento,
		'price_discount' => $precio_oferta,
		'html' => $html,
		'variant_id' => $variant_id,
		'image_url' => $image_url
	];
}else{
  $arr = ['result' => false, 'contenido' => 'Ninguna coincidencia'];
}

die(json_encode($arr));
?>
