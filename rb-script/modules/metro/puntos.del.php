<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$pto_id = $_GET['pto_id'];

if($objDataBase->Consultar("DELETE FROM metro_puntos WHERE id=$pto_id")):
	die('1');
else:
	die('0');
endif;
?>
