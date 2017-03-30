<?php
//************** con base de datos*****************
if(isset($_GET['message_id']) && !empty($_GET['message_id']) && isset($_GET['user_id']) && !empty($_GET['user_id'])){
	$message_id = $_GET['message_id'];
	$user_id = $_GET['user_id'];
}else{
	die("Algo anda mal :S, recargue la página");
}

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH.'rb-script/class/rb-mensajes.class.php');

$qm = $objMensaje->Consultar("SELECT * FROM mensajes m, mensajes_usuarios mu WHERE m.id=mu.mensaje_id AND mu.usuario_id = $user_id AND m.id = $message_id");
$Mensaje = mysql_fetch_array($qm);
$content = '<h4 style="margin-bottom:20px">Contenido del Mensaje</h4>';
$content .= $Mensaje['contenido'];

if($objMensaje->Consultar("UPDATE mensajes_usuarios SET leido=1 WHERE usuario_id = $user_id AND mensaje_id = $message_id"))
	$upd = "ok";
else
	$upd = "mal";

$arr = array('resultado' => $upd, 'contenido' => $content );
header('Content-type: application/json; charset=utf-8');
echo json_encode($arr);
?>