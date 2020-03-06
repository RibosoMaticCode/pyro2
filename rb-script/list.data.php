<?php
/*
Lista datos, recibidos en formato cadena (como JSON) mediante metodo POST
La cadena de texto recibida, contiene nombre de tabla, y nombres de columnas a mostrar
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
//print_r($_POST['dataToSend']);

$dataJson = $_POST['dataToSend'];
$tableName = $dataJson['table'];
$colsToShow = $dataJson['colsToShow'];
//echo $dataJson['condition'];

$string_condition = "";
if( isset($dataJson['condition']) ){
	$string_condition = " WHERE";
	$and = " ";
	foreach ($dataJson['condition'] as $key => $value) {
		$string_condition .= $and."`".$key."`='".$value."'";
		$and = " AND ";
	}

}
//check:
//echo "SELECT $colsToShow FROM $tableName $string_condition";
$q = $objDataBase->Ejecutar("SELECT $colsToShow FROM $tableName $string_condition");
$rows = $q->fetch_all(MYSQLI_ASSOC);

die(json_encode($rows));

/* MODO DE USO
function updateListGalleries(){
	var postData = {
		'table': 'py_galleries',
		'colsToShow': 'id, nombre',
		'condition' : {
			'id' : $id
		}
	}
	$.ajax({
		method: "post",
		url: "<?= G_SERVER ?>rb-script/list.data.php",
		data: {dataToSend: postData}
	})
	.done(function( response ) {
		console.log(response);
	});
}
*/
?>
