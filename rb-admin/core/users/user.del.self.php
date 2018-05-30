<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$key_web = rb_get_values_options('key_web'); // podria ser key de la sesion de usuario

$user_id_enc = $_POST['user_id'];
$user_key = $_POST['user_key'];
$pass_user = md5($_POST['pwd_user']);

header('Content-type: application/json; charset=utf-8');

// Desencriptamos el id del usuario
$user_id = rb_encrypt_decrypt("decrypt", $user_id_enc, $user_key, $key_web);

// Verificar password de este usuario
$result_user = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE id = ".$user_id);
$User = $result_user->fetch_assoc();

if($User['nickname']=="admin"){
	$arr = array('result' => 0, 'message' => 'El usuario "admin" no puede eliminarse del sistema' );
	die(json_encode($arr));
}

// Si password admins es valido
if($pass_user==$User['password']){

	// Procedemos a borrar
	$r = $objDataBase->Ejecutar("DELETE FROM usuarios WHERE id = $user_id");
	if($r){
		// Cerrar session y todo lo demas
	  $arr = array('result' => 1, 'message' => "Su cuenta fue eliminada. Cerraremos la sesión." );
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
