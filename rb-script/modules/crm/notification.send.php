<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

// Consulta mensaje
$id = $_GET['id'];
$q = $objDataBase->Ejecutar("SELECT * FROM crm_notification WHERE id=$id");
$rown = $q->fetch_assoc();

// Armando mensaje
$email_content = $rown['mensaje'];

// Destinatario :
$qc = $objDataBase->Ejecutar("SELECT * FROM crm_customers WHERE id=".$rown['customer_id']);
$rowc = $qc->fetch_assoc();
$recipient = $rowc['correo'];

// Configuracion del cabecera
$subject = "Mensaje importante para ud";
$from_name = rb_get_values_options('name_sender');
$mail_no_reply = rb_get_values_options('mail_sender');

// Build the email headers. // El que envia es el sender no el usuario
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
    // Actualizar estado de la notificacion
    $valores = [
        'enviado' => 1,
        'fecha_envio' => date('Y-m-d G:i:s')
      ];

    $objDataBase->Update('crm_notification', $valores, ["id" => $id]);

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