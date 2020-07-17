<?php
$test_local = false; // default false
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
require_once(ABSPATH."rb-script/funcs.php");
require_once(ABSPATH."rb-script/class/rb-users.class.php");

// Array de respuesta
$rspta = array();

if(isset($_POST)){
	$response = "noajax";
	if(isset($_POST['response'])):
		if($_POST['response']=="ajax") $response = "ajax";
	endif;

  // VALIDAR DATOS DE CAMPOS OBLIGATORIOS
	$mail = (empty($_POST['usuario']) ? die('[!] Falta Correo electronico') : $_POST['usuario']);
	$cn1=(empty($_POST['contrasena1']) ? die('[!] Falta Contraseña') : $_POST['contrasena1']);

	// Habilitado repetir contraseña?
	$repit_pass_register = rb_get_values_options('repit_pass_register');
	if($repit_pass_register==1) $cn2=(empty($_POST['contrasena2']) ? die('[!] Falta Repetir la contraseña') : $_POST['contrasena2']);
	else $cn2 = $cn1;

	// Ver si hay campos adicionales a registrar
	$fields = rb_get_values_options('more_fields_register');
	$array_fields = json_decode($fields, true);
	$array_fields_value = [];
	foreach ($array_fields as $key => $value) {
		/*?>
		<input type="text" name="<?= $key ?>" required placeholder="<?= $value ?>" autocomplete="off" />
		<?php*/
		$array_fields_value[$key] = (empty($_POST[ $key ]) ? die('[!] Falta '.$value) : $_POST[ $key ]);
	}
	//$nm = (empty($_POST['nombres']) ? die('[!] Falta Nombres') : $_POST['nombres']);

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
		$qq = $objDataBase->Ejecutar("select access from ".G_PREFIX."users where correo='".$mail."'");
		$rr = $qq->fetch_assoc();
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

	// VALIDANDO CONTRASEÑA

	// Contraseña segura //http://w3.unpocodetodo.info/utiles/regex-ejemplos.php?type=psw
	$pass_security = rb_get_values_options('pass_security');
	if($pass_security == 1):
		if ( !rb_valid_pass($cn1) ){
			$msg_error = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "1",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		}

		if ( !rb_valid_pass($cn2) ){
			$msg_error = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "1",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		}
	endif;

	// Contraseña No segura
	if($pass_security == 0):
		if ( strlen($cn1) < 3 ){
			$msg_error = "La contraseña debe tener al menos 3 caracteres";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "1",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		}

		if ( strlen($cn2) < 3  ){
			$msg_error = "La contraseña debe tener al menos 3 caracteres";
			if($response=="ajax"):
				$rspta = Array(
					"codigo" => "1",
					"mensaje" => $msg_error
				);
				die( json_encode ($rspta) );
			else:
				die($msg_error);
			endif;
		}
	endif;

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
	$show_terms_register = rb_get_values_options('show_terms_register');
	if($show_terms_register == 1):
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
	endif;

	// SI TODAS LAS VALIDACIONES PASA CON EXITO, GENERAR NICKNAME EN BASE A SU CORREO.
	$array_mail = explode("@", $mail);
	$user = $array_mail[0];
	$q = $objDataBase->Ejecutar("SELECT nickname FROM ".G_PREFIX."users WHERE nickname LIKE '%$user%'");
	$nums = $q->num_rows;
	if($nums>0):
		$user = $user."_".$nums;
	endif;

	// OTROS VALORES POR DEFECTO
	$nivel_id_new_user = rb_get_values_options('nivel_user_register');
	$now = date('Y-m-d G:i:s');
	$date_2d_s =  strtotime($now."+ 2 days");
	$date_2d = date('Y-m-d G:i:s', $date_2d_s);

	$active = 0;
	if(G_USERACTIVE==0) $active = 1;

	$valores = [
		'nickname' => $user,
		'password' => md5($cn1),
		'correo' => $mail,
		'tipo' => $nivel_id_new_user,
		'fecharegistro' => date('Y-m-d G:i:s'),
		'fecha_activar' => $date_2d,
		'ultimoacceso' => date('Y-m-d G:i:s'),
		'photo_id' => 0,
		'activo' => $active,
		'user_key' => md5(microtime().rand())
	];

	// Users admins que seran notificados
	$msg_response_admin = "";
	$superadmins = json_decode(rb_get_values_options('user_superadmin'), true);
	$array_admins = explode(",", $superadmins['admin']);

	$r = $objDataBase->Insert(G_PREFIX.'users', $valores);
	if($r['result']){
		// crear coockie para bloquear registro seguido
		setcookie("_register", "no-register", time()+ 120, "/"); // despues de 2 mins otro registro
		$last_id = $r['insert_id'];

		// Añadir resto de campos
		foreach ($array_fields_value as $key => $value) {
			$objDataBase->EditarPorCampo(G_PREFIX.'users', $key, $value, $last_id);
		}

		// ENVIANDO EMAIL A ADMINISTRADORES - AVISO DE NUEVO USUARIO
		foreach ($array_admins as $user_admin_id) {
			$admin = rb_get_user_info( $user_admin_id );
			$recipient = $admin['correo'];
	    	// Set the email subject.
	    	$subject = "Notificación de nuevo usuario";

	    	// Build the email content.
			$email_content = "Datos del nuevo usuario:<br />";
			if(isset($array_fields_value['nombres'])):
				$nm = $array_fields_value['nombres'];
		    $email_content .= "Nombres: <strong>".$nm."</strong><br />";
			endif;
			$email_content .= "E-mail: <strong>".$mail."</strong><br /><br />";
			if(G_USERACTIVE==2):
				$email_content .= "Mensaje: Para activar al usuario tiene que ir al panel de administración <br />";
				$email_content .= "<a href='".G_SERVER."/rb-admin/index.php?pag=usu'>Activar usuario</a><br />";
			elseif(G_USERACTIVE==1):
				$email_content .= "Mensaje: La activación del usuario, esta configurado para que lo haga el mismo usuario. Solo si el usuario tuviera problemas en activar, usted puede activarlo desde el panel administrativo <br />";
			elseif(G_USERACTIVE==0):
				$email_content .= "Mensaje: Usuario nuevo registrado! La activación del usuario esta desactivada. Verifique que no se trate de spam o correo malicioso. <br />";
				$objDataBase->EditarPorCampo_Int(G_PREFIX.'users', 'activo', 1, $last_id);
			endif;
			$email_content .= "<br />Este correo se ha enviado automaticamente por el gestor de contenidos. No responda.";

	    	// Build the email headers.
	    	$email_headers = "MIME-Version: 1.0" . "\r\n";
			$email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	    	$email_headers .= "From: ".trim(G_TITULO)." <no-reply@".G_HOSTNAME.">";

	  		// Send the email.
	  		if($test_local==false){
		    	if (mail($recipient, $subject, $email_content, $email_headers)):
		      		$msg_response_admin .= "|SendMailAdmin:".$recipient;
				else:
					$msg_response_admin .= "|NoSendMailTo:".$recipient;
				endif;
			}
		}

		// ENVIAR MAIL AL USUARIO NUEVO REGISTRADO
		$recipient2 = $mail;

		// Set the email subject.
		$subject2 = "Bienvenido a ".trim(G_TITULO);

		// Build the email content.
		if(G_USERACTIVE==2): // Admin lo activa
			$email_content2 = "<h2>Gracias por registrarte en nuestra web</h2>";
			$email_content2 .= "<p>Pronto nos pondremos en contacto contigo</p>";
			$email_content2 .= "<p>---</p>";
			$email_content2 .= "<p>Este correo se ha enviado automaticamente desde la pagina web</p>";
		elseif(G_USERACTIVE==1): // Usuario se activa
			$email_content2 = "<h2>Gracias por registrarte en nuestra web</h2>";
			$email_content2 .= "<p>Puedes acceder a tu cuenta con tu correo registrado y la contraseña<p>";
			$email_content2 .= "<p>También puede hacerlo con este nombre de usuario (generado automaticamente por el sistema):<p>";
			$email_content2 .= "<p>".$user."<p>";
			$email_content2 .= "<p>Finalmente, <p>";
			$email_content2 .= "<p>para activar tu cuenta, haz clic en siguiente vinculo: <a href='".G_SERVER."/login.php?active=".rb_encrypt_decrypt('encrypt', $recipient2)."'>".G_SERVER."/login.php?active=".rb_encrypt_decrypt('encrypt', $recipient2)."</a></p>";
			$email_content2 .= "<p>---</p>";
			$email_content2 .= "<p>Este correo se ha enviado automaticamente desde la pagina web</p>";
		elseif(G_USERACTIVE==0): // Usuario no necesita activacion
			$email_content2 = "<h2>Gracias por registrarte en nuestra web</h2>";
			$email_content2 .= "<p>Puedes acceder a tu cuenta con tu correo registrado y la contraseña.<p>";
			$email_content2 .= "<p>Haz clic en este <a href='".G_SERVER."/login.php'>link para acceder</a>.<p>";
			$email_content2 .= "<p>---</p>";
			$email_content2 .= "<p>Este correo se ha enviado automaticamente desde la pagina web</p>";
		endif;

		// Build the email headers.
		$email_headers2 = "MIME-Version: 1.0" . "\r\n";
		$email_headers2 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$email_headers2 .= "From: ".trim(G_TITULO)." <no-reply@".G_HOSTNAME.">";

		// Send the email.
		$msg_response_mail_user = "";
		if($test_local==false){
			if (mail($recipient2, $subject2, $email_content2, $email_headers2)):
		   		$msg_response_mail_user = "Correo enviado a usuario";
			else:
				$msg_response_mail_user = "Usuario creado, pero hay un error al enviar mail al usuario.";
			endif;
		}

		// Armando el mensaje luego del registro
		if(G_USERACTIVE==2): // Admin lo activa
			//$codigo = "0";
			$msg_success = "<p>Registro correcto! Se te envio un correo de confirmación. El administrador revisará tu información y te notificaremos para que puedas acceder a nuestro sitio web</p>";
		elseif(G_USERACTIVE==1): // usuario
			//$codigo = "0";
			$msg_success = "<p>Registro correcto! Pronto recibirás un correo para que puedas activar tu cuenta. Recuerda revisar en la carpeta No deseados también :)</p><p style='text-align:center'><a href='".G_SERVER."'>Volver a la web</a></p>";
		elseif(G_USERACTIVE==0): // activado por defecto
			//$codigo = "0";
			$msg_success = "<p>Bienvenido! Puedes iniciar sesión. <a href='".G_SERVER."/login.php'>Loguearse</a></p>";
		endif;

		// Armar respuest aqui:
		if($response=="ajax"):
			$rspta = Array(
				"codigo" => "0",
				"mensaje" => $msg_success,
				"mensaje_envios_admin" => $msg_response_admin,
				"mensaje_envio_usuario" => $msg_response_mail_user
			);
			die( json_encode ($rspta) );
		else:
			die($msg_error);
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
}else{ // ELSE POST
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
