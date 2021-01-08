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

$email_content .= "<br />Para ver este y otros pedidos a detalle, ingrese a la web. 
	Aqui: <a href='".G_SERVER."login.php'>".G_SERVER."login.php</a><br />";
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
	$email_content = "";
	$email_content .= '<h2>Gracias por registrar tu pedido</h2>
	<p>Pronto nos pondremos en contacto contigo</p>
    <p>Para finalizar el proceso, realizar tu pago de:</p> 
    <p><strong>S/. '.$valores['total'].'</strong></p>
    <p>Más el costo de envio:</p>
    <p><strong>S/. '.$valores['delivery_cost'].'</strong></p>
    <br />
    <p>Deposito a cuenta corriente</p>
    <p><strong>BCP 570-7150004-0-36</strong></p>
    <br />
    <p>Coordinar pago por Whatsapp</strong></p>
    <p><a href="https://api.whatsapp.com/send?phone=51924986883">+51 924 986 883</a></p>
    <br />';

	mail($recipient, $subject, $email_content, $email_headers);

	$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'details' => 'Correo enviado'];
	die(json_encode($arr));
} else {
	$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'details' => 'Correo NO enviado' ];
	die(json_encode($arr));
}
