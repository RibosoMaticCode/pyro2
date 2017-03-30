<?php
function mailer_recovery($name_site, $email, $server, $host){
	// Set the recipient email address.
	// FIXME: Update this to your desired email address.
	$recipient = $email;
	$message = "Haga clic en el siguiente enlace para ingresar una nueva<br /><br />$server/login.php?mail=$email&recovery=reset";

	// Set the email subject. 
	$subject = $name_site." - Recuperar Contrasena";

	// Build the email content.
	$email_content = "Usted solicito un restablecer su contrasena<br />";
	$email_content .= "Correo electronico: $email<br /><br />";
	$email_content .= "Mensaje:\n$message<br /><br />";
	$email_content .= "--<br />";
	$email_content .= "Este e-mail se ha enviado desde ".$name_site." - No reenvie este mensaje";

	if (rb_mailer($recipient, $subject, $email_content, G_LIBMAILNATIVE)){
		return 1;
	}else{
		return 0;
	}	
}
?>