<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'rb-script/class/rb-database.class.php');

if(isset($_POST)){
  $user_id = $_POST['userid'];
	$nm = (empty($_POST['nom']) ? die('[!] Falta Nombres') : $_POST['nom']);
	$ap = (empty($_POST['ape']) ? die('[!] Falta Apellidos') : $_POST['ape']);
	$cr = $_POST['cir'];
	$tf = $_POST['tef'];
	$tm = $_POST['tem'];
	$mail=(empty($_POST['cor']) ? die('[!] Falta E-mail') : $_POST['cor']);
	$di = $_POST['dir'];

	$valores = [
		'nombres' => $nm,
		'apellidos' => $ap,
		'direccion' => $di,
		'ciudad' => $cr,
		'telefono-movil' => $tm,
		'telefono-fijo' => $tf,
		'correo' => $mail
	];

	$r = $objDataBase->Update('usuarios', $valores, ["id" => $user_id]);
	if($r['result']){
		$arr = ['result' => true, 'message' => 'Tus datos fueron actualizados' ];
	}else{
		$arr = ['result' => false, 'message' => $r['error']];
	}

  die(json_encode($arr));
}
?>
