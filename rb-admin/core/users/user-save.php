<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/class/rb-usuarios.class.php';
require_once ABSPATH.'rb-script/funciones.php';

// Modo
$mode=$_POST['mode'];

// DEFINICION DE VARIABLES Y VALIDACIONES
$nm = trim($_POST['nom']);
$ap = trim($_POST['ape']);
$cn = trim($_POST['ciu']);
$cr = trim($_POST['pais']);
$di = trim($_POST['dir']);
$tipo = $_POST['tipo'];
$mail= trim($_POST['mail']);
$nickname = trim($_POST['nickname']);
$tf = trim($_POST['telfij']);
$tm = trim($_POST['telmov']);
$pwd=$_POST['password'];
$pwd1=$_POST['password1'];
$sex = $_POST['sexo'];
$photo = $_POST['photo_id'];
$bio = trim($_POST['bio']);
$tw = trim($_POST['tw']);
$fb = trim($_POST['fb']);
$gplus = trim($_POST['gplus']);
$in = trim($_POST['in']);
$pin = trim($_POST['pin']);
$insta = trim($_POST['insta']);
$youtube = trim($_POST['youtube']);
$grupo_id = $_POST['grupo'];

// tipo de accion
if($mode=="new"){
	// Verificar campos obligatorios
	if( empty($nm) || empty($mail) || empty($nickname) || empty($pwd) || empty($pwd1)):
		$arr = ['resultado' => 1, 'contenido' => 'Campos obligatorios están vacios. Verifique.'];
		die(json_encode($arr));
	endif;

	// VERIFICANDO PASS IGUALES
  if($pwd!=$pwd1):
		$arr = ['resultado' => 4, 'contenido' => 'Contraseñas no coinciden' ];
		die(json_encode($arr));
  endif;

  // VALIDAR NOMBRE DE USUARIO
  if($objUsuario->existe('nickname',$nickname)!=0):
		$arr = ['resultado' => 2, 'contenido' => 'Nombre de usuario ya tomado. Pruebe con otro.' ];
		die(json_encode($arr));
	endif;

	// NOMBRE DE USUARIO, minimo a 6 caracteres
  if( strlen($nickname)<6):
		$arr = ['resultado' => 2, 'contenido' => 'Nombre de usuario debe tener al menos 6 caracteres' ];
		die(json_encode($arr));
	endif;

  // VALIDAR CORREO
  if($objUsuario->existe('correo',$mail)!=0):
		$arr = ['resultado' => 3, 'contenido' => 'Correo electronico ya tomado. Pruebe con otro.' ];
		die(json_encode($arr));
	endif;

	// Validar seguridad de las contraseñas
	if ( !rb_valid_pass($pwd) ):
		$msg_error = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
		$arr = ['resultado' => 5, 'contenido' => $msg_error ];
		die(json_encode($arr));
	endif;

	if ( !rb_valid_pass($pwd1) ):
		$msg_error = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
		$arr = ['resultado' => 5, 'contenido' => $msg_error ];
		die(json_encode($arr));
	endif;

  // INSERTAR USUARIO NUEVO
	$now = date('Y-m-d G:i:s');
	$date_2d_s =  strtotime($now."+ 2 days");
	$date_2d = date('Y-m-d G:i:s', $date_2d_s);

	$valores = [
		'nickname' => $nickname,
		'password' => md5($pwd),
		'nombres' => $nm,
		'apellidos' => $ap,
		'ciudad' => $cn,
		'pais' => $cr,
		'telefono-movil' => $tm,
		'telefono-fijo' => $tf,
		'correo' => $mail,
		'direccion' => $di,
		'tipo' => $tipo,
		'fecharegistro' => date('Y-m-d G:i:s'),
		'fecha_activar' => $date_2d,
		'ultimoacceso' => date('Y-m-d G:i:s'),
		'sexo' => $sex,
		'photo_id' => 0,
		'activo' => 0,
		'user_key' => md5(microtime().rand())
	];

	$r = $objDataBase->Insert('usuarios', $valores);
	if($r['result']){
    $ultimo_id= $r['insert_id'];

    $objDataBase->EditarPorCampo("usuarios", "bio", $bio, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "tw", $tw, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "fb", $fb, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "gplus", $gplus, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "in", $in, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "pin", $pin, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "insta", $insta, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "youtube", $youtube, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "grupo_id", $grupo_id, $ultimo_id);

		$arr = ['resultado' => 0, 'contenido' => "Datos del usuario registrados correctamente", 'insert_id' => $ultimo_id ];
		die(json_encode($arr));
  }else{
		$arr = ['resultado' => -1, 'contenido' => "Ocurrio un error al registrar al usuario. Intente nuevamente.", 'error' => $r['error'] ];
		die(json_encode($arr));
  }
}elseif($mode=="update"){
  $id=$_POST['id'];
  $change_pwd = 0;

	// Verificar campos obligatorios
	if( empty($nm) || empty($mail) || empty($nickname) ):
		$arr = ['resultado' => 1, 'contenido' => 'Campos obligatorios están vacios. Verifique.'];
		die(json_encode($arr));
	endif;

  // SI NO ESTAN VACIOS LOS CAMPOS DE CONTRASENA, ESTAS DEBEN SER IGUALES
  if( strlen(trim($pwd))>0 || strlen(trim($pwd1))>0 ){
    if($pwd!=$pwd1){
			$arr = ['resultado' => 4, 'contenido' => 'Contraseñas no coinciden'];
			die(json_encode($arr));
    }else{
			// Verificamos seguridad de contraseñas:
			// Validar seguridad de las contraseñas
			if ( !rb_valid_pass($pwd) ):
				$msg_error = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
				$arr = ['resultado' => 5, 'contenido' => $msg_error ];
				die(json_encode($arr));
			endif;

			if ( !rb_valid_pass($pwd1) ):
				$msg_error = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
				$arr = ['resultado' => 5, 'contenido' => $msg_error ];
				die(json_encode($arr));
			endif;
      // SE APRUEBA EL CAMBIO DE PASSWORD
      $change_pwd = 1;
    }
  }

	$valores = [
		'nickname' => $nickname,
		'nombres' => $nm,
		'apellidos' => $ap,
		'ciudad' => $cn,
		'pais' => $cr,
		'telefono-movil' => $tm,
		'telefono-fijo' => $tf,
		'correo' => $mail,
		'direccion' => $di,
		'tipo' => $tipo,
		'sexo' => $sex,
		'photo_id' => 0
	];

	$r = $objDataBase->Update('usuarios', $valores, ["id" => $id]);
	if($r['result']){
    if($change_pwd==1) $objDataBase->EditarPorCampo("usuarios", "password", md5(trim($pwd)),$id);

    $objDataBase->EditarPorCampo("usuarios", "bio", $bio, $id);
    $objDataBase->EditarPorCampo("usuarios", "tw", $tw, $id);
    $objDataBase->EditarPorCampo("usuarios", "fb", $fb, $id);
    $objDataBase->EditarPorCampo("usuarios", "gplus", $gplus, $id);
    $objDataBase->EditarPorCampo("usuarios", "in", $in, $id);
    $objDataBase->EditarPorCampo("usuarios", "pin", $pin, $id);
    $objDataBase->EditarPorCampo("usuarios", "insta", $insta, $id);
    $objDataBase->EditarPorCampo("usuarios", "youtube", $youtube, $id);
    $objDataBase->EditarPorCampo("usuarios", "grupo_id", $grupo_id, $id);

		if(isset($_POST['profile'])):
			$arr = ['resultado' => 0, 'contenido' => "Datos del usuario registrados correctamente", 'insert_id' => $id, 'profile' => true ];
			die(json_encode($arr));
		else:
			$arr = ['resultado' => 0, 'contenido' => "Datos del usuario registrados correctamente", 'insert_id' => $id, 'profile' => false ];
			die(json_encode($arr));
		endif;
  }else{
		$arr = ['resultado' => -1, 'contenido' => "Ocurrio un error al actualizar al usuario. Intente nuevamente.", 'error' => $r['error'] ];
		die(json_encode($arr));
  }
}
?>
