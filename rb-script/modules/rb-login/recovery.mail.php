<?php
function mailer_recovery($name_site, $email, $server, $host){
	// Set the recipient email address.
	// FIXME: Update this to your desired email address.
	$recipient = $email;
	$message = "Haga clic en el siguiente enlace para ingresar una nueva<br /><br />$server/login.php?mail=$email&recovery=reset";

	// Set the email subject.
	$subject = "Recuperar Contraseña";

	// Build the email content.
	$email_content = "Usted solicito restablecer su contraseña<br />";
	$email_content .= "Correo electrónico: $email<br /><br />";
	$email_content .= "Mensaje:\n$message<br /><br />";
	$email_content .= "--<br />";
	$email_content .= "Este e-mail se ha enviado automaticamente por el gestor de contenidos. No responda este mensaje";

	// Build the email headers.
	$email_headers = "From: $name_site <no-reply@".$host."> \r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; UTF-8\r\n";

	// Enviando al webmaster
	if(mail($recipient, $subject, $email_content, $email_headers)){
	//if (mail($recipient, $subject, $email_content, G_LIBMAILNATIVE)){
		return 1;
	}else{
		return 0;
	}
}
?>
