<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

if($_POST){
  $popup_url_img = trim($_POST['popup_url_img_id']);
  $popup_url_destination = trim($_POST['popup_url_destination']);
  if(!empty( $popup_url_img ) && !empty( $popup_url_destination )){
    // url_img
    if(rb_get_values_options('popup_url_img')==""){
      $objDataBase->Insert(G_PREFIX.'configuration', ['option_name' => 'popup_url_img', 'value' => $popup_url_img]); // Guarda nuevo
    }else{
      rb_set_values_options('popup_url_img', $popup_url_img); // Actuailiza
    }
    // url_destination
    if(rb_get_values_options('popup_url_destination')==""){
      $objDataBase->Insert(G_PREFIX.'configuration', ['option_name' => 'popup_url_destination', 'value' => $popup_url_destination]); // Guarda nuevo
    }else{
      rb_set_values_options('popup_url_destination', $popup_url_destination); // Actualiza
    }

    $arr = array('result' => true, 'contenido' => 'Informacion almacenada en base de datos');
		die(json_encode($arr));
  }
  $arr = array('result' => false, 'contenido' => 'Campos vacios');
  die(json_encode($arr));
}
