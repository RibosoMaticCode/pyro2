<?php
include("../rb-script/funciones.php");
define('G_SERVER', $objOpcion->obtener_valor(1,'direccion_url'));

include 'islogged.php';

/*------------------ SCRIPT PHP PARA GUARDAR -----------------*/
$operacion=$_POST['section'];

switch($operacion){
	/*---------------------------------------------*/
	/*-------------- COMENTARIO -------------------*/
	/*---------------------------------------------*/
	case "com":
		require_once("../rb-script/class/rb-database.class.php");

		$id=$_POST['id'];
		$com=$_POST['comentario'];
		$web=$_POST['web'];
		$autor=$_POST['autor'];
		$mail=$_POST['mail'];

		if( $objDataBase->Editar( array( $autor, $com, $mail, $web ),$id ) ){
			$enlace=G_SERVER."/rb-admin/index.php?pag=com&opc=edt&id=".$id;
			header('Location: '.$enlace);
		}else{
			echo "Hubo unos incovenientes";
		}
	break;
	/*---------------------------------------------*/
	/*--------------  MENSAJES --------------------*/
	/*---------------------------------------------*/
	case "men":
		require_once("../rb-script/class/rb-database.class.php");
		// Modo
		$mode=$_POST['mode'];

		// DEFINICION DE VARIABLES
		$remitente_id =$_POST['remitente_id'];
		$asunto =$_POST['asunto'];
		$contenido = addslashes($_POST['contenido']);

		// USUARIOS
		if(!isset($_REQUEST['users'])) {
			print "[!] Debe seleccionar el o los destinatarios";
			die();
		}
		$array_users_id = $_REQUEST['users'];

		// tipo de accion
		if($mode=="new"){
			if($objDataBase->Insertar(array($remitente_id, $asunto, $contenido))){
				$ultimo_id=mysql_insert_id();

				// GRABA DATOS EN LA TABLA DETALLES
				foreach($array_users_id as $user_id){
					$objDataBase->Consultar("INSERT INTO mensajes_usuarios (mensaje_id, usuario_id) VALUES ($ultimo_id,$user_id)");
				}

				// REDIRECCIONAR
				$enlace=G_SERVER.'/rb-admin/index.php?pag=men&opc=send';
				header('Location: '.$enlace);
			}else{
				echo "Problemas";
			}
		}
	break;
}
?>
