<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$options = $_POST['options'];

foreach ($options as $key => $value) {
	$qc = $objDataBase->Ejecutar("SELECT * FROM plm_config WHERE plm_option = '$key'");
	if($qc->num_rows==0){
	  $valores = [
	    'plm_option' => $key,
	    'plm_value' => addslashes($value)
	  ];
	  $r = $objDataBase->Insert('plm_config', $valores);
		if($r['result']){
			$arr = ['resultado' => true, 'contenido' => 'Valores nuevos añadidos' ];
		}else{
			$arr = ['resultado' => false, 'contenido' => $r['error']];
		}
	}else{
	  $valores = [
	    'plm_value' => $value
	  ];
	  $where = [
	    'plm_option' => $key,
	  ];
	  $r = $objDataBase->Update('plm_config', $valores, $where);
		if($r['result']){
			$arr = ['resultado' => true, 'contenido' => 'Valores actualizados' ];
		}else{
			$arr = ['resultado' => false, 'contenido' => $r['error']];
		}
	}
}

die(json_encode($arr));
