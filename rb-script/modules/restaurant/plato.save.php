<?php
/* parametros inciales */
$table_name = "rest_plato";

/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];

$valores = [
  'nombre' => $_POST['nombre'],
  'categoria' => $_POST['categoria'],
  'precio' => trim($_POST['precio']),
  'fecha_registro' => date('Y-m-d G:i:s'),
	'foto_id' => $_POST['foto_id_id']
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
