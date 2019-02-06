<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

// Se encargara de enviar informacion tanto a cliente como al administrador del pago
// PREPARANDO EL HTML PARA ENVIAR POR CORREO AL USUARIO
$html_content = '
<table style="font-family: Arial, Helvetica, sans-serif;color: #666;font-size: 0.9em;text-shadow: 1px 1px 0px #fff;background: #eaebec;border: #ccc 1px solid;-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;-moz-box-shadow: 0 1px 2px #d1d1d1;-webkit-box-shadow: 0 1px 2px #d1d1d1;box-shadow: 0 1px 2px #d1d1d1;width: 100%;margin: 10px 0;" class="carrito" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th style="padding: 10px 15px;border-top: 1px solid #fafafa;border-bottom: 1px solid #e0e0e0;background: #ededed;" colspan="2">Producto</th>
      <th style="padding: 10px 15px;border-top: 1px solid #fafafa;border-bottom: 1px solid #e0e0e0;background: #ededed;">Precio</th>
      <th style="padding: 10px 15px;border-top: 1px solid #fafafa;border-bottom: 1px solid #e0e0e0;background: #ededed;">Cantidad</th>
      <th style="padding: 10px 15px;border-top: 1px solid #fafafa;border-bottom: 1px solid #e0e0e0;background: #ededed;">Total</th>
    </tr>
  </thead>
  <tbody>';

  $totsum = 0;
  foreach($_SESSION['carrito'] as $codigo => $cantidad){
    $qp = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$codigo);
    $product = $qp->fetch_assoc();
		if($product['precio_oferta']==0) $precio_final = $product['precio'];
		else $precio_final = $product['precio_oferta'];
		$tot = round($precio_final * $cantidad,2);
    $photo = rb_get_photo_details_from_id($product['foto_id']);

    if(G_ENL_AMIG) $product_url = G_SERVER."/products/".$product['nombre_key']."/";
    else $product_url = G_SERVER."/?products=".$product['id'];

		// Actualizar las salidas de cada producto
		//$objDataBase->Update('plm_products', ['salidas' => 'salidas +'.$cantidad], ['id' => $product['id']]);
		$objDataBase->Ejecutar('UPDATE plm_products SET salidas = salidas + 1 WHERE id ='.$product['id']);

    $html_content .= '
    <tr>
      <td style="text-align:center;"><img style="max-width:100px;" src="'.$photo['thumb_url'].'" alt="img" /></td>
      <td style="text-align:center;"><a href="'.$product_url.'">'.$product['nombre'].'</a></td>
      <td style="text-align:center;">'.G_COIN.' '.number_format($precio_final, 2).'</td>
      <td style="text-align:center;">'.$cantidad.'</td>
      <td style="text-align:center;">'.G_COIN.' '.number_format($tot, 2).'</td>
    </tr>';

    $totsum += $tot;
  }

$html_content .= '
  </tbody>
  <tfoot>
    <tr>
      <td style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;"></td>
      <td style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;"></td>
      <td style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;"></td>
      <td style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;"><strong>TOTAL</strong></td>
      <td style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;"><strong>'.G_COIN.' '.number_format(round($totsum, 2), 2).'</strong></td>
    </tr>
  </tfoot>
</table>';

if(isset($_GET['charge_id'])){
	$charge_id = $_GET['charge_id'];
}else{
	$charge_id = "000000";
}
//Crear una orden del pedido
$valores = [
  'fecha_registro' => date('Y-m-d G:i:s'),
  'detalles' => $html_content,
  'total' => round($totsum, 2),
  'user_id' => G_USERID,
	'charge_id' => $charge_id
];

$r = $objDataBase->Insert('plm_orders', $valores);
if($r['result']){
	$unique_code = date('Ymd').str_pad($r['insert_id'], 6, '0', STR_PAD_LEFT);
	$objDataBase->Update('plm_orders', ['codigo_unico' => $unique_code], ['id' => $r['insert_id']]);

	// ----------- ENVIAR MAIL A CLIENTE
	$cliente = rb_get_user_info(G_USERID);

	// Destinatarios :
	$recipient = $cliente['correo'];

	// Configuracion del cabecera
	$subject = $cliente['nombres']."gracias por tu pedido";
	$from_name = rb_get_values_options('name_sender');
	$mail_no_reply = rb_get_values_options('mail_sender');

	// Content
	$email_content = "<div style='background-color:whitesmoke; padding:20px 10px;'><div style='padding:15px;margin:0 auto;width:100%;max-width:600px'><img src='".rb_photo_login(G_LOGO)."' alt='logo' style='max-width:120px' /></div>";
	$email_content .= "<div style='background-color:#fff;width:100%;max-width:600px;margin:0 auto;padding:15px;'><h1>Gracias por tu pedido, ".$cliente['nombres']."</h1><p>Pronto nos comunicaremos contigo para coordinar el envio</p><p><strong>Número de pedido: ".$unique_code."</strong></p><br />".$html_content."<br /><p>----<br />Este correo fue enviado automaticamente, no responder.</p></div>";

	// Build the email headers. // El que envia es el sender no el usuario
	$email_headers = "From: $from_name <$mail_no_reply> \r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; UTF-8\r\n";

	mail($recipient, $subject, $email_content, $email_headers);

	// ----------- ENVIAR MAIL A ADMIN DEL SITIO
	// Destinatarios :
	$recipient = rb_get_values_options('mail_destination');

	// Configuracion del cabecera
	$subject = "Nueva Orden de Pedido";
	$from_name = rb_get_values_options('name_sender');
	$mail_no_reply = rb_get_values_options('mail_sender');

	// Content
	$email_content = "<strong>Hola ".G_TITULO."!</strong><p>Hay una nueva orden de pedido: ".$unique_code."</p><p>Detalles a continuacion:</p><br />".$html_content."<br />";
	$email_content .= "<p>Datos del cliente:</p><p>Nombres completos: <strong>".$cliente['nombrecompleto']."</strong></p><p>Telefonos: <strong>".$cliente['telefono_fijo']."/".$cliente['telefono_movil']."</strong></p><p>Correo electronico: <strong>".$cliente['correo']."</strong></p><p>Dirección: <strong>".$cliente['direccion']."</strong></p><p>----<br />Este correo fue enviado automaticamente, no responder.</p>";

	// Build the email headers. // El que envia es el sender no el usuario
	$email_headers = "From: $from_name <$mail_no_reply> \r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; UTF-8\r\n";

	mail($recipient, $subject, $email_content, $email_headers);

  $arr = ['resultado' => true, 'contenido' => 'Pedido generado con exito. Se envio informacion de este a tu cuenta de correo asociada. Nos pondremos en contacto pronto.' ];
  unset($_SESSION['carrito']);
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
}
die(json_encode($arr));
?>
