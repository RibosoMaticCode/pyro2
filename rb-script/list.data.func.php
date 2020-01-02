<?php
/*
Lista datos, recibidos en formato cadena (como JSON) mediante metodo POST
La cadena de texto recibida, contiene nombre de tabla, y nombres de columnas a mostrar
El resultado es retornado en formato JSON
*/
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$dataJson = $_POST['dataToSend'];
$function = $dataJson['function'];
$parameters = explode(",", $dataJson['parameters']);

$result = call_user_func_array($function, $parameters);

die(json_encode($result));
?>
