<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/modules/plm/funcs.php';

$coupon_code = $_GET['code'];

// Ajustar datos del total
$response = discount_adjust($coupon_code);

die(json_encode($response));
?>
