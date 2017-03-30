<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH.'rb-script/class/rb-comentarios.class.php');

$mails_destination = trim(G_MAILS);
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nom = $_POST['nombres'];
	$mail = $_POST['email'];
	$det = stripslashes(htmlspecialchars($_POST['detalles']));
	$usuario_id = $_POST['usuario_id'];
	$articulo_id = $_POST['articulo_id']; 
	
	// grabar pedido en tabla pedido si usuario logueado
	if($objComentario->Insertar(array($articulo_id, $nom, $det, $mail, "", 0, "", "", ""))){
		$content = '<li>
			<img class="avatar" src="'.G_URLTHEME.'/images/user.jpg" alt="user" />
			<div>
			<h4>'.$nom.'</h4>
			
			<!--<span class="fecha">Hace instantes</span>-->
			<p>'.$det.'</p>
			</div>
		</li>'; 
		$arr = array('resultado' => 'ok', 'contenido' => $content );
	}else{
		$arr = array('resultado' => 'mal', 'contenido' => '' );
	}
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($arr);
}
?>