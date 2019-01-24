<?php
header('Content-type: application/json; charset=utf-8');
/**
 * Ejemplo 2
 * Como crear un charge a una tarjeta usando Culqi PHP.
 */
 if ( !defined('ABSPATH') )
 	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

  $token_id = $_GET['token'];
  $amount = $_GET['amount'];
  $email = $_GET['email'];

include_once ABSPATH.'rb-script/modules/plm/funcs.php';
try {
  // Usando Composer (o puedes incluir las dependencias manualmente)
  //require '../vendor/autoload.php';

  // Cargamos Requests y Culqi PHP
  include_once ABSPATH.'rb-script/modules/plm/lib/Requests/library/Requests.php';
  Requests::register_autoloader();
  include_once ABSPATH.'rb-script/modules/plm/lib/culqi-php/lib/culqi.php';

  // Configurar tu API Key y autenticación
  $SECRET_API_KEY = get_option('key_private');
  $culqi = new Culqi\Culqi(array('api_key' => $SECRET_API_KEY));

  // Creando Cargo a una tarjeta
  $charge = $culqi->Charges->create(
      array(
        "amount" => $amount,
        "capture" => true,
        "currency_code" => "PEN",
        "email" => $email,
        "description" => "Pago de productos",
        "installments" => 0,
        "metadata" => array("test"=>"test"), //?
        "source_id" => $token_id
      )
  );
  // Respuesta
  echo json_encode($charge);

} catch (Exception $e) {
  /*print_r($e->getMessage());
  echo json_encode($e->getMessage());*/
  echo $e->getMessage();
}
