<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$valores = [
  'opcion' => 'campos',
  'valor' => $_POST['campos'],
]; 

// Verificar si campo de opcion existe
$q = $objDataBase->Ejecutar("SELECT * FROM suscriptores_config WHERE opcion='campos'");
if($q->num_rows > 0){ // Si existe solo actualiza
	$r = $objDataBase->Update('suscriptores_config', $valores, ["opcion" => 'campos']);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Configuracion actualizada' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Sino creamos el campos
    $r = $objDataBase->Insert('suscriptores_config', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Configuracion actualizada' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}

die(json_encode($arr));
?>
