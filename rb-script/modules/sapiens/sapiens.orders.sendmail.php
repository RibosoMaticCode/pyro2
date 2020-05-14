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
$email_content .= "Libro titulo: ".$valores['book_title']."<br />";
$email_content .= "Libro url: ".$valores['book_url']."<br />";
$email_content .= "Carrera: ".$valores['career']."<br />";
$email_content .= "Colegio: ".$valores['school']."<br />";
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
	$email_content .= '<h2>Gracias por registrarte</h2>
    <p>Para finalizar el proceso, realizar tu pago de esta forma:</p>
    <p><strong>Deposito a cuenta corriente</strong></p>
    <p>BCP 850 91828102 020</p>
    <p>BBVA 127 12121 10910 00</p>
    <p><strong>Coordinar pago por Whatsapp</strong></p>
    <p><a href="https://api.whatsapp.com/send?phone=51920810299">+51 920 810 299</a></p>';

	mail($recipient, $subject, $email_content, $email_headers);

	$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'details' => 'Correo enviado'];
	die(json_encode($arr));
} else {
	$arr = ['resultado' => true, 'contenido' => 'Pedido registrado', 'details' => 'Correo NO enviado' ];
	die(json_encode($arr));
}
