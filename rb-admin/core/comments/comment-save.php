<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$id=$_POST['id'];
$com=$_POST['comentario'];
$web=$_POST['web'];
$autor=$_POST['autor'];
$mail=$_POST['mail'];

$campos = array( $autor, $com, $mail, $web );
$q = "UPDATE comentarios SET nombre='".$campos[0]."', contenido='".$campos[1]."', mail='".$campos[2]."', web='".$campos[3]."' WHERE id=$id";

if( $objDataBase->Ejecutar($q) ){
  $enlace=G_SERVER."/rb-admin/index.php?pag=com&opc=edt&id=".$id;
  header('Location: '.$enlace);
}else{
  echo "Hubo unos incovenientes";
}
?>
