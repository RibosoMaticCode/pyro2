<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$message_id = $_GET['message_id'];
$receiver_id = $_GET['receiver_id'];
$this_message_id = $_GET['this_message_id'];

$valores_actualizar = [
  'retenido' => 0
];
$condicion = [
  'mensaje_id' => $message_id,
  'usuario_id' => $receiver_id
];

$r = $objDataBase->Update(G_PREFIX.'messages_users', $valores_actualizar, $condicion);
if($r['result']){
  $arr = ['resultado' => true, 'contenido' => 'Mensajes aprobado' ];
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
}
//print_r($arr);

// Actualizar Asunto a $aprobado
$r = $objDataBase->Update(G_PREFIX.'messages_users', ['asunto' => "Mensaje aprobado"], ['id' => $this_message_id]);
if($r['result']){
  $arr = ['resultado' => true, 'contenido' => 'Asunto actualizado' ];
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
}

// Notificar al usuario final por correo:
$user_data = rb_get_user_info($receiver_id);
$from_name = G_TITULO;
$mail_no_reply = "noreply@".G_HOSTNAME;
$recipient = $user_data['correo'];
$subject = "Tienes un nuevo mensaje interno";
$email_content = "Tienes un mensaje en la web de ".G_TITULO.". Accede a tu cuenta para revisarlo: <a href='".G_SERVER."login.php'>Acceder a mi cuenta</a>";
// Build the email headers. // El que envia es el sender no el usuario
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
//$email_headers .= "Cc: $cc \r\n";
//$email_headers .= "Reply-To: <$mail_reply>\r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";

if (mail($recipient, $subject, $email_content, $email_headers)) {
	//echo "1";
} else {
	http_response_code(500);
	echo "Oops! Algo salio mal y no pudimos enviar tu mensaje.";
}

$enlace=G_SERVER.'rb-admin/index.php?pag=men';
header('Location: '.$enlace);
?>
