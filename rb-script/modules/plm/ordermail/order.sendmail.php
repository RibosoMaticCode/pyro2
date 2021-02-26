<?php
// Destinatarios :
$recipient = rb_get_values_options('mail_destination');

// Configuracion del cabecera
$subject = "Notificacion de pedido nuevo";
$from_name = rb_get_values_options('name_sender');
$mail_no_reply = rb_get_values_options('mail_sender');

// Build the email headers. 
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";


// Email content
$email_content = "Detalles del pedido:<br /><br />";
$email_content .= "Nombres: ".$valores['names']." ".$valores['lastnames']."<br />";
$email_content .= "Email: ".$valores['email']."<br />";
$email_content .= "Celular: ".$valores['phone']."<br />";
$email_content .= "Datos del pedido: <br />".$valores['order_details']."<br />";
$email_content .= "--<br />El e-mail fue enviado a través del formulario de la web.";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
	// Envio correo al usuario

	// Destinatarios :
	$recipient = $valores['email'];

	// Configuracion del cabecera
	$subject = "Datos de tu pedido";
	$from_name = rb_get_values_options('name_sender');
	$mail_no_reply = rb_get_values_options('mail_sender');

	// Build the email headers. 
	$email_headers = "From: $from_name <$mail_no_reply> \r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; UTF-8\r\n";


	// Email content
	$email_content = '<h2>Gracias por registrar tu pedido</h2>
	<p>Pronto nos pondremos en contacto contigo</p><br />';
	$email_content .= "Datos del pedido: <br />".$valores['order_details']."<br />";

	mail($recipient, $subject, $email_content, $email_headers);

	$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'details' => 'Correo enviado'];
	die(json_encode($arr));
} else {
	$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'details' => 'Correo NO enviado' ];
	die(json_encode($arr));
}
