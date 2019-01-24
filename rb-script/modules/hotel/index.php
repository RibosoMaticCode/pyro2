<?php
/*
Module Name: Sistema para hoteles
Plugin URI: http://emocion.pe
Description: Gestion hotelera
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "hotel";
$rb_module_url = G_SERVER."/rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."/rb-script/modules/$rb_modure_dir/hotel.png";

// Ubicacion en el Menu
$menu1 = [
	'key' => 'hotel',
	'nombre' => "Gestion hotelera",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'show' => true,
	'item' => [
		[
			'key' => 'hotel_habitaciones',
			'nombre' => "Habitaciones",
			'url' => "module.php?pag=hotel_habitaciones",
			'url_imagen' => "none",
			'pos' => 1
		],
		[
			'key' => 'hotel_productos',
			'nombre' => "Productos / Servicios",
			'url' => "module.php?pag=hotel_productos",
			'url_imagen' => "none",
			'pos' => 2
		],
		[
			'key' => 'hotel_reservaciones',
			'nombre' => "Reservaciones",
			'url' => "module.php?pag=hotel_reservaciones",
			'url_imagen' => "none",
			'pos' => 3
		],
		[
			'key' => 'hotel_config',
			'nombre' => "Configuración",
			'url' => "module.php?pag=hotel_config",
			'url_imagen' => "none",
			'pos' => 4
		]
	]
];

$menu = [
	"hotel" => $menu1
];

// CSS
function hotel_css(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."hotel/hotel.css'>\n";
	return $css;
}
add_function('panel_header_css','hotel_css');

// ------ CONFIGURACIN HOTEL ------ //
if(isset($_GET['pag']) && $_GET['pag']=="hotel_config"):
	function hotel_config_title(){
		return "Configuracion de PLM";
	}
	function hotel_config(){
		global $rb_module_url;
		include_once 'config.php';
	}
	add_function('module_title_page','hotel_config_title');
	add_function('module_content_main','hotel_config');
endif;

// Administracion
// ------ HABITACIONES ------ //
if(isset($_GET['pag']) && $_GET['pag']=="hotel_habitaciones"):
	function hotel_habitaciones_title(){
		return "Habitaciones";
	}
	function hotel_habitaciones(){
		global $rb_module_url;
		include_once 'habitaciones.init.php';
	}
	add_function('module_title_page','hotel_habitaciones_title');
	add_function('module_content_main','hotel_habitaciones');
endif;

// ------ RESERVACIONES ------ //
if(isset($_GET['pag']) && $_GET['pag']=="hotel_reservaciones"):
	function hotel_reservaciones_title(){
		return "Reservaciones";
	}
	function hotel_reservaciones(){
		global $rb_module_url;
		include_once 'reservaciones.init.php';
	}
	add_function('module_title_page','hotel_reservaciones_title');
	add_function('module_content_main','hotel_reservaciones');
endif;


// ------ PRODUCTOS SERVICIOS  ------ //
if(isset($_GET['pag']) && $_GET['pag']=="hotel_productos"):
	function hotel_productos_title(){
		return "Productos / Servicios adicionales";
	}
	function hotel_productos(){
		global $rb_module_url;
		include_once 'productos.init.php';
	}
	add_function('module_title_page','hotel_productos_title');
	add_function('module_content_main','hotel_productos');
endif;
