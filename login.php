<?php
/*
 * Cambios rb-temas/'.G_ESTILO.'/ por rb-script/
 * para que archivos de login y recuperacion este en carpeta rb-script, en vez del tema
 */
require_once 'rb-script/hook.php';
require_once 'global.php';
require_once 'rb-script/funcs.php';
require_once 'rb-script/class/rb-users.class.php';
require_once 'rb-script/class/rb-database.class.php';

// Cargar los modulos externos
$modules_prev = rb_get_values_options('modules_load');
$array_modules = json_decode($modules_prev, true);
require_once 'rb-script/modules.list.php';

$url_panel = rb_get_values_options('direccion_url').'/rb-admin';
if(rb_get_values_options('after_login_url')!=""):
	$url_panel_usuario = rb_BBCodeToGlobalVariable(rb_get_values_options('after_login_url'));
else:
	$url_panel_usuario = rb_get_values_options('direccion_url');
endif;

$rm_title = G_TITULO;
$rm_subtitle = G_SUBTITULO;
$rm_longtitle = G_TITULO . ( G_SUBTITULO=="" ? "" :  " - ".G_SUBTITULO );
$rm_url = G_SERVER;
$rm_urltheme = G_URLTHEME."/";
$response = "noajax";
if(isset($_POST['response'])):
	if($_POST['response']=="ajax") $response = "ajax";
endif;

// Array de respuesta
$rspta = array();

// 1.- SI EL USUARIO SE LOGUEA .. EMPEZAMOS A VALIDAR SUS DATOS
if(isset($_POST['login'])){
	$user = trim($_POST['usuario']); // nombre usuario, correo ó telefono-movil. addslashes en versiones antiguas
	$pwd = trim($_POST['contrasena']);
	$remember = isset($_POST['remember']) ? 1 : 0;
	setcookie("login_remember", $remember, time()+3600);
	// Si activo recordar contraseña: crear cookie

	//primera validacion: campos vacios
	if(empty($user) || empty($pwd)){
		$msg="Llene los campos correctamente";
		$msgok = 1;
		define('G_MESSAGELOGIN', $msg);

		if($response=="ajax"):
			$rspta = Array(
				"codigo" => $msgok,
				"mensaje" => $msg
			);

			die( json_encode ($rspta) );
		endif;

	//verificar existencia del usuario
	}elseif($objUsuario->existe('nickname',$user)==0 && $objUsuario->existe('correo',$user)==0 && $objUsuario->existe('telefono-movil',$user)==0){
		$msg="El usuario no existe";
		$msgok = 2;
		define('G_MESSAGELOGIN', $msg);

		if($response=="ajax"):
			header("Content-Type: application/json", true);
			$rspta = Array(
				"codigo" => $msgok,
				"mensaje" => $msg
			);
			die( json_encode ($rspta) );
		endif;

	//validar acceso
	}elseif($objUsuario->validar_acceso($user,md5($pwd))==0){
		$msg="Usuario y contrasena no concuerda";
		define('G_MESSAGELOGIN', $msg);
		$msgok = 4;

		if($response=="ajax"):
			$rspta = Array(
				"codigo" => $msgok,
				"mensaje" => $msg
			);
			die( json_encode ($rspta) );
		endif;

		// Verificar su cuenta esta activada
		}elseif($objUsuario->verificar_activacion($user)==1){
			$msg="La cuenta aun no esta activada. Revisa tu correo o pide al administrador que la active.";
			define('G_MESSAGELOGIN', $msg);
			$msgok = 3;

			if($response=="ajax"):
				$rspta = Array(
					"codigo" => $msgok,
					"mensaje" => $msg
				);
				die( json_encode ($rspta) );
			endif;

			//verificar activacion de usuario = sino activado antes de fecha activacion mostrar mensaje
			}elseif($objUsuario->verificar_activacion($user)==2){
				$msg="Venció la fecha para activar la cuenta. Tendras que iniciar el proceso de registro nuevamente";
				define('G_MESSAGELOGIN', $msg);
				$msgok = 3;

				// Aprovechamos a eliminar esta cuenta, ya que nunca se activo.
				$usuario = $objUsuario->mostrar($user,md5($pwd));
				$objDataBase->Ejecutar("DELETE FROM ".G_PREFIX."users WHERE id=".$usuario['id']);

				if($response=="ajax"):
					$rspta = Array(
						"codigo" => $msgok,
						"mensaje" => $msg
					);
					die( json_encode ($rspta) );
				endif;
	}else{
		// Si loguea y da exito
		if(!empty($_POST['redirect'])) {
			$url_panel = $_POST['redirect'];
			$url_panel_usuario = $_POST['redirect'];
		}
		if($usuario = $objUsuario->mostrar($user,md5($pwd))){
			$_SESSION['usr'] = $_POST['usuario'];
			$_SESSION['pwd'] = md5($_POST['contrasena']);
			$_SESSION['usr_id'] = $usuario['id'];
			$_SESSION['type'] =  $usuario['tipo'];
			$_SESSION['nivel_id'] =  $usuario['nivel_id'];
			$_SESSION['ultimoacceso'] =  $usuario['ultimoacceso'];

			// actualizar columna ultimoacceso a fecha actual
			$objDataBase->Ejecutar("UPDATE ".G_PREFIX."users SET ultimoacceso=NOW() WHERE id=".$usuario['id']);
			$idu = $usuario['id'];
			//$objLog->Insertar();
			rb_log_register( array($idu,$user,'Ingreso al sistema') );
			$msg="Conectado";
			$msgok = 5;
			define('G_MESSAGELOGIN', $msg);

			//redireccionar dependiendo de tipo de usuario
			switch( $usuario['tipo'] ):
				case "admin": // TIPO USUARIO ADMINISTRADOR
				case "user-panel": // TIPO USUARIO AVANZADO
					if($response == "ajax"):
						$rspta = Array(
							"codigo" => $msgok,
							"mensaje" => $msg,
							"url" => $url_panel
						);
						die( json_encode ($rspta) );
					else:
						header('Location: '.$url_panel);
					endif;
					break;
				default: // TIPO USUARIO FINAL
					if($response == "ajax"):
						$rspta = Array(
							"codigo" => $msgok,
							"mensaje" => $msg,
							"url" => $url_panel_usuario
						);
						die( json_encode ($rspta) );
					else:
						header('Location: '.$url_panel_usuario);
					endif;
			endswitch;
			exit();
		}
	}
}

