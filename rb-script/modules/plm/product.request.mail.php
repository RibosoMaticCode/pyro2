<?php
header('Content-type: application/json; charset=utf-8');

header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

// Armando mensaje :
$email_content = "Datos del comprado:<br /><br />";
$email_content .= "Nombres :".$_POST['nombres']."<br />";
$email_content .= "DNI :".$_POST['dni']."<br />";
$email_content .= "E-mail :".$_POST['email']."<br />";
$email_content .= "Celular :".$_POST['celular']."<br /><br />";

$email_content .= "Datos de envio:<br /><br />";
$email_content .= "Direccion entrega :".$_POST['direccion']."<br />";
$email_content .= "Ciudad :".$_POST['ciudad']."<br />";
$email_content .= "Referencia :".$_POST['referencia']."<br /><br />";

$email_content .= "Datos del producto:<br /><br />";
$email_content .= "Producto :".$_POST['producto_nombre']."<br />";
$email_content .= "Link : ".G_SERVER."products/".$_POST['url']."/<br />";
$email_content .= "Precio :".$_POST['precio']."<br />";

$email_content .= "--<br />El e-mail fue enviado a través del sistema web.";

// Destinatarios :
$recipient = rb_get_values_options('mail_destination');

// Configuracion del cabecera
$subject = "Pedido de compra";
$from_name = rb_get_values_options('name_sender');
$mail_no_reply = rb_get_values_options('mail_sender');

// Build the email headers :
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";

// Send the email :
if (@mail($recipient, $subject, $email_content, $email_headers)) {
	$rspmail = [
		'result' => true,
		'msg' => 'Envio correcto del correo',
	];
	die(json_encode($rspmail));
} else {
	$rspmail = [
		'result' => false,
		'msg' => 'Oops! Algo salio mal y no pudimos enviar tu mensaje.',
	];
	die(json_encode($rspmail));
}
?>
