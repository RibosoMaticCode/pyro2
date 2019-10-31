<?php
if($_POST):
	$file_name = $_POST['file_name'];
	$file_content = $_POST['file_content'];

	if ( !defined('ABSPATH') )
		define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

	require_once(ABSPATH."rb-script/funcs.php");
	if(rb_write_file($file_name, $file_content)) die("Cambios guardados");
endif;
?>
