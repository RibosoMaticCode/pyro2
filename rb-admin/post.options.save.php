<?php
//include 'islogged.php';
require_once("../rb-script/class/rb-opciones.class.php");

if(!isset($_REQUEST['post_options'])) {
	die("[!] Debe seleccionar al menos una sección ... !!!");
}
$array_post_options = $_REQUEST['post_options'];
		/*echo "<pre>"; // array solo con checkinput seleccionados
		print_r($array_post_options);
		echo "</pre>";*/

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
if($objOpcion->modificar_valor(1,'post_options',$array_post_options_json)):
	die("1");
else:
	die("0");
endif;
?>
