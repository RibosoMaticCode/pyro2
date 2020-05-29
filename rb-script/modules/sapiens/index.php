<?php
/*
Module Name: Sapiens pedidos
Plugin URI: https://emocion.pe
Description: Muestra un formulario para capturar datos de usuario solicitando un producto mediante una url. Usar el shortcode SAPIENS_ORDERS_FORM, colocar la clase 'frmSapiensShow' en un link para mostrar el formulario.
Author: Jesus Liñan
Version: 1.1
Author URI: https://www.ribosomatic.com
*/

$rb_module_url_img = G_DIR_MODULES_URL."sapiens/interface.png";

// Personalizar estructura del Menu
$menu1 = array(
	'key' => 'sapiens',
	'nombre' => "Sapiens",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'extend' => false,
	'show' => true,
	'item' => array(
		array(
			'key' => 'sapiens_orders',
			'nombre' => "Pedidos",
			'url' => "module.php?pag=sapiens_orders",
			'url_imagen' => "none",
			'pos' => 1
		)
	)
);

$menu = [
	"sapiens" => $menu1
];

// ------ ORDERS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="sapiens_orders"):
	function sapiens_orders_title(){
		return "Sapiens pedidos";
	}
	function sapiens_orders_content(){
		global $objDataBase;

		$q = $objDataBase->Ejecutar('SELECT * FROM sapiens_orders ORDER BY date DESC');

		include_once 'sapiens.orders.init.php';
	}

	add_function('module_title_page','sapiens_orders_title');
	add_function('module_content_main','sapiens_orders_content');
endif;

// -------- FORMULARIO FRONTEND ---------- //
function sapiens_orders_form(){
  	//incluimos la clase
  	include_once './rb-script/template.class.php';

  	//iniciamos la clase
  	$tpl=new TemplateClass();

  	// directorio del template
  	$tpl->DirTemplate("rb-script/modules/sapiens/sapiens.orders.formfrontend/");

	// {variables} que reemplazaremos en la plantilla
	$tpl->Assign('ruta_modulo', G_DIR_MODULES_URL."sapiens/");

	//indicamos la plantilla sin extension solo el nombre
	return $tpl->Template('form');
}

add_shortcode('SAPIENS_ORDERS_FORM','sapiens_orders_form');


// ------------- CSS / JS ---------------//
function sapiens_header_files(){
	//$files = "<script src='".G_DIR_MODULES_URL."suscripciones/suscrip.js'></script>\n";
	$files = "<link rel='stylesheet' type='text/css' href='".G_DIR_MODULES_URL."sapiens/sapiens.orders.formfrontend/form.css' />\n";
	return $files;
}
add_function('theme_header','sapiens_header_files');