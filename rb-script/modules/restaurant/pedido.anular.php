<?php
/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$pedido_id = $_GET['pedido_id'];

$qp = $objDataBase->Ejecutar('SELECT * FROM rest_pedido WHERE id='.$pedido_id);
$pedido = $qp->fetch_assoc();

$valores = [
  'estado' => 0
];

$r = $objDataBase->Update('rest_pedido', $valores, ['id' => $pedido_id]);
if($r['result']){
  $arr = ['resultado' => true, 'contenido' => 'Pedido Anulado' ];
	$objDataBase->Update('rest_pedido_detalles', $valores, ['pedido_id' => $pedido_id]);
	// Liberamos mesa
	$objDataBase->Update('rest_mesa', $valores, [ 'id' => $pedido['mesa_id'] ]);
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
}
die(json_encode($arr));
