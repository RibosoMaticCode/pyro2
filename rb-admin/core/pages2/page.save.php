<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-paginas.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$titulo = $_GET['title'];
$pagina_id = $_GET['pid'];
$autor_id = G_USERID;

if($pagina_id==0):
	$titulo_enlace = rb_cambiar_nombre(utf8_encode($titulo));	
	
	if($objPagina->Consultar("INSERT INTO paginas (fecha_creacion, titulo, titulo_enlace, autor_id, bloques) VALUES (NOW(), '$titulo', '$titulo_enlace', $autor_id, 1) ")):
		$ultimo_id=mysql_insert_id();
		echo $ultimo_id;
	else:
		echo "0";
	endif;
elseif($pagina_id>0):
	
endif;
?>