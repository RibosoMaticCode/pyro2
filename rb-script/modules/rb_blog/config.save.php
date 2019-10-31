<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$options = $_POST['options'];

foreach ($options as $key => $value) {
	$qc = $objDataBase->Ejecutar("SELECT * FROM blog_config WHERE blog_option = '$key'");
	if($qc->num_rows==0){
	  $valores = [
	    'blog_option' => $key,
	    'blog_value' => addslashes($value)
	  ];
	  $r = $objDataBase->Insert('blog_config', $valores);
		if($r['result']){
			$arr = ['resultado' => true, 'contenido' => 'Valores nuevos añadidos' ];
		}else{
			$arr = ['resultado' => false, 'contenido' => $r['error']];
		}
	}else{
	  $valores = [
	    'blog_value' => $value
	  ];
	  $where = [
	    'blog_option' => $key,
	  ];
	  $r = $objDataBase->Update('blog_config', $valores, $where);
		if($r['result']){
			$arr = ['resultado' => true, 'contenido' => 'Valores actualizados' ];
		}else{
			$arr = ['resultado' => false, 'contenido' => $r['error']];
		}
	}
}

die(json_encode($arr));
