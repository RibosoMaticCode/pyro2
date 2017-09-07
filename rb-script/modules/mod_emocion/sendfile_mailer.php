<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$sender = $_POST['correo'];
$desti = $_POST['destinatarios'];
$files_id = $_POST['files_id'];
$mess = $_POST['mensaje'];
$vinculo = uniqid();

$q = "INSERT INTO emo_sendfile (emisor, destinatarios, archivos, fecha_envio, mensaje, vinculo_usuario) VALUES ('$sender', '$desti', '$files_id', NOW(), '$mess', '$vinculo')";
if($objDataBase->Ejecutar($q)){
	$recipient = $desti.",".$sender;
	// Set the email subject.
	$subject = "Ver archivos adjuntos";

	// Build the email content.
	$email_content = '<div style="background-color:#ececec;padding:50px 0">
	  <div style="width:100%; max-width:600px; margin:0 auto;">
	    <div style="text-align:center;background-color:#2196F3">
	      <img src="http://emocion.pe/img/bg-logo.png" style="max-width:200px" alt="logo" />
	    </div>
	  <div style="background-color:#fff;padding:15px 55px 25px">';

	if(strlen($mess)>0){
		//$email_content .= '<p style="font-family:Arial"><strong>Mensaje adicional</strong></p>';
		$email_content .= '<p style="text-align:center;font-family:Arial;color:gray">'.$mess.'</p>';
	}else{
		$email_content .= '<p style="text-align:center;font-family:Arial;color:gray">Te ha enviado algunos archivos</p>';
	}
	      //<p style="font-family:Arial"><strong>Link de descargar</strong></p>
	      //<p style="font-family:Arial"><a href="http://emocion.pe/customers/files.php?uid='.$vinculo.'">http://emocion.pe/customers/files.php?uid='.$vinculo.'</a></p>
	$email_content .= '<p style="font-family:Arial"><strong>Archivos</strong></p>';
	$files_list = "";
	$arr = json_decode($files_id);
	foreach ($arr as $key => $value) {
		$q_file = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id =".$value);
		$file = mysql_fetch_array($q_file);
		$files_list .='<p style="font-family:Arial;color:gray;padding:2px 0;margin:4px 0"><a href="'.G_SERVER.'/rb-media/gallery/'.utf8_encode($file['src']).'" download>'.utf8_encode($file['src']).'</a></p>';
	}
	$email_content .= $files_list;

	/*$email_content .= '<p style="text-align:center;font-family:Arial">
		<a href="http://emocion.pe/customers/files.php?uid='.$vinculo.'" style="background-color:#3F51B5; border-radius:25px; padding: 10px 25px;text-decoration: none; margin: 10px 0; display:inline-block;color:#fff">Descargarlos</a>
	</p>';*/

	$email_content .='</div>
	    <p style="font-family:Verdana;color:gray;margin:20px 0 0;padding:5px 0; text-align:center;font-size:.7em;">Los archivos estarán disponibles durante 7 días. Este mensaje ha sido enviado a través del sistema de transferencia de archivos de Branding Emoción EIRL.
Toda la información del negocio contenida en este mensaje es confidencial y de uso exclusivo de Branding Emoción. su divulgación, copia y/o adulteración están prohibidas y sólo de ser conocida por la persona quien se dirige este mensaje.
Si Ud. ha recibido este mensaje por error por favor proceda a eliminarlo y notificar al remitente. <a style="color:gray;" href="http://emocion.pe">Branding Emoci&oacute;n - Queremos fan&aacute;ticos!</a><p>
	  </div>
	</div>';

	// Build the email headers. // El que envia es el sender no el usuario
	$email_headers = "From: Branding Emocion <no-reply@emocion.pe>\r\n";
	$email_headers .= "Reply-To: <". strip_tags($sender) . ">\r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; UTF-8\r\n";

	$errLevel = error_reporting(E_ALL ^ E_NOTICE);
	// Send the email.
	if (mail($recipient, $subject, $email_content, $email_headers)) {
		$arr = array('result' => "1", 'message' => "ok" );
		//die("1");
	} else {
		$arr = array('result' => "0", 'message' => error_reporting($errLevel) );
  	//die("0");
	}
}else{
	$arr = array('result' => "0", 'message' => mysql_error() );
  //die(mysql_error());
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($arr);
?>
