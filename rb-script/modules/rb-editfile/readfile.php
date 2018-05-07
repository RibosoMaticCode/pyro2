<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."rb-script/funciones.php");
rb_disabled_cache();
$fname = $_GET['filename'];
$myfile = fopen($fname, "r") or die("¡No se puede abrir el archivo!");
$content = fread($myfile,filesize($fname));
echo $content;
fclose($myfile);
?>
