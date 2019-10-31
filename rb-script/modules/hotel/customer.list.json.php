<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$qr = $objDataBase->Ejecutar("SELECT * FROM crm_customers ORDER BY id DESC");
$customers = [];
// 1er metodo
while ( $customer = $qr->fetch_assoc() ){
    $customers[] = json_encode($customer);
}
// 2do metodo
//$customers = $qr->fetch_all( MYSQLI_ASSOC );

echo "[".json_encode($customers)."]";