// 2.- SI EL USUARIO USA EL FORMULARIO PARA RECUPERAR SU CONTRASEÑA
if(isset($_POST['recovery'])){
	$mail = $_POST['mail'];

	// verificar existencia de correo
	$qr = $objDataBase->Ejecutar("SELECT correo FROM ".G_PREFIX."users WHERE correo = '".$mail."'");

	$CountPostReturn = $qr->num_rows;
	if($CountPostReturn==0){
		$msg="usuario no existe";
		define('G_MESSAGELOGIN', $msg);
	}else{
		// verificar si campo recovery esta activado, sino se sale
		$qr = $objDataBase->Ejecutar("SELECT recovery FROM ".G_PREFIX."users WHERE correo = '".$mail."'");
		$UsuarioItem = $qr->fetch_assoc();
		$recover = $UsuarioItem['recovery'];
		if($recover==1){
			$msg="usted ya solicito cambio de contrase&ntilde;a. vea su correo";
			define('G_MESSAGELOGIN', $msg);
		}else{
			// mandar correo con instrucciones
			require ABSPATH.'rb-script/modules/rb-login/recovery.mail.php';
			if(mailer_recovery(G_TITULO, $mail, G_SERVER, G_HOSTNAME)==1){
				// actualizar campo en tabla que active el recovery
				$objDataBase->Ejecutar("UPDATE ".G_PREFIX."users SET recovery=1 WHERE correo = '".$mail."'");

				// msje del proceso efectuado
				$msg="Se enviaron instrucciones a su correo para restablecer su contrase&ntilde;a, revise carpeta SPAM por si las dudas :-)";
				define('G_MESSAGELOGIN', $msg);
			}else{
				// msje del proceso mal
				$msg="Ocurrio un error al intentar enviar el correo. Intente de nuevo";
				define('G_MESSAGELOGIN', $msg);
			}
		}
	}
}

$rm_metakeywords = "";
$rm_metadescription = "";
$rm_metaauthor = "";

// 3.- MUESTRA EL FORMULARIO DE REGISTRO DE USUARIO
if(isset($_GET['reg'])){
	if(G_ACCESOUSUARIO==0){
		//carga formulario de registro
		require ABSPATH.'rb-script/modules/rb-login/login.register.php';
		die();
	}else{
		//redireccionar
		header('Location: '.rb_get_values_options('direccion_url'));
		exit();
	}
}

// 4.- MUESTRA EL FORMULARIO DE RECUPERACION DE DATOS DEL USUARIO
if(isset($_GET['recovery'])){
	if(G_ACCESOUSUARIO==0){
		// nuevo password
		if($_GET['recovery']=='reset'){
			if(isset($_GET['mail'])){
				$mail = $_GET['mail'];
			}else{
				die("Error: Falta especificar correo electronico");
			}

			// verificar si campo recovery esta activado, sino se sale
			$qr = $objDataBase->Ejecutar("SELECT recovery FROM ".G_PREFIX."users WHERE correo = '".$mail."'");
			$UsuarioItem = $qr->fetch_assoc();
			$recover = $UsuarioItem['recovery'];
			if($recover==0){
				die("Usted no solicito un cambio de password");
			}

			$rm_title = "Nuevo password | ".G_TITULO;
			require ABSPATH.'rb-script/modules/rb-login/login.newpass.php';
			die();
		// recuperacion
		}else{
			$rm_title = "Recuperar contrase&ntilde;a | ".G_TITULO;
			require ABSPATH.'rb-script/modules/rb-login/login.recovery.php';
			die();
		}
	}else{
		//redireccionar
		header('Location: '.rb_get_values_options('direccion_url'));
		exit();
	}
}

