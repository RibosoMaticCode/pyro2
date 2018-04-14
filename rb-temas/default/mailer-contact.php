<?php
// Incluir varibales globales
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');

include_once ABSPATH.'global.php';

// Destinatarios :
$recipient = "jesusvld@gmail.com";
$cc = "dweb@emocion.pe";

// Configuracion
$subject = "Formulario de Contacto";
$from_name = G_TITULO;
$mail_no_reply = "no-reply@".G_HOSTNAME;
$mail_reply = "info@".G_HOSTNAME;

// Variables
$nom = $_POST['nom'];
$ape = $_POST['ape'];
$emp = $_POST['emp'];
$tel = $_POST['tel'];
$email = $_POST['mail'];
$dir = $_POST['dir'];
$inter = $_POST['opc'];
$mes = $_POST['message'];

// Set the email subject.


// Build the email content.
$email_content = "Informacion del mensaje:<br />";
$email_content .= "Nombres: <strong>$nom $ape</strong><br />";
$email_content .= "Empresa: <strong>$emp</strong><br />";
$email_content .= "Telefono: <strong>$tel</strong><br />";
$email_content .= "E-mail: <strong>$email</strong><br />";
$email_content .= "Direccion: <strong>$dir</strong><br />";
$email_content .= "Interesado en: <strong>$inter</strong><br />";
$email_content .= "Mensaje: <br /><strong>$mes</strong><br />";
$email_content .= "<br /><br />--<br />El e-mail fue enviado a través del formulario de contacto en la web.";

// Build the email headers. // El que envia es el sender no el usuario
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
$email_headers .= "Cc: $cc \r\n";
$email_headers .= "Reply-To: <$mail_reply>\r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
	echo "1";
} else {
	http_response_code(500);
	echo "Oops! Algo salio mal y no pudimos enviar tu mensaje.";
}
?>
