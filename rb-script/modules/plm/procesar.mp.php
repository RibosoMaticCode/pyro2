<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once 'funcs.php';
// Cargar la session de carrito de compra
// Para obtener el total del carrito de compra
$cart = $_SESSION['carrito'];
$totsum = 0;
$i = 0;

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
  }else{
    if($product['precio_oferta']==0) $precio_final = $product['precio'];
    else $precio_final = $product['precio_oferta'];
  }

  $tot = round($precio_final * $cantidad,2);
  $totsum += $tot;
  $i++;
}

// Obtener correo del usuario
$user = rb_get_user_info(G_USERID);
$user_mail = $user['correo'];

// Realizar el pago
  $token = $_REQUEST["token"];
  $payment_method_id = $_REQUEST["payment_method_id"];
  $installments = $_REQUEST["installments"];
  $issuer_id = $_REQUEST["issuer_id"];
  $monto = $totsum;

  require_once 'vendor/autoload.php';

  MercadoPago\SDK::setAccessToken( get_option('key_private') );
  //...
  $payment = new MercadoPago\Payment();
  $payment->transaction_amount = $monto;
  $payment->token = $token;
  $payment->description = "Compra de productos de ".G_TITULO;
  $payment->installments = $installments;
  $payment->payment_method_id = $payment_method_id;
  $payment->issuer_id = $issuer_id;
  $payment->payer = array(
  "email" => $user_mail //del cliente - pagador
  );
  // Guarda y postea el pago
  $payment->save();
  //...
  // Imprime el estado del pago
  //echo $payment->status;

	// testing...
	//print_r($payment);

	// Verificar estado del proceso
	if($payment->status=="approved"){
		// Si proceso exitoso crear el pedido en la base de datos y
		// Notificar al admini y al cliente
		$charge_id = $payment->id;
		include_once 'payment.success.mp.php';
	}else{
		die("Error. Volver a intentar");
	}
  //...
?>