// 5.- GRABANDO CONTRASEÑAS NUEVAS
if(isset($_POST['newpass'])){
	$mail = $_POST['mail'];

	// VALIDAR PASSWORDS
	$pwd=(empty($_POST['pass1']) ? die('[!] Ingrese una contrasena') : $_POST['pass1']);
	$pwd1=(empty($_POST['pass2']) ? die('[!] Ingrese una contrasena') : $_POST['pass2']);

	// Validar solidez
	$pass_security = rb_get_values_options('pass_security');
	if($pass_security == 0){ // Contraseñas no seguras
		if( strlen($pwd) < 3 ) die("La contraseña debe tener al menos 3 caracteres.");
		if( strlen($pwd1) < 3) die("La contraseña debe tener al menos 3 caracteres.");
	}
	if($pass_security == 1){ // Contraseñas seguras
		if( !rb_valid_pass($pwd) ) die("La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.");
		if( !rb_valid_pass($pwd1) ) die("La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.");
	}

	if($pwd!=$pwd1){
		die('[!] Las contrasenas no coinciden. Intente de nuevo.');
	}

	// buscando usuario ID por su mail
	$qr = $objDataBase->Ejecutar("SELECT id FROM ".G_PREFIX."users WHERE correo = '".$mail."'");
	$UsuarioItem = $qr->fetch_assoc();
	$id = $UsuarioItem['id'];

	// cambiamos el password
	$objDataBase->EditarPorCampo(G_PREFIX."users","password", md5(trim($pwd)),$id);

	// quitamos recovery mode
	$objDataBase->Ejecutar("UPDATE ".G_PREFIX."users SET recovery=0 WHERE correo = '".$mail."'");

	$msg="se cambio la contrase&ntilde;a, no se olvide esta vez :-) ";
	define('G_MESSAGELOGIN', $msg);
	require ABSPATH.'rb-script/modules/rb-login/login.php';
	exit();
}

// 6.- CERRANDO SESION DE USUARIO
if(isset($_GET['out'])){
	session_destroy();
	// session_unregister('_ribapp'); --> session_unregister en desuso en nva version
	//redireccionar
	header('Location: '.rb_get_values_options('direccion_url'));
	exit();
}

// 7. SI USUARIO ACTIVA SU CUENTA
if(isset($_GET['active'])){
	$md5user = rb_encrypt_decrypt('decrypt',trim($_GET['active']));

	if($objUsuario->existe('correo',$md5user)==0):
		//header('Location: '.G_SERVER.'/rb-script/message.php?title=No existe el usuario&desc=Registrese en nuestra web... Sera redireccionado&img=message.error.png');
		echo "<h2 style='text-align:center'>No existe el usuario</h2>";
		echo "<p style='text-align:center'><a href='".G_SERVER."login.php?reg'>Registrese en nuestra web</a></p>";
	else:
		$q = $objDataBase->Ejecutar("SELECT id, activo FROM ".G_PREFIX."users WHERE correo='".$md5user."'");
		$r = $q->fetch_assoc();
		/*print_r($r);

		die();*/
		if($r['activo']==1):
			//header('Location: '.G_SERVER.'/rb-script/message.php?title=Usuario ya está activo&desc=Vaya la web e inicie sesión.&img=message.warning.png');
			echo "<h2 style='text-align:center'>Usuario ya está activo</h2>";
			echo "<p style='text-align:center'><a href='".G_SERVER."login.php'>Inicie sesión</a></p>";
			exit();
		endif;

		if($objDataBase->EditarPorCampo_Int(G_PREFIX."users","activo", 1,$r['id'])):
			//header('Location: '.G_SERVER.'/rb-script/message.php?title=Su cuenta ahora esta activa!&desc=Vaya la web e inicie sesión... Sera redireccionado&img=message.good.png');
			echo "<h2 style='text-align:center'>Su cuenta ahora esta activa</h2>";
			echo "<p style='text-align:center'><a href='".G_SERVER."/login.php'>Inicie sesión</a></p>";
			exit();
		else:
			echo "<h2 style='text-align:center;color:red'>Ocurrió un error :\'(</h2>";
			echo "<p style='text-align:center'>Intentelo más tarde. Si problema persiste registrese nuevamente.</p>";
			//header('Location: '.G_SERVER.'/rb-script/message.php?title=Ocurrió un error :(&desc=Intentelo más tarde... Sera redireccionado&img=message.error.png');
			exit();
		endif;
	endif;
	exit();
}

// 8. SI USUARIO YA LOGUEADO E INTENTA IR A LOGIN.PHP, REDIRECCIONA AL PANEL ADMINISTRATIVO
if(G_ACCESOUSUARIO==1){
	if(G_USERTYPE=="admin" || G_USERTYPE=="user-panel") header('Location: '.$url_panel);
	if(G_USERTYPE=="user-front") header('Location: '.$url_panel_usuario);
}else{
	require ABSPATH.'rb-script/modules/rb-login/login.php';
}
?>
