<?php
/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$pedido_id = $_GET['pedido_id'];
$plato_id = $_GET['plato_id'];
$valores = [
  'hora_termino' => date('Y-m-d G:i:s')
];

$r = $objDataBase->Update('rest_pedido_detalles', $valores, ['pedido_id' => $pedido_id, 'plato_id' => $plato_id]);
if($r['result']){
  $arr = ['resultado' => true, 'contenido' => 'Plato atendido' ];
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
}
die(json_encode($arr));
