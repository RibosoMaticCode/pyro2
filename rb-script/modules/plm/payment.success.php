<?php
$send_mail = false; // Modo local no enviara el mail

header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/modules/plm/funcs.php';

//metodo de pago por defecto: tarjeta
$metodo = 1; 
$estado = 1; // Por defecto pagado
$metodo_text = "Tarjeta";

$result_message = "";
switch( $_GET['method'] ){
	case 'transfer':
		$metodo = 2;
		$estado = 0;
		$metodo_text = "Transferencia";
		break;
	case 'order_only':
		$metodo = 0;
		$estado = 0;
		$metodo_text = "Solo pedido";
		break;
}

/* Obtener datos del cliente */
/* Sino esta logueado, y metodo de SOLO PEDIDO consultar la variable con sus datos */
if(G_ACCESOUSUARIO == 0){
	if( $_GET['method']=="order_only" && isset($_GET['data_client']) ){
		$cliente = json_decode($_GET['data_client'], true);
		$cliente['nombrecompleto'] = $cliente['nombres']." ".$cliente['apellidos'];
		$cliente['telefono_fijo'] = $cliente['telefono_movil'];
	}
}else{
	$cliente = rb_get_user_info(G_USERID);
}

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
	$cart = $_SESSION['carrito'];
	foreach($cart as $item){
		$codigo = $item['product_id'];
		$cantidad = $item['cant'];
		$combo_id = $item['variant_id'];

    $qp = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$codigo);
    $product = $qp->fetch_assoc();

		if($combo_id>0){
			$qc = $objDataBase->Ejecutar("SELECT * FROM plm_products_variants WHERE variant_id=".$combo_id);
			$combo = $qc->fetch_assoc();
			if($combo['price_discount']==0) $precio_final = $combo['price'];
			else $precio_final = $combo['price_discount'];
			$variant_details = "<br />Variante: ".$combo['name'];
		}else{
			if($product['precio_oferta']==0) $precio_final = $product['precio'];
			else $precio_final = $product['precio_oferta'];
			$variant_details = "";
		}

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
      <td style="text-align:center;"><a href="'.$product_url.'">'.$product['nombre'].'</a><span>'.$variant_details.'</span></td>
      <td style="text-align:center;">'.G_COIN.' '.number_format($precio_final, 2).'</td>
      <td style="text-align:center;">'.$cantidad.'</td>
      <td style="text-align:center;">'.G_COIN.' '.number_format($tot, 2).'</td>
    </tr>';

    $totsum += $tot;
  }

$html_content .= '
  </tbody>
  <tfoot>';

if(isset($_SESSION['discount']) && count($_SESSION['discount'])>0){
	$discount = $_SESSION['discount']; 
	$totsum = $discount['tot_update']; 
	$html_content .= '
		<tr>
			<td colspan="3"  style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;">
			<strong>Cupon aplicado: '.$discount['coupon']['code'].'</strong>
			</td>
			<td style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;"><strong>Descuento</strong></td>
			<td  style="text-align:center;padding: 5px;border-top: 1px solid #ffffff;border-bottom: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;background: #fafafa;">
			<strong>'.$discount['coin'].' '.number_format(round($discount['tot_discount'], 2),2).'</strong>
			</td>
		</tr>
	';
}   
$html_content .= '
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

//Crear la orden del pedido
$valores = [
  	'fecha_registro' => date('Y-m-d G:i:s'),
  	'detalles' => $html_content,
  	'total' => round($totsum, 2),
  	'user_id' => G_USERID,
	'charge_id' => $charge_id,
	'forma_pago' => $metodo,
	'client_names' => $cliente['nombrecompleto'],
	'client_address' => $cliente['direccion'],
	'client_email' => $cliente['correo'],
	'client_phone' => $cliente['telefono_movil'],
	'status' => $estado
];

