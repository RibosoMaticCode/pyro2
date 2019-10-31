<?php
/*
Module Name: Block Next (formulario paso a paso)
Plugin URI: http://emocion.pe
Description: Muetra un formulario y una serie de preguntas para ir paso a paso, usar [block_1_code]
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "blocknext";
$rb_module_url = G_SERVER."rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."rb-script/modules/$rb_modure_dir/crm.png";

// ------ POPUP FLOTANTES -------- //
function block_1(){
  //incluimos la clase
  include_once('template.class.php');
  //iniciamos la clase
  $tpl=new TemplateClass();
  //reemplazamos {variable} por Hola Mundo
  $tpl->Assign('servidor', G_SERVER);
  //indicamos la plantilla sin extencion solo el nombre
  return $tpl->Template('form1');
	//return $frm_customer;
}

add_shortcode('block_1_code','block_1');

// Uso [block_1_code]

// CSS Front End
function blocknext_front_css(){
  global $rb_modure_dir;
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL.$rb_modure_dir."/blocknext.css'>\n";
	return $css;
}
add_function('theme_header','blocknext_front_css');
