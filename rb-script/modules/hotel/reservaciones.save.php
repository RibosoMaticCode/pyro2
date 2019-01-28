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

$id = $_POST['id'];
$productos = json_decode($_POST['productos_json'], true); // productos
//$mesa_id = $_POST['mesa_id'];
$estado = isset($_POST['estado']) ? $_POST['estado'] : 1;

$hora_llegada = " ".get_option('hora_llegada');
$hora_salida = " ".get_option('hora_salida');

// Validaciones
// --- Fecha salida mayor a la de llegada
if($_POST['fecha_salida'] <= $_POST['fecha_llegada']){
	$arr = ['resultado' => false, 'contenido' => 'La fecha de salida minimo es una dia despues de la de llegada.'];
	die(json_encode($arr));
}
// --- Fecha posterior no debe de reservar
$today = date('Y-m-d');
if($_POST['fecha_llegada'] < $today){
	$arr = ['resultado' => false, 'contenido' => 'La fecha de llegada no debe ser menor a la fecha de HOY.'];
	die(json_encode($arr));
}

if($id==0){ // Nuevo Reservacion
	$valores = [
	  'cliente_id' => $_POST['cliente_id'],
	  'habitacion_id' => $_POST['habitacion_id'],
	  'personal_id' => G_USERID,
	  'fecha_llegada' => trim($_POST['fecha_llegada'].$hora_llegada),
		'fecha_salida' => trim($_POST['fecha_salida'].$hora_salida),
	  'fecha_registro' => date('Y-m-d G:i:s'),
		'total_habitacion' => $_POST['total_habitacion'],
		'total_adicionales' => $_POST['total_extras'],
		'total_reservacion' => $_POST['total_final'],
		'estado' => $estado
	];

	$r = $objDataBase->Insert($table_name, $valores);
	if($r['result']){
		$reservacion_id = $r['insert_id'];
		$code_unique = date('Ymd').str_pad($r['insert_id'], 6, '0', STR_PAD_LEFT);
		$tot = 0;
		//
		if(count($productos)==0){ // No hay detalles
			$arr = ['resultado' => true, 'contenido' => 'Reservacion hecha' ];
		}else{ // Añadir si hay detalles
			// Recorrer en el json del detalle del reservacion

			foreach ($productos as $producto => $detalle) {
				$importe = round($detalle['prec'] * $detalle['cant'],2);
				$detalles = [
					'reservacion_id' => $reservacion_id,
					'producto_id' => $detalle['producto_id'],
					'precio' => $detalle['prec'],
					'cantidad' => $detalle['cant'],
					'subtotal' => $importe
				];
				$objDataBase->Insert('hotel_extras', $detalles);
				if($r['result']){
					$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
				}else{
					$arr = ['resultado' => false, 'contenido' => $r['error']];
					die(json_encode($arr));
				}
				$tot += $importe;
			}

			// Actualizar el monto total del reservacion
			$subtotal = round($tot / 1.18, 2);
			$igv = $tot - $subtotal;
		}
		$r = $objDataBase->Update($table_name, ['total_adicionales' =>$tot, 'codigo_unico' => $code_unique], ["id" => $reservacion_id]);
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
		die(json_encode($arr));
	}
}else{ // Update
	//print_r($productos); // $productos, contiene lista de productos en el reservacion temporal
	$valores = [
	  /*'habitacion_id' => $_POST['habitacion_id'],
	  'fecha_llegada' => trim($_POST['fecha_llegada'].$hora_llegada),
		'fecha_salida' => trim($_POST['fecha_salida'].$hora_salida),*/
		'total_habitacion' => $_POST['total_habitacion'],
		'total_adicionales' => $_POST['total_extras'],
		'total_reservacion' => $_POST['total_final'],
		'estado' => $estado
	];
	$r = $objDataBase->Update($table_name, $valores, ["id" => $id]);

  // Consultar todo el detalle del reservacion de la BD
	$qd = $objDataBase->Ejecutar("SELECT * FROM hotel_extras WHERE reservacion_id=".$id);

  // Creamos un array asociativo para comparar
	$ReservacionDetalle = [];
	$i=0;
	while($reservacion_detalle = $qd->fetch_assoc()){
	    $reservacion_id = $reservacion_detalle['producto_id'];

		$ReservacionDetalle[$reservacion_id]['producto_id']= $reservacion_detalle['producto_id']; //producto_id
		$ReservacionDetalle[$reservacion_id]['cant']= $reservacion_detalle['cantidad']; //cantidad
		$ReservacionDetalle[$reservacion_id]['prec']= $reservacion_detalle['precio']; //precio
		$i++;
	}
	//print_r($ReservacionDetalle); // Lista de productos del reservacion en BD

	// Restamos arrays
	$diff = array_diff_key($ReservacionDetalle, $productos); // La diferencia es un array que contiene los productos que seran eliminados del detalle del reservacion
	//print_r($diff);

	//die(); // test de arrays previos
  // Recorremos los productos en el reservacion temporal
	$tot = 0;
	foreach ($productos as $producto => $detalle) {
		// Consultar si reservacion_id y producto_id estan registrados
		$qd = $objDataBase->Ejecutar("SELECT * FROM hotel_extras WHERE reservacion_id=".$id." AND producto_id=".$detalle['producto_id']);
		if($qd->num_rows > 0){ // Si existe item,  actualizamos la cantidad

			$importe = round($detalle['prec'] * $detalle['cant'],2);
			$detalles = [
				'cantidad' => $detalle['cant'],
				'subtotal' => $importe
			];

			$r = $objDataBase->Update('hotel_extras', $detalles, [ 'reservacion_id' => $id, 'producto_id' => $detalle['producto_id'] ]);
			if($r['result']){
				$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
			}else{
				$arr = ['resultado' => false, 'contenido' => $detalle['producto_id'].$r['error']];
				die(json_encode($arr));
			}
			//echo $detalle['producto_id']."upd\n";
		}else{ // Si no existe, lo insertamos en la base de datos
			$importe = round($detalle['prec'] * $detalle['cant'],2);
			$detalles = [
				'reservacion_id' => $id,
				'producto_id' => $detalle['producto_id'],
				'precio' => $detalle['prec'],
				'cantidad' => $detalle['cant'],
				'subtotal' => $importe
			];

			$r = $objDataBase->Insert('hotel_extras', $detalles);
			if($r['result']){
				$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
			}else{
				$arr = ['resultado' => false, 'contenido' => $detalle['producto_id'].$r['error']];
				die(json_encode($arr));
			}
			//echo $detalle['producto_id']."new\n";
		}
		$tot += $importe;
	}
	// Actualizar el monto total del reservacion
	$subtotal = round($tot / 1.18, 2);
	$igv = $tot - $subtotal;
	$r = $objDataBase->Update('hotel_reservacion', ['total_adicionales' =>$tot], ["id" => $id]);

	// Eliminados productos del array
	foreach ($diff as $producto) {
	    $senten_del = "DELETE FROM hotel_extras WHERE reservacion_id=".$id." AND producto_id=".$producto['producto_id'];
	    $qp = $objDataBase->Ejecutar( $senten_del );
	}
	$arr = ['resultado' => true, 'contenido' => 'Reservacion actualizado' ];
}
die(json_encode($arr));
/*
$valores = [
  'cliente_id' => $_POST['cliente_id'],
  'habitacion_id' => $_POST['habitacion_id'],
  'personal_id' => G_USERID,
  'fecha_llegada' => trim($_POST['fecha_llegada']),
	'fecha_salida' => trim($_POST['fecha_salida']),
  'fecha_registro' => date('Y-m-d G:i:s')
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert($table_name, $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update($table_name, $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
*/
?>
