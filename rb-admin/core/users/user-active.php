<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";

$id=$_GET["id"];
$objDataBase->EditarPorCampo_Int('usuarios', 'activo', 1, $id);

$q = $objDataBase->Ejecutar("SELECT correo FROM usuarios WHERE id=".$id);
$r = $q->fetch_assoc();

//enviar mail
$recipient = $r['correo'];

// Set the email subject.
$subject = "Activacion de cuenta";

// Build the email content.
$email_content = "Buen día\n\n";
$email_content .= "Queremos notificarte que tu cuenta ya esta activa \n";
$email_content .= "Puedes acceder a ella desde este enlace: ".G_SERVER."/login.php \n\n";
$email_content .= "Saludos \n\n";
$email_content .= "--\nNo es necesario responder este mail.";

// Build the email headers.
$email_headers = "From: ".G_TITULO." <no-reply@".G_HOSTNAME.">";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
	// Good
}else{
	// Set a 500 (internal server error) response code.
  http_response_code(500);
  echo "Oops! Algo salio mal. Activamos al usuario pero no pudimos enviar un correo para avisar. Hacerlo manualmente";
}
$urlreload=G_SERVER.'/rb-admin/index.php?pag=usu';
header('Location: '.$urlreload);
?>
