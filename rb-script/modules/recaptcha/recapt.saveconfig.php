<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

if($_POST){
  $sitekey = trim($_POST['sitekey']);
  $secretkey = trim($_POST['secretkey']);
  if(!empty( $sitekey ) && !empty( $secretkey )){
    // Site key save
    if(rb_get_values_options('sitekey')==""){
      $objDataBase->Insert('opciones', ['opcion' => 'sitekey', 'valor' => $sitekey]); // Guarda nuevo
    }else{
      rb_set_values_options('sitekey', $sitekey); // Actuailiza
    }
    // Secret key save
    if(rb_get_values_options('secretkey')==""){
      $objDataBase->Insert('opciones', ['opcion' => 'secretkey', 'valor' => $secretkey]); // Guarda nuevo
    }else{
      rb_set_values_options('secretkey', $secretkey); // Actualiza
    }

    $arr = array('result' => true, 'contenido' => 'Informacion almacenada en base de datos');
		die(json_encode($arr));
  }
  $arr = array('result' => false, 'contenido' => 'Campos vacios');
  die(json_encode($arr));
}
?>
