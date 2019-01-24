<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

function get_option($option){
  global $objDataBase;
  $r = $objDataBase->Ejecutar("SELECT hotel_value FROM hotel_config WHERE hotel_option='".$option."'");
  $option = $r->fetch_assoc();
  return rb_BBCodeToGlobalVariable($option['hotel_value']);
}

function estado_habitacion($estado){
  switch ($estado) {
    case '1':
      return "Reservado";
      break;
    case '2':
      return "Ocupado";
      break;
    case '0':
      return "Anulado";
      break;
    case '3':
      return "Pagado";
    default:
      // code...
      break;
  }
}

?>
