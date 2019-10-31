<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$options = $_POST['options'];

foreach ($options as $key => $value) {
	$qc = $objDataBase->Ejecutar("SELECT * FROM hotel_config WHERE hotel_option = '$key'");
	if($qc->num_rows==0){
	  $valores = [
	    'hotel_option' => $key,
	    'hotel_value' => addslashes($value)
	  ];
	  $r = $objDataBase->Insert('hotel_config', $valores);
		if($r['result']){
			$arr = ['resultado' => true, 'contenido' => 'Valores nuevos añadidos' ];
		}else{
			$arr = ['resultado' => false, 'contenido' => $r['error']];
		}
	}else{
	  $valores = [
	    'hotel_value' => $value
	  ];
	  $where = [
	    'hotel_option' => $key,
	  ];
	  $r = $objDataBase->Update('hotel_config', $valores, $where);
		if($r['result']){
			$arr = ['resultado' => true, 'contenido' => 'Valores actualizados' ];
		}else{
			$arr = ['resultado' => false, 'contenido' => $r['error']];
		}
	}
}

die(json_encode($arr));
