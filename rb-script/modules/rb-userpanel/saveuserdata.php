<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
require_once(ABSPATH.'rb-script/class/rb-usuarios.class.php');
require_once(ABSPATH.'rb-script/class/rb-opciones.class.php');

if(isset($_POST)){
    $user_id = $_POST['userid'];

    // VALIDAR datos
	$nm = (empty($_POST['nom']) ? die('[!] Falta Nombres') : $_POST['nom']);
	$ap = (empty($_POST['ape']) ? die('[!] Falta Apellidos') : $_POST['ape']);
	$cr = $_POST['cir'];
	$tf = $_POST['tef'];
	$tm = $_POST['tem'];
	$mail=(empty($_POST['cor']) ? die('[!] Falta E-mail') : $_POST['cor']);
	$di = $_POST['dir'];

    // buscando usuario ID por su mail
    if(!$objUsuario->EditarPorCampo("nombres", $nm, $user_id)) die("Error1");
	if(!$objUsuario->EditarPorCampo("apellidos", $ap, $user_id)) die("Error2");
	if(!$objUsuario->EditarPorCampo("telefono-movil", $tm, $user_id)) die("Error3");
	if(!$objUsuario->EditarPorCampo("telefono-fijo", $tf, $user_id)) die("Error4");
	if(!$objUsuario->EditarPorCampo("direccion", $di, $user_id)) die("Error5");
	if(!$objUsuario->EditarPorCampo("ciudad", $cr, $user_id)) die("Error6");
	if(!$objUsuario->EditarPorCampo("correo", $mail, $user_id)) die("Error7");


	die("Exito");
    /*if($objUsuario->Editar(array($nm, $ap, $cn, $cr, $tm, $tf, $mail, $di, $tipo, $sex),$id)){
    	die("Exito");
	}else{
		die("Ocurrio un error al grabar los datos");
	}*/
}
?>
