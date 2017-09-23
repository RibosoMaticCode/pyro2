<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$id=$_GET['pub_id'];
$estado=$_GET['estado'];

$q = "UPDATE usuarios SET activo= $estado WHERE id= $id";

if( $objDataBase->Consultar($q) ):	
	$q_active = $objDataBase->Consultar("SELECT activo FROM usuarios WHERE id= $id");
	$row = mysql_fetch_array($q_active);
	
	if($row['activo']==1){
		$arr = array('resultado' => 'ok', 
					'title' => 'Click  para Desactivar',
					'estado' => 0,
					'html' => 'Activo'
				 	);	
	}elseif($row['activo']==0){
		$arr = array('resultado' => 'ok', 
					'title' => 'Click para Activar',
					'estado' => 1,
					'html' => 'Inactivo'
				 	);
	}
else
	$arr = array('resultado' => 'bad', 'contenido' => 'Error' );
endif;
die(json_encode($arr));
?>