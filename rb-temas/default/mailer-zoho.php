<?php
// Zoho script mailer functional
$recipient = "informes@cunajardincalifornia.edu.pe";
$website = "Cuna Jardin California";
$website_url = "cunajardincalifornia.edu.pe";

// Variables
$paq = $_POST['paquete'];
$nom = $_POST['nombres'];
$apepat = $_POST['apepat'];
$apemat = $_POST['apemat'];
$fecnac = $_POST['fecnac'];
$nompat = $_POST['nompat'];
$apespat = $_POST['apespat'];
$telpat = $_POST['telpat'];
$mailpat = $_POST['mailpat'];

// Build the email content.
$email_content = "Datos del niño:\n";
$email_content .= "Nombres y Apellidos: $nom $apepat $apemat\n";
$email_content .= "Fecha Nacimiento: $fecnac\n\n";
$email_content .= "Datos del apoderado\n";
$email_content .= "Nombres y apellidos: $nompat $apespat\n";
$email_content .= "Telefono: $telpat\n";
$email_content .= "E-mail: $mailpat\n";
$email_content .= "\n\nEl e-mail fue enviado a través del formulario en la web.";

// Set the email subject.
$subject = $website." - Reservacion";

//Set the form flag to no display (cheap way!)
$flags = 'style="display:none;"';

//$msg = strip_tags($_POST['message']);

$filename = $_FILES['file']['name'];

$boundary =md5(date('r', time()));

$headers = "From: no-reply@cunajardincalifornia.edu.pe\r\nReply-To: no-reply@cunajardincalifornia.edu.pe";
$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";

$msg="This is a multi-part message in MIME format.

--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

$email_content

--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment

$attachment
--_1_$boundary--";

$ok = mail($recipient, $subject, $msg, $headers);

if($ok) {
	echo "1";
	// Enviar respuesta al cliente
	// Set the email subject.
  $subject = $website." - Mensaje recibido";

  // Build the email content
  $email_content = "Estimado/a: <strong>$nompat $apespat</strong><br />";
  $email_content .= "Aprovechamos el presente para saludarlo(a); y a la vez nos es muy grato informarle que pronto contactaremos con usted para confirmar su reserva.";
  $email_content .= "<br /><br />--<br />";

  // Build the email headers. // El que envia es el sender no el usuario
  $email_headers = "From: $website <no-reply@$website_url> \r\n";
  $email_headers .= "Reply-To: <no-reply@$website_url>\r\n";
  $email_headers .= "MIME-Version: 1.0\r\n";
  $email_headers .= "Content-Type: text/html; UTF-8\r\n";

  // Receptor
  $recipient = $cor;

  mail($mailpat, $subject, $email_content, $email_headers);
} else {
	http_response_code(500);
	echo "Oops! Algo salio mal y no pudimos enviar tu mensaje.";
}
?>
