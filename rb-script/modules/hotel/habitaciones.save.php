<?php
/* parametros inciales */
$table_name = "hotel_habitacion";

/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];
$json_enseres = "[]";

/* ENSERES */
$all_enseres = [];

if( isset( $_POST['grupo_ensere'] ) ){
  $ensere_nombres = $_POST['grupo_ensere'];
  $cantidad = $_POST['grupo_cantidad'];

  $i=0;
  foreach($ensere_nombres as $ensere){
      $ensere = [
        'ensere' => $ensere_nombres[$i],
        'cantidad' => $cantidad[$i],
      ];
      array_push($all_enseres, $ensere);
    $i++;
  }
}
$json_enseres = json_encode($all_enseres, JSON_UNESCAPED_UNICODE);

$valores = [
  'numero_habitacion' => $_POST['numero_habitacion'],
  'tipo' => $_POST['tipo'],
  'detalles' => trim($_POST['detalles']),
  'servicios' => trim($_POST['servicios']),
  'galeria_id' => $_POST['galeria_id'],
	'precio' => $_POST['precio'],
	'enseres' => $json_enseres
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
?>
