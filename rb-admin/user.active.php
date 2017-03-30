<?php
require_once("../global.php");
include 'islogged.php';
require_once("../rb-script/class/rb-usuarios.class.php");

$id=$_GET["id"];
$objUsuario->EditarPorCampo_Int('activo',1,$id);

$q = $objUsuario->Consultar("select correo from usuarios where id=".$id);
$r = mysql_fetch_array($q);

//enviar mail
$recipient = $r['correo'];

// Set the email subject.
$subject = G_TITULO." - Activacion de cuenta";

// Build the email content.
$email_content = "Buen día\n\n";
$email_content .= "Queremos notificarte que tu cuenta ya esta activa \n";
$email_content .= "Puedes acceder a ella desde este enlace: ".G_SERVER."/login.php \n\n";
$email_content .= "Saludos \n\n";
$email_content .= "--\nNo es necesario responder este mail.";

// Build the email headers.
$email_headers = "From: ".G_TITULO." Administracion <no-reply@".G_HOSTNAME.">";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
	$urlreload='../rb-admin/index.php?pag=usu&m=1';
	header('Location: '.$urlreload);
}else{
	// Set a 500 (internal server error) response code.
    http_response_code(500);
    echo "Oops! Algo salio mal. Activamos al usuario pero no pudimos enviar un correo para avisar. Hacerlo manualmente";
}

?>
