<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$mode = $_POST['mode'];
$cod = $_POST['codigo'];
$emp = $_POST['empresa'];
$empruc = $_POST['empresa_ruc'];
$empdir = $_POST['empresa_direccion'];
$emp_webs = json_encode($_REQUEST['empresa_webs']);
$connom = $_POST['contacto_nombres'];
$concor = $_POST['contacto_correo'];
$contel = $_POST['contacto_telefono'];
$concel = $_POST['contacto_celular'];
$uid = uniqid();

if($mode=="new"):
	$q = "INSERT INTO emo_customers (codigo, empresa, empresa_ruc, empresa_direccion, empresa_webs, contacto_nombres, contacto_correo, contacto_telefono, contacto_celular, fecha_registro, uid)
	VALUES ('$cod', '$emp', '$empruc', '$empdir', '$emp_webs', '$connom', '$concor', '$contel', '$concel', NOW(), '$uid')";
elseif($mode=="upd"):
	$id = $_POST['id'];
	$q = "UPDATE emo_customers SET codigo='$cod', empresa='$emp', empresa_ruc ='$empruc', empresa_direccion='$empdir', empresa_webs = '$emp_webs', contacto_nombres = '$connom', contacto_correo = '$concor', contacto_telefono = '$contel', contacto_celular = '$concel' WHERE id = $id";
endif;

if($objDataBase->Ejecutar($q)){
		die("1");
}else{
  die(mysql_error());
}
?>
