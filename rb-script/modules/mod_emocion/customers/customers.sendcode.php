<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

if(isset($_GET['uid'])):
  $sender = "dweb@emocion.pe";
  $q = $objDataBase->Ejecutar("SELECT * FROM emo_customers WHERE uid='".trim($_GET['uid']."'"));
  $customer_data = mysql_fetch_array($q);

  $recipient = $customer_data['contacto_correo'];
	// Set the email subject.
	$subject = "Datos de acceso a soporte de Branding Emocion";
	// Build the email content.
	$email_content = '<div style="background-color:#ececec;padding:50px 0">
	  <div style="width:100%; max-width:600px; margin:0 auto;">
	    <div style="text-align:center;background-color:#2196F3">
	      <img src="http://emocion.pe/img/bg-logo.png" style="max-width:200px" alt="logo" />
	    </div>
	  <div style="background-color:#fff;padding:15px 55px 25px">';
	$email_content .= '<p style="text-align:center;font-family:Arial;color:gray">Hola '.$customer_data['contacto_nombres'].', tus datos de acceso para darte soporte y hagas tus requerimientos, son los siguientes:</p>';
  $email_content .= '<p style="font-family:Arial"><strong>Tu codigo de acceso</strong></p>';
  $email_content .='<p style="font-family:Arial;color:gray;padding:2px 0;margin:4px 0">'.$customer_data['uid'].'</p>';
	$email_content .= '<p style="font-family:Arial"><strong>URL acceso directo</strong></p>';
  $email_content .='<p style="font-family:Arial;color:gray;padding:2px 0;margin:4px 0"><a href="'.G_SERVER.'/customers/index.php?uid='.$customer_data['uid'].'">'.G_SERVER.'/customers/index.php?uid='.$customer_data['uid'].'</a></p>';

	$email_content .='</div>
	    <p style="font-family:Verdana;color:gray;margin:20px 0 0;padding:5px 0; text-align:center;font-size:.7em;"><a style="color:gray;" href="http://emocion.pe">Branding Emoci&oacute;n - Queremos fan&aacute;ticos!</a><p>
	  </div>
	</div>';
	// Build the email headers. // El que envia es el sender no el usuario
	$email_headers = "From: Branding Emocion <no-reply@emocion.pe>\r\n";
	$email_headers .= "Reply-To: <". strip_tags($sender) . ">\r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; UTF-8\r\n";

  if (mail($recipient, $subject, $email_content, $email_headers)) {
		die("1");
	} else {
  	die("0");
	}
endif;
?>
