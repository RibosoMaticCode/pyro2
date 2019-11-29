<?php
/*
Inserta datos, recibidos en formato cadena (como JSON) mediante metodo POST
La cadena de texto recibida, contiene nombre de tabla, nombre de campos y sus valores a insertar
El resultado es retornado en formato JSON
*/
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

if(!G_ACCESOUSUARIO){
	$arr = array('result' => false, 'message' => 'No puede completarse esta accion, por que usuario no inicio sesion' );
  die(json_encode($arr));
}

$dataJson = $_POST['dataToSend'];
$tableName = $dataJson['table'];
$dataToSave = $dataJson['dataToSave'];

foreach ($dataJson['dataToSave'] as $key => $value) {
  $dataToSave[$key] = $value;
}

$r = $objDataBase->Insert($tableName, $dataToSave);
if($r['result']){
	$arr = ['result' => true, 'message' => 'Elemento añadido', 'new_id' => $r['insert_id'] ];
}else{
	$arr = ['result' => false, 'message' => $r['error']];
}

die(json_encode($arr));
?>
