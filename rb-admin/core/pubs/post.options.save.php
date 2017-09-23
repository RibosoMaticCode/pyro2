<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."rb-script/funciones.php");

header('Content-Type: application/json');

if(!isset($_REQUEST['post_options'])) {
	// Si no hay ninguno seleccionado, creamos un array vacio
	$array_post_options = array();
}else{
	$array_post_options = $_REQUEST['post_options'];
}

// Sino existe algun modulo lo agregamos y su valor por defecto = 1
if (!array_key_exists('gal', $array_post_options)) $array_post_options['gal'] = 0;
if (!array_key_exists('edi', $array_post_options)) $array_post_options['edi'] = 0;
if (!array_key_exists('adi', $array_post_options)) $array_post_options['adi'] = 0;
if (!array_key_exists('adj', $array_post_options)) $array_post_options['adj'] = 0;
if (!array_key_exists('enl', $array_post_options)) $array_post_options['enl'] = 0;
if (!array_key_exists('vid', $array_post_options)) $array_post_options['vid'] = 0;
if (!array_key_exists('cal', $array_post_options)) $array_post_options['cal'] = 0;
if (!array_key_exists('otr', $array_post_options)) $array_post_options['otr'] = 0;
if (!array_key_exists('sub', $array_post_options)) $array_post_options['sub'] = 0;

$array_post_options_json = json_encode($array_post_options);
if(rb_set_values_options('post_options',$array_post_options_json)):
	$json_post_options = rb_get_values_options('post_options');
	$array_post_options = json_encode($json_post_options, true);
	die($array_post_options);
else:
	die("0");
endif;
?>
