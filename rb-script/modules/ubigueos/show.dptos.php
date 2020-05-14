<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$res_dptos = $objDataBase->Ejecutar("SELECT * FROM ubdepartamento ORDER BY departamento ASC");
$dptos = $res_dptos->fetch_all(MYSQLI_ASSOC);
die( json_encode($dptos) );
