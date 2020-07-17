<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';
// Modo
$mode=$_POST['mode'];

// Tipo acceso
$acceso=$_POST['acceso'];
if($acceso=="privat"):
  // Niveles
  if(!isset($_REQUEST['niveles'])) {
    print "[!] Debe seleccionar al menos un nivel de acceso!!!";
  }
  $niveles = "";
  $coma= "";
  foreach($_REQUEST['niveles'] as $nivel){
    $niveles .= $coma.$nivel;
    $coma =",";
  }
endif;

// definiendo valores
$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['nombre']));

if(empty($_POST['nombre_enlace'])){
  $nomOcul = rb_cambiar_nombre(utf8_encode($_POST['nombre']));
}else{
  $nomOcul = rb_cambiar_nombre(utf8_encode( $_POST['nombre_enlace'] ));
}

$nomVis = $_POST['nombre'];
$des = $_POST['descripcion'];
$catpadre = $_POST['parent_id'];
$nivel = $_POST['nivel'];
$photo_id = $_POST['imagen-categoria_id'];
// validates
if($nomVis=="") die("Falta nombre de la categoria");

$values = [
	'nombre_enlace' => $nomOcul,
	'nombre' => $nomVis,
	'descripcion' => $des,
	'categoria_id' => $catpadre,
	'nivel' => $nivel,
	'photo_id' => $photo_id,
	'acceso' => $acceso,
	'niveles' => $niveles
];

// tipo de accion
if($mode=="new"){
  $result = $objDataBase->Insert( 'blog_categories', $values );
  if($result['result']){
		$ultimo_id= $result['insert_id'];
		$enlace=G_SERVER.'rb-admin/module.php?pag=rb_blog_category'; //&cat_id='.$ultimo_id;
		header('Location: '.$enlace);
	}else{
		die("Error: ".$result['error']);
	}
}elseif($mode=="update"){
  $id=$_POST['id'];
	$result = $objDataBase->Update( 'blog_categories', $values, ['id' => $id] );
  if($result['result']){
		$enlace=G_SERVER.'rb-admin/module.php?pag=rb_blog_category'; //&cat_id='.$id;
		header('Location: '.$enlace);
	}else{
		die("Error: ".$result['error']);
	}
}
?>
