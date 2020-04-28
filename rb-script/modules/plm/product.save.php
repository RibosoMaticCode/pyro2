<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$id = $_POST['id'];
$nombre_key = rb_cambiar_nombre(utf8_encode(trim($_POST['nombre'])));

$prec = $_POST['precio'];
$desc = $_POST['descuento'];
if($prec > 0 && $desc > 0){
	$prec_desc = round($prec - ($prec * ($desc/100)), 2);
}else{
	$prec_desc =	0;//$_POST['precio_oferta'];
}

// Validaciones 
if($_POST['categoria']=="0"){
	$arr = ['resultado' => false, 'contenido' => 'Debe seleccionar una categoria, o creala'];
	die(json_encode($arr));
}

// Asignacion valores
$valores = [
  'nombre' => $_POST['nombre'],
  'nombre_key' => $nombre_key,
  'precio' => $prec,
	'descuento' => $desc,
  'precio_oferta' => $prec_desc,
	'marca' => $_POST['marca'],
	'modelo' => $_POST['modelo'],
  'descripcion' => $_POST['descripcion'],
  'tipo_envio' => trim($_POST['tipo_envio']),
  'foto_id' => trim($_POST['foto_id_id']),
  'galeria_id' => trim($_POST['galeria_id']),
  'fecha_registro' => date('Y-m-d G:i:s'),
  'categoria' => $_POST['categoria'],
  'usuario_id' => G_USERID,
	'estado' => $_POST['estado'],
	'sku' => $_POST['sku'],
	'options' => $_POST['opciones'],
	'options_variants' => $_POST['array_combos']
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('plm_products', $valores);
	if($r['result']){
		$product_id = $r['insert_id'];
		/* GRUPO DE OPCIONES */
		if(isset($_POST['variant_name'])){
		  $names = $_POST['variant_name'];
		  $prices = $_POST['variant_price'];
			$states = $_POST['variant_state'];
			$visibles = $_POST['variant_visible'];
			$galleries = $_POST['variant_gallery_id'];


		  $i=0;
		  foreach($names as $name){
				if($prices[$i] > 0 && $desc > 0){
					$price_desc = round($prices[$i] - ($prices[$i] * ($desc/100)), 2);
				}else{
					$price_desc =	0;
				}
				$variant = [
					'product_id' =>$product_id,
					'variant_id' => $product_id.($i+1),
		      'name' => $names[$i],
		      'price' => $prices[$i],
					'discount' => $desc,
					'price_discount' => $price_desc,
		      'state' => $states[$i],
		      'visible' => $visibles[$i],
		      'image_id' => $galleries[$i]
				];
				$objDataBase->Insert('plm_products_variants', $variant);
		    $i++;
		  }
		}
		$arr = ['resultado' => true, 'contenido' => 'Elemento añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('plm_products', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado', 'id' => $id ];
		/* GRUPO DE OPCIONES */
		if(isset($_POST['variant_name'])){
			// Eliminamos combinacions previas
			$objDataBase->Ejecutar('DELETE FROM plm_products_variants WHERE product_id='.$id);

		  $names = $_POST['variant_name'];
		  $prices = $_POST['variant_price'];
			$states = $_POST['variant_state'];
			$visibles = $_POST['variant_visible'];
			$galleries = $_POST['variant_gallery_id'];

		  $i=0;
		  foreach($names as $name){
				if($prices[$i] > 0 && $desc > 0){
					$price_desc = round($prices[$i] - ($prices[$i] * ($desc/100)), 2);
				}else{
					$price_desc =	0;
				}
				$variant = [
					'product_id' =>$id,
					'variant_id' => $id.($i+1),
		      'name' => $names[$i],
		      'price' => $prices[$i],
					'discount' => $desc,
					'price_discount' => $price_desc,
		      'state' => $states[$i],
		      'visible' => $visibles[$i],
		      'image_id' => $galleries[$i]
				];
				$objDataBase->Insert('plm_products_variants', $variant);
		    $i++;
		  }
		}
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}
die(json_encode($arr));
?>
