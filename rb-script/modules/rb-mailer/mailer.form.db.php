<?php
// Mailer Form from Database
// =========================
// El script envia el formulario que se edito y guardo en la base de datos
// Maneja un array de valores y los campos a validar se establecen en la configuracion del formulario

// Habilitar allow_url_fopen=on en PHP.ini
header('Content-type: application/json; charset=utf-8');

// Incluir varibales globales
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';

$recaptcha_use = false;
$recaptcha_msg = "";

// Id del formulario
if(!isset($_POST['form_id']) || $_POST['form_id']==""){
	$rspmail = [
		'result' => false,
		'msg' => 'No podemos comprobar identificador del formulario',
	];
	die(json_encode($rspmail));
}

// Buscamos formulario en BD
$r = $objDataBase->Ejecutar('SELECT * FROM forms WHERE id='.$_POST['form_id']);
if($r->num_rows == 0){
	$rspmail = [
		'result' => false,
		'msg' => 'No existe informacion de este formulario',
	];
	die(json_encode($rspmail));
}
$form = $r->fetch_assoc();
$validaciones = $form['validations']; // pasar a json

//Usa captcha?
if( isset($_POST['g-recaptcha-response']) ){
	$recaptcha_use = true;
	$secret = rb_get_values_options('secretkey'); // get DB

	$post_data = http_build_query(
    array(
        'secret' => $secret,
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    )
	);
	$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $post_data
    )
	);

	$context  = stream_context_create($opts);
  $rsp = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);

  $arr = json_decode($rsp, true);
  if($arr['success']==""){
  	$recaptcha_msg = 'spam';

  }
  if($arr['success']==1){
  	$recaptcha_msg = 'done';
  }
}

// Si respuesta del recaptcha es spam, termina todo
if($recaptcha_msg=="spam"){
	$rspmail = [
		'result' => false,
		'msg' => 'El captcha no es valido',
		'recaptcha' => $recaptcha_use,
	];
	die(json_encode($rspmail));
}

$values = $_POST['valores']; // Inputs

// Verificar existencia de ciertos elementos y validarlos
$keys_config = ['Nombres'=> 'req|min=3|max=50', 'Telefono' => 'req|min=3|max=50']; // Esta configuracion debe cargarse de la base de datos

foreach ($keys_config as $key => $value) {
		if(array_key_exists($key, $values)==false){
			echo "Campo ".$key." no existe. No podemos continuar :P";
			die();
		}else{
			// Verificamos sus opciones de validacion
			// Extraemos su configuracion
			$settings = explode("|", $value);

			// Verificamos que tipo de configuracion estan activas, en este caso verificamos 'req'
			if(in_array("req",$settings)){
				if(trim($values[$key])==""){
					//return $result = ['result' => false, 'msg' => 'Campo: '.$input_name.' no debe estar vacio'];
					echo "Campo ".$key." no debe quedar vacio :P";
					die();
				}
			}
		}
}


if(isset($values['Terminos']) && $values['Terminos']==0){
	die("No se aceptaron terminos");
}

// Armando mensaje
$email_content = "Informacion del mensaje:<br /><br />";
foreach ($values as $key => $value) {
	$email_content .= $key.": <br />".$value."<br /><br />";
}
$email_content .= "--<br />El e-mail fue enviado a través del formulario de la web.";

// Destinatarios :
$recipient = rb_get_values_options('mail_destination'); //"dweb@emocion.pe";
//$cc = "dweb@emocion.pe"; -> copia, habilitar luego

// Configuracion del cabecera
$subject = "Formulario de Contacto";
$from_name = rb_get_values_options('name_sender');
$mail_no_reply = rb_get_values_options('mail_sender');
//$mail_reply = "info@".G_HOSTNAME; -> correo de respuesta, habilitar luego

// Build the email headers. // El que envia es el sender no el usuario
$email_headers = "From: $from_name <$mail_no_reply> \r\n";
//$email_headers .= "Cc: $cc \r\n"; --> Futuras versiones
//$email_headers .= "Reply-To: <$mail_reply>\r\n"; --> Futuras versiones
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; UTF-8\r\n";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
	$rspmail = [
		'result' => true,
		'msg' => 'Envio correcto del correo',
		'recaptcha' => $recaptcha_use,
		'recaptcha_msg' => $recaptcha_msg
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
