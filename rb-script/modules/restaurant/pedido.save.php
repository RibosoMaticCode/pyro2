<?php
/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once 'funcs.php';

$id = $_POST['id']; // pedido_id
$platos = json_decode($_POST['platos_json'], true);
$mesa_id = $_POST['mesa_id'];

// Obtenemos datos del empleado
$personal_codigo = $_POST['personal_code'];
$personal = get_rows('rest_personal', $personal_codigo, 'codigo');
if(!$personal){
	$arr = ['resultado' => false, 'contenido' => 'Codigo del personal no existe.'];
	die(json_encode($arr));
}else{
	$personal_id = $personal['id'];
}

if($id==0){ // Nuevo Pedido
	$valores = [
		'fecha_registro' => date('Y-m-d G:i:s'),
	  'personal_id' => $_POST['personal_code'], // id table
		'codigo' => $_POST['personal_code'],
	  'mesa_id' => $_POST['mesa_id'],
		'estado' => 1
	];

	$r = $objDataBase->Insert('rest_pedido', $valores);
	if($r['result']){
		$pedido_id = $r['insert_id'];
		// Añadir detalles
		// Recorrer en el json del detalle del pedido
		$tot = 0;
		foreach ($platos as $plato => $detalle) {
			$importe = round($detalle['prec'] * $detalle['cant'],2);
			$detalles = [
				'pedido_id' => $pedido_id,
				'plato_id' => $detalle['plato_id'],
				'precio' => $detalle['prec'],
				'hora_inicio' => date('Y-m-d G:i:s'),
				'cantidad' => $detalle['cant'],
				'codigo' => $personal_id,
				'subtotal' => $importe,
				'estado' => 1
			];
			$objDataBase->Insert('rest_pedido_detalles', $detalles);
			if($r['result']){
				$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
			}else{
				$arr = ['resultado' => false, 'contenido' => $r['error']];
				die(json_encode($arr));
			}
			$tot += $importe;
		}
		// Actualizar estado de la mesa
		$r = $objDataBase->Update('rest_mesa', ['estado' => 1], ["id" => $mesa_id]);

		// Actualizar el monto total del pedido
		$subtotal = round($tot / 1.18, 2);
		$igv = $tot - $subtotal;
		$r = $objDataBase->Update('rest_pedido', ['igv' => $igv, 'subtotal' => $subtotal, 'total' =>$tot], ["id" => $pedido_id]);
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
		die(json_encode($arr));
	}
}else{ // Update
	//print_r($platos); // $platos, contiene lista de platos en el pedido temporal

  // Consultar todo el detalle del pedido de la BD
	$qd = $objDataBase->Ejecutar("SELECT * FROM rest_pedido_detalles WHERE pedido_id=".$id);

  // Creamos un array asociativo para comparar
	$PedidoDetalle = [];
	$i=0;
	while($pedido_detalle = $qd->fetch_assoc()){
	    $pedido_id = $pedido_detalle['plato_id'];

		$PedidoDetalle[$pedido_id]['plato_id']= $pedido_detalle['plato_id']; //plato_id
		$PedidoDetalle[$pedido_id]['cant']= $pedido_detalle['cantidad']; //cantidad
		$PedidoDetalle[$pedido_id]['prec']= $pedido_detalle['precio']; //precio
		$i++;
	}
	//print_r($PedidoDetalle); // Lista de platos del pedido en BD

	// Restamos arrays
	$diff = array_diff_key($PedidoDetalle, $platos); // La diferencia es un array que contiene los platos que seran eliminados del detalle del pedido
	//print_r($diff);

	//die(); // test de arrays previos
  // Recorremos los platos en el pedido temporal
	$tot = 0;
	foreach ($platos as $plato => $detalle) {
		// Consultar si pedido_id y plato_id estan registrados
		$qd = $objDataBase->Ejecutar("SELECT * FROM rest_pedido_detalles WHERE pedido_id=".$id." AND plato_id=".$detalle['plato_id']);
		if($qd->num_rows > 0){ // Si existe item,  actualizamos la cantidad

			$importe = round($detalle['prec'] * $detalle['cant'],2);
			$detalles = [
				'cantidad' => $detalle['cant'],
				'subtotal' => $importe
			];

			$r = $objDataBase->Update('rest_pedido_detalles', $detalles, [ 'pedido_id' => $id, 'plato_id' => $detalle['plato_id'] ]);
			if($r['result']){
				$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
			}else{
				$arr = ['resultado' => false, 'contenido' => $detalle['plato_id'].$r['error']];
				die(json_encode($arr));
			}
			//echo $detalle['plato_id']."upd\n";
		}else{ // Si no existe, lo insertamos en la base de datos
			$importe = round($detalle['prec'] * $detalle['cant'],2);
			$detalles = [
				'pedido_id' => $id,
				'plato_id' => $detalle['plato_id'],
				'precio' => $detalle['prec'],
				'hora_inicio' => date('Y-m-d G:i:s'),
				'cantidad' => $detalle['cant'],
				'codigo' => $_POST['personal_code'],
				'subtotal' => $importe,
				'estado' => 1
			];

			$r = $objDataBase->Insert('rest_pedido_detalles', $detalles);
			if($r['result']){
				$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
			}else{
				$arr = ['resultado' => false, 'contenido' => $detalle['plato_id'].$r['error']];
				die(json_encode($arr));
			}
			//echo $detalle['plato_id']."new\n";
		}
		$tot += $importe;
	}
	// Actualizar el monto total del pedido
	$subtotal = round($tot / 1.18, 2);
	$igv = $tot - $subtotal;
	$r = $objDataBase->Update('rest_pedido', ['igv' => $igv, 'subtotal' => $subtotal, 'total' =>$tot], ["id" => $id]);

	// Eliminados platos del array
	foreach ($diff as $plato) {
	    $senten_del = "DELETE FROM rest_pedido_detalles WHERE pedido_id=".$id." AND plato_id=".$plato['plato_id'];
	    $qp = $objDataBase->Ejecutar( $senten_del );
	}
	$arr = ['resultado' => true, 'contenido' => 'Pedido actualizado' ];
}
die(json_encode($arr));
?>
