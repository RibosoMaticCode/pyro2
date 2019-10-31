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
$private = isset($_POST['private']) ? 1 : 0;

if(empty($nom_id)){
  $nom_id = rb_cambiar_nombre($_POST['nombre']);
}

// tipo de accion
if($mode=="new"){
	$valores = [
		'nombre' => $nom,
		'descripcion' => $des,
		'imagenes' => 0,
		'fecha' => date('Y-m-d G:i:s'),
		'nombre_enlace' => $nom_id,
		'galeria_grupo' => $galeria_grupo,
		'usuario_id' => G_USERID,
		'photo_id' => $imgfondo_id,
		'private' => $private
	];
	$result = $objDataBase->Insert(G_PREFIX.'galleries', $valores);
  if($result['result']){
		$ultimo_id = $result['insert_id'];
  }else {
    die("error");
  }
  $urlreload=G_SERVER.'rb-admin/index.php?pag=gal&opc=edt&id='.$ultimo_id."&m=ok";
  header('Location: '.$urlreload);
}elseif($mode=="update"){
	$valores = [
		'nombre' => $nom,
		'descripcion' => $des,
		'nombre_enlace' => $nom_id,
		'galeria_grupo' => $galeria_grupo,
		'photo_id' => $imgfondo_id,
		'private' => $private
	];

  $id = $_POST['id'];
	$result = $objDataBase->Update(G_PREFIX.'galleries', $valores, ["id" => $id]);

  $urlreload=G_SERVER.'rb-admin/index.php?pag=gal&opc=edt&id='.$id."&m=ok";
  header('Location: '.$urlreload);
}
?>