$r = $objDataBase->Insert('plm_orders', $valores);
if($r['result']){
	// Guardar uso del cupon-usuario
	if(isset($_SESSION['discount']) && count($_SESSION['discount'])>0){
		$user_id = G_USERID;
		$coupon_id = $_SESSION['discount']['coupon']['id'];

		$rc = $objDataBase->Ejecutar('SELECT * FROM plm_coupons_user WHERE user_id='.$user_id.' AND coupon_id='.$coupon_id);

		if($rc->num_rows > 0){
			$objDataBase->Ejecutar('UPDATE plm_coupons_user SET used = used + 1 WHERE user_id='.$user_id.' AND coupon_id='.$coupon_id);
		}else{
			$coupon_values = [
				'user_id' => G_USERID,
				'coupon_id' => $_SESSION['discount']['coupon']['id'],
				'used' => 1
			];
			$objDataBase->Insert('plm_coupons_user', $coupon_values);
		}
	}
	// Fin guardar cupon-usuario

	$unique_code = date('Ymd').str_pad($r['insert_id'], 6, '0', STR_PAD_LEFT);
	$objDataBase->Update('plm_orders', ['codigo_unico' => $unique_code], ['id' => $r['insert_id']]);

	// Enviar informacion del pedido al cliente por correo
	if($send_mail){
		// Destinatarios :
		$recipient = $cliente['correo'];

		// Configuracion del cabecera
		$subject = $cliente['nombres']." gracias por tu pedido";
		$from_name = rb_get_values_options('name_sender');
		$mail_no_reply = rb_get_values_options('mail_sender');

		// Content
		$email_content = "<div style='background-color:whitesmoke; padding:20px 10px;'><div style='padding:15px;margin:0 auto;width:100%;max-width:600px'><img src='".rb_photo_login(G_LOGO)."' alt='logo' style='max-width:120px' /></div>";
		$email_content .= "<div style='background-color:#fff;width:100%;max-width:600px;margin:0 auto;padding:15px;'><h1>Gracias por tu pedido, ".$cliente['nombres']."</h1>";
		$email_content .= "<p>Pronto nos comunicaremos contigo para coordinar el pago y/o envio</p><p><strong>Número de pedido: ".$unique_code."</strong></p><br />".$html_content."<br /><p>----<br />Este correo fue enviado automaticamente, no responder.</p></div>";

		// Build the email headers. // El que envia es el sender no el usuario
		$email_headers = "From: $from_name <$mail_no_reply> \r\n";
		$email_headers .= "MIME-Version: 1.0\r\n";
		$email_headers .= "Content-Type: text/html; UTF-8\r\n";

		mail($recipient, $subject, $email_content, $email_headers);
	}

	// Enviar informacion de respuesta y/o al cliente por mail, segun tipo de metodo usado
	if($metodo==0){ // Solo pedido
		$result_message = '<h2 style="text-align: center;">GRACIAS, TU PEDIDO SE HA REGISTRADO</h2>
			<p>Recibirás un correo con los detalles de tu pedido</p>
			<p>Nos pondremos en contacto contigo lo mas pronto</p><br /><br /><a href="'.G_SERVER.'">Cerrar</a>';
	}

	if($metodo==2){ // Transferencia. Envio de datos de cuentas a transferir
		$subject = "Información para realizar la transferencia/deposito";
		$result_message = '<h2 style="text-align: center;">GRACIAS, TU PEDIDO SE HA REGISTRADO</h2>
		<table style="border-collapse: collapse; width: 100%;max-width:500px" border="1">
		<tbody>
		<tr>
		<td style="width: 50%;">Número de pedido</td>
		<td style="width: 50%;"><strong>'.$unique_code.'</strong></td>
		</tr>
		<tr>
		<td style="width: 50%;">Fecha</td>
		<td style="width: 50%;"><strong>'.date('d-m-Y G:i:s').'</strong></td>
		</tr>
		<tr>
		<td style="width: 50%;">Total </td>
		<td style="width: 50%;"><strong>'.G_COIN.' '.number_format(round($totsum, 2), 2).'</strong></td>
		</tr>
		<tr>
		<td style="width: 50%;">Método de pago</td>
		<td style="width: 50%;"><strong>Transferencia</strong></td>
		</tr>
		<tr>
		<td style="width: 50%;">Banco</td>
		<td style="width: 50%;"><strong>'.get_option('transfer_bank').'</strong></td>
		</tr>
		<tr>
		<td style="width: 50%;">Cuenta</td>
		<td style="width: 50%;line-height:26px;"><strong>'.nl2br(get_option('transfer_account')).'</strong></td>
		</tr>
		</tbody>
		</table>
		<p>Después de realizar tu transferencia o depósito enviar la información a cualquiera de estos medios:</p>
		<table style="border-collapse: collapse; width: 100%;max-width:500px;" border="1">
		<tbody>
		<tr>
		<td style="width: 50%;">Celular </td>
		<td style="width: 50%;"><strong>'.get_option('transfer_phone').'</strong></td>
		</tr>
		<tr>
		<td style="width: 50%;">Correo electrónico</td>
		<td style="width: 50%;"><strong>'.get_option('transfer_mail').'</strong></td>
		</tr>
		</tbody>
		</table>
		<p>Cualquier consulta no dudes en hacerla.</p>';
		if($send_mail){
			mail($recipient, $subject, $result_message, $email_headers);
		}
	}

	// Enviar informacion del pedido al admin
	if($send_mail){
		
		// Destinatarios :
		$recipient = rb_get_values_options('mail_destination');

		// Configuracion del cabecera
		$subject = "Nueva Orden de Pedido";
		$from_name = rb_get_values_options('name_sender');
		$mail_no_reply = rb_get_values_options('mail_sender');

		// Content
		$email_content = "<strong>Hola ".G_TITULO."!</strong><p>Hay una nueva orden de pedido: ".$unique_code."</p><p>Detalles a continuacion:</p><br />".$html_content."<br />";
		$email_content .= "<p>Datos del cliente:</p><p>Nombres completos: <strong>".$cliente['nombrecompleto']."</strong></p><p>Telefonos: <strong>".$cliente['telefono_fijo']."/".$cliente['telefono_movil']."</strong></p><p>Correo electronico: <strong>".$cliente['correo']."</strong></p><p>Dirección: <strong>".$cliente['direccion']."</strong></p>";
		$email_content .= "<p>Metodo de pago: <strong>".$metodo_text."</strong></p>";
		$email_content .= "<p>----<br />Este correo fue enviado automaticamente, no responder.</p>";

		// Build the email headers. // El que envia es el sender no el usuario
		$email_headers = "From: $from_name <$mail_no_reply> \r\n";
		$email_headers .= "MIME-Version: 1.0\r\n";
		$email_headers .= "Content-Type: text/html; UTF-8\r\n";

		mail($recipient, $subject, $email_content, $email_headers);
	}
  	$arr = [
		'resultado' => true,
		'contenido' => 'Pedido generado con exito. Se envio informacion de este a tu cuenta de correo asociada. Nos pondremos en contacto pronto.',
		'result_message' => $result_message,
		'metodo' => $metodo
	];
  	unset($_SESSION['carrito']);
  	unset($_SESSION['discount']);
}else{
  	$arr = ['resultado' => false, 'contenido' => $r['error']];
}
die(json_encode($arr));
?>
