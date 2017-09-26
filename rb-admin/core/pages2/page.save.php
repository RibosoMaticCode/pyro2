<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$titulo = $_GET['title'];
$titulo_enlace = rb_cambiar_nombre(utf8_encode($titulo));
$contenido = addslashes($_GET['content']);
$autor_id = G_USERID;
//print_r(json_decode($contenido));
$q = "INSERT INTO paginas (fecha_creacion, titulo, titulo_enlace, autor_id, contenido) VALUES (NOW(), '$titulo', '$titulo_enlace', $autor_id, '$contenido')";
echo $q;

if($objDataBase->Ejecutar($q)){
	echo "good";
}else{
	echo "bad";
}
?>
