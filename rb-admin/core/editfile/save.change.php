<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";

if(G_ACCESOUSUARIO>0){
	require_once ABSPATH."rb-script/funcs.php";

	if($_POST):
		$file_name = $_POST['file_name'];
		$file_content = $_POST['file_content'];
	endif;

	if(rb_write_file($file_name, $file_content)) die("Cambios guardados");
}else {
	die("No cuenta con permiso para realizar la accion. Inicie sesion");
}
?>
