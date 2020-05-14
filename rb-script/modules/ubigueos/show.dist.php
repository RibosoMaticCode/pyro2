<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$prov_id = $_GET['prov_id'];

$res_distr = $objDataBase->Ejecutar("SELECT * FROM ubdistrito WHERE idProv=".$prov_id);
$distr = $res_distr->fetch_all(MYSQLI_ASSOC);
die( json_encode($distr) );
