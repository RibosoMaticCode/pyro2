<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
require_once(ABSPATH.'global.php');

$recipient = G_MAILS;
	
// Variables
$nom = $_POST['names'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$mess = $_POST['message'];

// Set the email subject. 
$subject = G_TITULO ." | Formulario de Contacto";
      
// Build the email content.
$email_content = "El usuario:<br />";
$email_content .= "Nombres: <strong>$nom</strong><br />";
$email_content .= "E-mail: <strong>$email</strong><br />";
$email_content .= "Telefono: <strong>$tel</strong><br />";

$email_content .= "Ha enviado el siguiente mensaje:<br />";
$email_content .= $mess."<br /><br />--<br />";
$email_content .= "Correo enviado desde la web de ".G_TITULO;

// If you are not using Composer (recommended)
require("sendgrid-php.php");

$from = new SendGrid\Email($nom, $email);
$to = new SendGrid\Email(null, $recipient);
$content = new SendGrid\Content("text/html", $email_content);
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = 'SG.qRNT0E_0SRu4y2S_6SyGcA.mSYSZ4oepiy15THWUKE-nhMjnchn7m_e-UL7EncLS0A';
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
$rspta_code = $response->statusCode();

// Send the email.
if ($rspta_code=="202") {
	echo "<h2 style='color:green'>Gracias! Tu mensaje ha sido enviado.</h2>";
} else {
	echo "Oops! Algo salio mal y no pudimos enviar tu mensaje.";
}
?>