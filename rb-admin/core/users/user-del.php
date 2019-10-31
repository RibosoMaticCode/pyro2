<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$key_web = rb_get_values_options('key_web'); // podria ser key de la sesion de usuario

$user_id_enc = $_POST['user_id'];
$user_key = $_POST['user_key'];
$pass_admin = md5($_POST['pwd_adm']);

header('Content-type: application/json; charset=utf-8');

// Verificar password de este usuario
$result_admin = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users WHERE id = ".G_USERID);
$Admin = $result_admin->fetch_assoc();

// Si password admins es valido
if($pass_admin==$Admin['password']){

	// Desencriptamos el id del usuario
	$user_id = rb_encrypt_decrypt("decrypt", $user_id_enc, $user_key, $key_web);

	// Verificamos que no sea en admin = 1
	$r = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users WHERE id =". $user_id);
	$row = $r->fetch_assoc();
	if($row['nickname']=="admin"){
	  $arr = array('result' => 0, 'message' => 'El usuario "admin" no puede eliminarse del sistema' );
	  die(json_encode($arr));
	}

	// Procedemos a borrar
	$r = $objDataBase->Ejecutar("DELETE FROM ".G_PREFIX."users WHERE id =". $user_id);
	if($r){
	  $arr = array('result' => 1, 'message' => "El usuario fue eliminado" );
	  die(json_encode($arr));
	}else{
	  $arr = array('result' => 0, 'message' => G_SERVER );
	  die(json_encode($arr));
	}

}else{
	$arr = array('result' => 0, 'message' => 'La contraseña no corresponde' );
  die(json_encode($arr));
}
?>
