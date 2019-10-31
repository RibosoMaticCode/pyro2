<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$mode=$_POST['mode'];
$nom = $_POST['nombre'];
$des = $_POST['descripcion'];
$niv = $_POST['nivel_enlace'];
$subniv = $_POST['subnivel_enlace'];

$valores = [
	'nombre' => $nom,
	'descripcion' => $des,
	'nivel_enlace' => $niv,
	'subnivel_enlace' => $subniv
];

if($mode=="new"){
	$result = $objDataBase->Insert(G_PREFIX.'users_levels',$valores);
	if($result['result']){
		$ultimo_id=$result['insert_id'];
		$enlace=G_SERVER.'rb-admin/index.php?pag=nivel&opc=edt&id='.$ultimo_id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo $result['error'];
	}
}elseif($mode=="update"){
	$id=$_POST['id'];
	$result = $objDataBase->Update(G_PREFIX.'users_levels',$valores,['id' => $id]);
	if($result['result']){
		$enlace=G_SERVER.'rb-admin/index.php?pag=nivel&opc=edt&id='.$id."&m=ok";
		header('Location: '.$enlace);
	}else{
		echo $result['error'];
	}
}
?>
