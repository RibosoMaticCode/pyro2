<?php
// Habilitar allow_url_fopen=on en PHP.ini
header('Content-type: application/json; charset=utf-8');

// Incluir varibales globales
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

// Captura de datos
$values = $_POST['data'];

// Validando Valores
$array_validations = ['Nombres'=> 'req|min=3|max=50', 'Telefono' => 'req|min=3|max=50'];
$result = rb_validate_fields(json_encode($array_validations), $values);
if(!$result['result']){
	$rspmail = [
		'result' => false,
		'msg' => $result['msg'],
		'msgHtml' => '<strong>'.$result['msg'].'</strong>'
	];
	die(json_encode($rspmail));
}

// Armando mensaje
$email_content = "Informacion del mensaje:<br /><br />";
foreach ($values as $key => $value) {
	$email_content .= $key.": <br />".$value."<br /><br />";
}
$email_content .= "--<br />El e-mail fue enviado a través del formulario de la web.";

// Destinatarios :
$recipient = rb_get_values_options('mail_destination');

// Configuracion del cabecera
$subject = "Quiero calificar para techo propio";//"Formulario de Contacto";
$from_name = rb_get_values_options('name_sender');
$mail_no_reply = rb_get_values_options('mail_sender');

// Build the email headers. // El que envia es el sender no el usuario
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
	$rsptaHtml = "Envio correcto de la informacion del formulario. <br /><a href='".G_SERVER."'>Seguir navegando en nuestra web</a>";
	$rspmail = [
		'result' => true,
		'msg' => 'Envio correcto del correo',
		'msgHtml' => $rsptaHtml
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
