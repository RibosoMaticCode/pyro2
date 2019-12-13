<?php
/* start */
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['id'];
//$mode=$_POST['mode'];
$nom=$_POST['nombre'];

if($nom=="") {
	$arr = ['resultado' => false, 'contenido' => "Nombre del menu no debe quedar vacio"];
	die();
}

$valores = [
  'nombre' => $nom
];

if($id==0){
	$r = $objDataBase->Insert(G_PREFIX.'menus', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{
  $id=$_POST['id'];
	$r = $objDataBase->Update(G_PREFIX.'menus', $valores, ['id' => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}
die(json_encode($arr));
?>
