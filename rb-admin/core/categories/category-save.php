<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';
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
$catpadre = $_POST['catid'];
$nivel = $_POST['nivel'];
$photo_id = $_POST['imagen-categoria_id'];
// validates
if($nomVis=="") die("Falta nombre de la categoria");

// tipo de accion
if($mode=="new"){
  $campos = array($nomOcul,$nomVis,$des,$catpadre,$nivel,$photo_id);
  $q = "INSERT INTO categorias (nombre_enlace, nombre, descripcion, categoria_id, nivel, photo_id) VALUES ('".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",".$campos[4].", $campos[5] )";
  $result = $objDataBase->Insertar( $q );
  if($result) $ultimo_id= $result['insert_id'];
  else die("Error");

  // Actualizamos niveles de acceso en post
  $objDataBase->Ejecutar("UPDATE categorias SET acceso = '$acceso', niveles = '$niveles' WHERE id = $ultimo_id");

  $enlace=G_SERVER.'/rb-admin/index.php?pag=cat&opc=edt&id='.$ultimo_id;
  header('Location: '.$enlace);
}elseif($mode=="update"){
  $id=$_POST['id'];
  $campos = array($nomOcul,$nomVis,$des,$catpadre,$nivel,$photo_id);
  $q = "UPDATE categorias SET nombre_enlace='".$campos[0]."', nombre='".$campos[1]."', descripcion='".$campos[2]."', categoria_id=".$campos[3].", nivel=".$campos[4].", photo_id = ".$campos[5]." WHERE id=".$id;
  $objDataBase->Ejecutar( $q );

  // Actualizamos niveles de acceso en post
  $objDataBase->Ejecutar("UPDATE categorias SET acceso = '$acceso', niveles = '$niveles' WHERE id = $id");

  $enlace=G_SERVER.'/rb-admin/index.php?pag=cat&opc=edt&id='.$id;
  header('Location: '.$enlace);
}
?>
