<?php
/* BLACKPYRO APP.
 * Version 3.0 - 18/05/2016
 * Permite registrar al usuario sin necesidad de pedir un nombre de usuario (nickname)
 * El Nickname se generara en base a su correo ingresado, si hay repetido se le sumara unidad
 * Version 2.0
 * Las funciones de este archivo permiten registrar e informar al usuario
 * sobre su cuenta y como acceder a ella
 * */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");

// Array de respuesta
$rspta = array();

if(isset($_POST)){
	$response = "noajax";
	if(isset($_POST['response'])):
		if($_POST['response']=="ajax") $response = "ajax";
	endif;

  // VALIDAR DATOS
	//$user=(empty($_POST['usuario']) ? die('[!] Falta Nombre de Usuario') : $_POST['usuario']);
	$mail = (empty($_POST['usuario']) ? die('[!] Falta Correo electronico') : $_POST['usuario']);
	$nm = (empty($_POST['nombres']) ? die('[!] Falta Nombres') : $_POST['nombres']);
	//$nm = $mail;
	$cn1=(empty($_POST['contrasena1']) ? die('[!] Falta Contraseña') : $_POST['contrasena1']);
	$cn2=(empty($_POST['contrasena2']) ? die('[!] Falta Repetir la contraseña') : $_POST['contrasena2']);

	// VALIDANDO CONTRASEÑAS IGUALES
	if($cn1 != $cn2):
		$msg_error = "Las contraseñas no coinciden, verifique";
		if($response=="ajax"):
			$rspta = Array(
				"codigo" => "1",
				"mensaje" => $msg_error
			);
			die( json_encode ($rspta) );
		else:
			die($msg_error);
		endif;
	endif;

	// VALIDANDO TERMINOS Y CONDICIONES
	if(!isset($_POST['terminos'])) :
		$msg_error = "No se acepto terminos y condiciones";
		if($response=="ajax"):
			$rspta = Array(
				"codigo" => "2",
				"mensaje" => $msg_error
			);
			die( json_encode ($rspta) );
		else:
			die($msg_error);
		endif;
	endif;

	// VALIDANDO ESTRUCTURA DEL CORREO ELECTRONICO
	if(!rb_validar_mail($mail)):
		$msg_error = "Ingrese correctamente su correo";
		if($response=="ajax"):
			$rspta = Array(
				"codigo" => "3",
				"mensaje" => $msg_error
			);
			die( json_encode ($rspta) );
		else:
			die($msg_error);
		endif;
	endif;

	// VALIDAR NOMBRE DE USUARIO EXISTENTE
	//if($objUsuario->existe('nickname',$user)>0) die('[X] Nombre de usuario registrado, intente otro');

	// VALIDAR CORREO EXISTENTE DEL USUARIO
	if($objUsuario->existe('correo',$mail)>0):
		$qq = $objDataBase->Ejecutar("select access from usuarios where correo='".$mail."'");
		$rr = mysql_fetch_array($qq);
		if($rr['access']=='fb'):
			$msg_error = "El correo electronico esta registrado con tu cuenta de Facebook, logueate con esa cuenta";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "4",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		else:
			$msg_error = "Correo electronico registrado, intente otro";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "4",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		endif;
	endif;

	// SI TODAS LAS VALIDACIONES PASA CON EXITO, GENERAR NICKNAME EN BASE A SU CORREO.
	$array_mail = explode("@", $mail);
	$user = $array_mail[0];
	$q = $objDataBase->Ejecutar("SELECT nickname FROM usuarios WHERE nickname LIKE '%$user%'");
	$nums = $q->num_rows;
	if($nums>0):
		$user = $user."_".$nums;
	endif;

	// OTROS VALORES POR DEFECTO
	//$campos = array($nickname, $pwd, $nm, $ap, $cn, $cr, $tm, $tf, $mail, $di, $tipo, $sex, $photo);
	$campos = array($user, $cn1, $nm, "", "", "", "", "", $mail, "", "3", "",0);
	$q = "INSERT INTO usuarios (nickname, password, nombres, apellidos, ciudad, pais, `telefono-movil`, `telefono-fijo`, correo, direccion, tipo, fecharegistro, fecha_activar, ultimoacceso, sexo,photo_id)
	VALUES ('".$campos[0]."', '".md5($campos[1])."', '".$campos[2]."', '".$campos[3]."', '".$campos[4]."', '".$campos[5]."', '".$campos[6]."', '".$campos[7]."', '".$campos[8]."', '".$campos[9]."', ".$campos[10].", NOW(), ADDDATE(NOW(), INTERVAL 2 DAY), NOW(), '".$campos[11]."', ".$campos[12].")";
	$result = $objDataBase->Insertar($q);
  if($result){

    $last_id=$result['insert_id'];
	/*if($objUsuario->Insertar(array())){
		$last_id = mysql_insert_id();*/

		// ENVIANDO EMAIL A ADMINISTRADOR - AVISO DE NUEVO USUARIO
		$q = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE nickname='admin'");
		$r = $q->fetch_assoc();
		$mail_admin = $r['correo'];
		//$recipient = $mail_admin;
		$recipient = trim(G_MAILS);
    // Set the email subject.
    $subject = trim(G_TITULO) ." - Usuario Nuevo";

    // Build the email content.
    $email_content = "Nombres: <strong>".$nm."</strong><br />";
		$email_content .= "E-mail: <strong>".$mail."</strong><br /><br />";
		if(G_USERACTIVE==2):
			$email_content .= "Mensaje: Para activar al usuario tiene que ir al panel de administración <br />";
			$email_content .= "<a href='".G_SERVER."/rb-admin/index.php?pag=usu&opc=edt&id=".$last_id."'>Activar usuario</a><br />";
		elseif(G_USERACTIVE==1):
			$email_content .= "Mensaje: La activación del usuario, esta configurado para que lo haga el mismo usuario. Solo si el usuario tuviera problemas en activar, ustede puede activarlo desde el panel administrativo <br />";
		elseif(G_USERACTIVE==0):
			$email_content .= "Mensaje: Usuario nuevo registrado! La activación del usuario esta desactivada. Verifique que no se trate de spam o correo malicioso";
			$objDataBase->EditarPorCampo_Int('activo',1,$last_id);
		endif;
		$email_content .= "Este correo se ha enviado a traves de la pagina web";

    // Build the email headers.
    $email_headers = "MIME-Version: 1.0" . "\r\n";
		$email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $email_headers .= "From: $nm <$mail>";

  	// Send the email.
    if (!mail($recipient, $subject, $email_content, $email_headers)):
      $msg_error = "Usuario creado, pero hay un error al enviar mail al servidor. Inicie sesión de todas formas";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "4",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		endif;

		// ENVIAR MAIL AL USUARIO
		$recipient2 = $mail;

		// Set the email subject.
		$subject2 = trim(G_TITULO) ." - Registro de datos";

		// Build the email content.
		if(G_USERACTIVE==2): // Admin lo activa
			$email_content2 = "Gracias por registrarte en nuestra web, pronto nos pondremos en contacto contigo.\n\n";
			$email_content2 .= "--\nEste correo se ha enviado a traves de la pagina web";
		elseif(G_USERACTIVE==1): // Usuario se activa
			$email_content2 = "<h2>Gracias por registrarte en nuestra web</h2>";
			$email_content2 .= "<p>Para activar tu cuenta, haz clic en siguiente vinculo: <a href='".G_SERVER."/login.php?active=".rb_encrypt_decrypt('encrypt', $recipient2)."'>".G_SERVER."/login.php?active=".rb_encrypt_decrypt('encrypt', $recipient2)."</a></p>";
			$email_content2 .= "<p>---</p>";
			$email_content2 .= "<p>Este correo se ha enviado a traves de la pagina web</p>";
		elseif(G_USERACTIVE==0):
			$email_content2 = "<h2>Gracias por registrarte en nuestra web</h2>";
		endif;


		// Build the email headers.
		$email_headers2 = "MIME-Version: 1.0" . "\r\n";
		$email_headers2 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$email_headers2 .= "From: ".G_TITULO." <".G_MAILSENDER.">";

		// Send the email.
		if (mail($recipient2, $subject2, $email_content2, $email_headers2)):
			// crear coockie para bloquear registro seguido
	    setcookie("_register", "no-register", time()+ 1800, "/"); // despues de 30 mins otro registro

	   	if(G_USERACTIVE==2): // Admin lo activa
				$codigo = "0";
				$msg_error = "Registro correcto, se te envio un correo de confirmación. El administrador revisará tu información y te notificaremos para que puedas acceder a nuestro sitio web";
			elseif(G_USERACTIVE==1): // usuario
				$codigo = "0";
				$msg_error = "Registro correcto. Pronto recibirás un correo para que puedas activar tu cuenta. Puedes iniciar sesión, pero debes activar tu cuenta para usar todas las caracterisitcas del sitio.";
			elseif(G_USERACTIVE==0): // activado por defecto
				$codigo = "0";
				$msg_error = "Bienvenido! Puedes iniciar sesión. <a href='".G_SERVER."/login.php'>Loguearse</a></p>";
			endif;
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => $codigo,
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		else:
			$msg_error = "Usuario creado, pero hay un error al enviar mail al usuario. Inicie sesión de todas formas.";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "4",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		endif;
	}else{
		$msg_error = "Error al registrar en la base de datos. El usuario no se pudo registrar.";
		if($response=="ajax"):
			$rspta = Array(
				"codigo" => "4",
				"mensaje" => $msg_error
			);
			die( json_encode ($rspta) );
		else:
			die($msg_error);
		endif;
	}
}else{
	$msg_error = "No se recibieron los datos desde el formulario";
	if($response=="ajax"):
		$rspta = Array(
			"codigo" => "4",
			"mensaje" => $msg_error
		);
		die( json_encode ($rspta) );
	else:
		die($msg_error);
	endif;
}
?>
