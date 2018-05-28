<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

// Restriccion del nivel de usuario actual
$user_restrict = false;

// Cargamos las restricciones de mensajes en la DB
$restricts = json_decode(rb_get_values_options('message_config_restrict'), true);

// Restricciones del usuario que envia
$array_user_send = explode(",", $restricts['send_users']);
if( in_array(G_USERNIVELID, $array_user_send) ):
	$user_restrict = true;
endif;

// Restricciones del usuario destinatario, almacenamos, luego usaremos
$array_user_receive = explode(",", $restricts['receive_users']);

// Lista de usuarios admin que recibiran la notificacion
$array_admins = explode(",", $restricts['admin_users']);

// Permitir aviso por mail
$notify = $restricts['notify'];

// Valores del POST que iran en la DB
$valores = [
  'remitente_id' => $_POST['remitente_id'],
  'asunto' => $_POST['asunto'],
  'contenido' => addslashes($_POST['contenido']),
	'fecha_envio' => date('Y-m-d G:i:s')
];

// Array de ids de usuarios - destinatarios
if(!isset($_REQUEST['users'])) {
  print "[!] Debe seleccionar el o los destinatarios";
  die();
}
$array_users_id = $_REQUEST['users'];

// Array de niveles de los usuarios (campo oculto en el form)
$array_users_nivel = $_REQUEST['users_nivel_id'];

// Añadimos valores a la tabla: mensajes ---------------- RECOMENDACION, USAR TRANSACCION AQUI, DE PREFERENCIA.
$r = $objDataBase->Insert('mensajes', $valores);
if($r['result']){
	$ultimo_msje_id = $r['insert_id'];

  // GRABA DATOS EN LA TABLA DETALLES
  foreach($array_users_id as $user_id){
		$retenido = 0;
		// Si el remitente tiene restriccion, verificamos las restricciones del destinatario:
		if($user_restrict){
			$nivel_user_id = $array_users_nivel[$user_id];
			//echo $nivel_user_id."|";
			if( in_array($nivel_user_id, $array_user_receive) ):
				//echo "Enviar al admin|";
				$retenido = 1; // Si esta retenido enviar un mensaje a admin notificando todo detalles.

				// Enviar mensajes a los usuarios admin, notificandoles que un usuario con restriccion hizo un envio y espera aprobacion
				foreach ($array_admins as $user_admin_id) {
					//echo $user_admin_id."|";
					$remitente = rb_get_user_info($_POST['remitente_id']);
					$destinatario = rb_get_user_info($user_id);
					/*$mensaje = "El siguiente mensaje esta esperando aprobacion: <br />De: ".$remitente['nombrecompleto']."<br />
						Para: ".$destinatario['nombrecompleto']." <br /><pre>".addslashes($_POST['contenido'])."</pre>
						<p>Para aprobar click en el vinculo:<a href=\'".G_SERVER."/rb-admin/core/messages/message-approve.php?message_id=".$ultimo_msje_id."&receiver_id=".$user_id."\'>Aprobar el mensaje al usuario final</a></p>";*/
					$mensaje = '{"sender":"'.$remitente['nombrecompleto'].'", "receiver": "'.$destinatario['nombrecompleto'].'", "message_id": '.$ultimo_msje_id.', "receiver_id": '.$user_id.'}';
					$valores = [
					  'remitente_id' => 0,
					  'asunto' => "Mensaje pendiente de aprobación",
					  'contenido' => $mensaje,
						'fecha_envio' => date('Y-m-d G:i:s')
					];
					$r = $objDataBase->Insert('mensajes', $valores);
					if($r['result']){
						$ultimo_id = $r['insert_id'];
						$valores = [
							'mensaje_id' => $ultimo_id,
							'usuario_id' => $user_admin_id, //Envio al usuario admin
							'retenido' => 0
						];
						$objDataBase->Insert('mensajes_usuarios', $valores);
					}else{
						echo $r['error'];
					}
					// Ademas debe enviar un mensaje a su correo electronico
					if($notify==1){
						$admin_data = rb_get_user_info($user_admin_id);
						$from_name = G_TITULO;
						$mail_no_reply = "noreply@".G_HOSTNAME;
						$recipient = $admin_data['correo'];
						$subject = "Mensaje pendiente de aprobación";
						$email_content = "Tienes un mensaje en la web de ".G_TITULO.". Accede a tu cuenta para revisarlo: <a href='".G_SERVER."/login.php'>Acceder a mi cuenta</a>";
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
					}
				}
			endif;
		}
		$valores = [
			'mensaje_id' => $ultimo_msje_id,
			'usuario_id' => $user_id,
			'retenido' => $retenido
		];
		$objDataBase->Insert('mensajes_usuarios', $valores);
  }

  // REDIRECCIONAR
  $enlace=G_SERVER.'/rb-admin/index.php?pag=men&opc=send';
  header('Location: '.$enlace);
}else{
  echo "Problemas";
}
?>
