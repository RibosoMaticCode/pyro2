<?php
if($_POST):
	$file_name = $_POST['file_name'];
	$file_content = $_POST['file_content'];
endif;
/*
//$my_file = 'file.txt';
$handle = fopen($file_name, 'w') or die('Cannot open file:  '.$file_name);
//$data = 'This is the data';
if(fwrite($handle, $file_content)):
	fclose($handle);
	die("Cambios grabados");
endif;
*/
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."rb-script/funciones.php");
if(rb_write_file($file_name, $file_content)) die("Cambios guardados");
?>
