<?php
/* parametros inciales */
$table_name = "hotel_reservacion";

/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once 'funcs.php';

$id = $_GET['id'];
$codigo = $_GET['code_customer'];
$reservacion = get_rows('hotel_reservacion', $id, 'id');
if($reservacion['codigo_secreto_cliente']!=$codigo){
	$arr = ['resultado' => false, 'contenido' => 'Codigo secreto no coincide'];
	die(json_encode($arr));
}

$estado = $_GET['estado'];
switch($estado){
	case 1: // Si esta reservado
		$new_estado = 0;
		$msg = "Reservacion cancelada";
	break;
	case 2: // Si esta ocupado
		$new_estado = 3;
		$msg = "Reservacion y estadia finalizada";
	break;
}
$valores = [
  'estado' => $new_estado,
	'fecha_finalizacion' => date('Y-m-d G:i:s')
];

$r = $objDataBase->Update($table_name, $valores, ["id" => $id]);
if($r['result']){
  $arr = ['resultado' => true, 'contenido' => $msg];
  die(json_encode($arr));
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
  die(json_encode($arr));
}
