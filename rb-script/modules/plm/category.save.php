<?php
/* parametros inciales */
$table_name = "plm_category";

/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];
$islink = 1; // nombre de categoria servira como link
if(isset($_POST['link'])){
	$islink = 0;
}

$valores = [
  'nombre' => $_POST['nombre'],
  'nombre_enlace' => rb_cambiar_nombre(trim($_POST['nombre'])),
  'descripcion' => trim($_POST['descripcion']),
	'foto_id' => $_POST['foto_id_id'],
	'parent_id' => $_POST['parent_id'],
	'islink' => $islink
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
