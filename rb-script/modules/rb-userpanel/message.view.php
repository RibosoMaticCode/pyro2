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
require_once(ABSPATH.'rb-script/class/rb-database.class.php');

$qm = $objDataBase->Ejecutar("SELECT * FROM mensajes m, mensajes_usuarios mu WHERE m.id=mu.mensaje_id AND mu.usuario_id = $user_id AND m.id = $message_id");
$Mensaje = $qm->fetch_assoc();
$content = '<h4 style="margin-bottom:20px">'.$Mensaje['asunto'].'</h4>';
$content .= $Mensaje['contenido'];

if($objDataBase->Ejecutar("UPDATE mensajes_usuarios SET leido=1 WHERE usuario_id = $user_id AND mensaje_id = $message_id"))
	$upd = true;
else
	$upd = false;

$arr = array('resultado' => $upd, 'contenido' => $content );
header('Content-type: application/json; charset=utf-8');
echo json_encode($arr);
?>
