<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

// Modo
$mode=$_POST['mode'];

// variables
$id = $_POST['id'];
$nom = $_POST['nombre'];
$des = $_POST['descripcion'];
$nom_id=$_POST['titulo_enlace'];
$user_id = $_POST['user_id'];
$galeria_grupo = $_POST['grupo'];
$imgfondo_id = $_POST['imgfondo_id'];

if(empty($nom_id)){
  $nom_id = rb_cambiar_nombre($_POST['nombre']);
}

// tipo de accion
if($mode=="new"){
  $result = $objDataBase->Insertar("INSERT INTO albums (nombre, descripcion, imagenes, fecha, nombre_enlace, galeria_grupo, usuario_id, photo_id) VALUES ('$nom','$des',0,NOW(),'$nom_id','$galeria_grupo', $user_id, $imgfondo_id)");
  if($result){
    $ultimo_id=$result['insert_id'];
  }else {
    die("error");
  }
  $urlreload=G_SERVER.'/rb-admin/index.php?pag=gal&opc=edt&id='.$ultimo_id."&m=ok";
  header('Location: '.$urlreload);
}elseif($mode=="update"){
  $id = $_POST['id'];
  $objDataBase->Ejecutar("UPDATE albums SET nombre='$nom', descripcion='$des', nombre_enlace = '$nom_id', galeria_grupo= '$galeria_grupo', photo_id = $imgfondo_id WHERE id = $id");
  $urlreload=G_SERVER.'/rb-admin/index.php?pag=gal&opc=edt&id='.$id."&m=ok";
  header('Location: '.$urlreload);
}
?>
