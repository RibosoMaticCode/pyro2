<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$titulo = $_POST['title'];
if(empty($_POST['title_enlace'])) $titulo_enlace = rb_cambiar_nombre(utf8_encode($titulo));
else $titulo_enlace = $_POST['title_enlace'];
$contenido = $_POST['content'];
$menu_id = 0; // Obsoleto
$autor_id = G_USERID;
$mode = $_POST['mode'];
$pagina_id = $_POST['pid'];
$sh = $_POST['sh'];
$sf = $_POST['sf'];
$hcust_id = $_POST['h_cust_id'];
$fcust_id = $_POST['f_cust_id'];
header('Content-type: application/json; charset=utf-8');
if($mode=="new"):
	$q = "INSERT INTO paginas (fecha_creacion, titulo, titulo_enlace, autor_id, contenido, menu_id, show_header, show_footer, header_custom_id, footer_custom_id ) VALUES (NOW(), '$titulo', '$titulo_enlace', $autor_id, '$contenido', $menu_id, $sh, $sf, '$hcust_id', '$fcust_id')";
	$result = $objDataBase->Insertar($q);
	if($result):
		$arr = array('resultado' => 'ok', 'contenido' => 'Pagina guardada', 'url' => G_SERVER, 'last_id' => $result['insert_id'] );
		die(json_encode($arr));
	else:
		$arr = array('resultado' => 'bad', 'contenido' => $result['error'] );
		die(json_encode($arr));
	endif;
elseif($mode=="update"):
	$q = "UPDATE paginas SET titulo='$titulo', titulo_enlace = '$titulo_enlace', contenido = '$contenido', menu_id = $menu_id, show_header = $sh, show_footer = $sf, header_custom_id = '$hcust_id', footer_custom_id = '$fcust_id' WHERE id= $pagina_id";
	if($result = $objDataBase->Ejecutar($q)):
		$arr = array('resultado' => 'ok', 'contenido' => 'Pagina actualizada', 'url' => G_SERVER, 'last_id' => $pagina_id );
		die(json_encode($arr));
	else:
		$error = $result->error;
		$arr = array('resultado' => 'bad', 'contenido' => $error );
		die(json_encode($arr));
	endif;
endif;
?>
