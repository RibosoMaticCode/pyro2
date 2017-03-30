<?php
$fname = $_GET['filename'];
$myfile = fopen($fname, "r") or die("¡No se puede abrir el archivo!");
$content = fread($myfile,filesize($fname));
echo $content;
fclose($myfile);
?>