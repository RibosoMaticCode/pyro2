<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$id = $_POST['id'];
$nombre_key = rb_cambiar_nombre(utf8_encode(trim($_POST['nombre'])));

$prec = $_POST['precio'];
$desc = $_POST['descuento'];
if($prec > 0 && $desc > 0){
	$prec_desc = round($prec - ($prec * ($desc/100)), 2);
}else{
	$prec_desc =	$_POST['precio_oferta'];
}


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
	'sku' => $_POST['sku']
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('plm_products', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('plm_products', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado', 'id' => $id ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}
die(json_encode($arr));
?>
