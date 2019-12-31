<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

if(G_ACCESOUSUARIO>0){
	if(empty($_POST['title_enlace'])) $titulo_enlace = rb_cambiar_nombre(utf8_encode(trim($_POST['title'])));
	else $titulo_enlace = $_POST['title_enlace'];
	$mode = $_POST['mode'];
	$pagina_id = $_POST['pid'];

	$valores = [
		"fecha_creacion" => date('Y-m-d G:i:s'),
		"titulo" => trim($_POST['title']),
		"titulo_enlace" => $titulo_enlace,
		"description" => $_POST['page_desc'],
		"tags" => $_POST['page_tags'],
		"autor_id" => G_USERID,
		"contenido" => $_POST['content'],
		"show_header" => $_POST['sh'],
		"show_footer" => $_POST['sf'],
		"header_custom_id" => $_POST['h_cust_id'],
		"footer_custom_id" => $_POST['f_cust_id'],
		"type" => $_POST['type']
	];

	if($mode=="new"):
		$result = $objDataBase->Insert(G_PREFIX.'pages', $valores);
		if($result['result']):
			$ultimo_id = $result['insert_id'];
			$arr = array('resultado' => 'ok', 'contenido' => 'Pagina guardada.', 'url' => G_SERVER, 'last_id' => $ultimo_id, 'reload' => true );
			die(json_encode($arr));
		else:
			$arr = array('resultado' => 'bad', 'contenido' => $result['error'] );
			die(json_encode($arr));
		endif;
	elseif($mode=="update"):
		$result = $objDataBase->Update(G_PREFIX.'pages', $valores, ["id" => $pagina_id]);
		if($result['result']):
			$arr = array('resultado' => 'ok', 'contenido' => 'Contenido actualizado', 'url' => G_SERVER, 'last_id' => $pagina_id, 'reload' => false );
			die(json_encode($arr));
		else:
			$error = $result->error;
			$arr = array('resultado' => 'bad', 'contenido' => $error );
			die(json_encode($arr));
		endif;
	endif;
}else{
	$arr = ['resultado' => false, 'contenido' => 'No cuenta con los permisos'];
	die(json_encode($arr));
}
?>
