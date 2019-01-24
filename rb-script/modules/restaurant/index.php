<?php
/*
Module Name: Gestion de Restaurant
Plugin URI: http://emocion.pe
Description: Gestion de base de datos de restaurant y relacionados
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "restaurant";
$rb_module_url = G_SERVER."/rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."/rb-script/modules/$rb_modure_dir/food.png";

// Ubicacion en el Menu
$menu1 = [
	'key' => 'restaurant',
	'nombre' => "Restaurant",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'show' => true,
	'item' => [
        [
					'key' => 'rest_personal',
					'nombre' => "Personal",
					'url' => "module.php?pag=rest_personal",
					'url_imagen' => "none",
					'pos' => 1
				],
				[
					'key' => 'rest_plato',
					'nombre' => "Platos",
					'url' => "module.php?pag=rest_plato",
					'url_imagen' => "none",
					'pos' => 2
				],
				[
					'key' => 'rest_mesa',
					'nombre' => "Mesas",
					'url' => "module.php?pag=rest_mesa",
					'url_imagen' => "none",
					'pos' => 3
				],
				[
					'key' => 'rest_pedido',
					'nombre' => "Generar pedido",
					'url' => "module.php?pag=rest_pedido",
					'url_imagen' => "none",
					'pos' => 4
				],
				[
					'key' => 'rest_pedido_live',
					'nombre' => "Movimiento de pedidos",
					'url' => "module.php?pag=rest_pedido_live",
					'url_imagen' => "none",
					'pos' => 5
				]
	]
];

$menu = [
	"restaurant" => $menu1
];

// CSS
function rest_css(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."restaurant/rest.css'>\n";
	return $css;
}
add_function('panel_header_css','rest_css');

// Personal
if(isset($_GET['pag']) && $_GET['pag']=="rest_personal"):
	function rest_personal_title(){
		return "Personal";
	}

	function rest_pesonal(){
		global $rb_module_url;
		include_once 'personal.init.php';
	}
	add_function('module_title_page','rest_personal_title');
	add_function('module_content_main','rest_pesonal');
endif;

// Plato
if(isset($_GET['pag']) && $_GET['pag']=="rest_plato"):
	function rest_plato_title(){
		return "Plato";
	}

	function rest_plato(){
		global $rb_module_url;
		include_once 'plato.init.php';
	}
	add_function('module_title_page','rest_plato_title');
	add_function('module_content_main','rest_plato');
endif;

// Mesa
if(isset($_GET['pag']) && $_GET['pag']=="rest_mesa"):
	function rest_mesa_title(){
		return "Mesa";
	}

	function rest_mesa(){
		global $rb_module_url;
		include_once 'mesa.init.php';
	}
	add_function('module_title_page','rest_mesa_title');
	add_function('module_content_main','rest_mesa');
endif;

// Pedido
if(isset($_GET['pag']) && $_GET['pag']=="rest_pedido"):
	function rest_pedido_title(){
		return "Pedido";
	}

	function rest_pedido(){
		global $rb_module_url;
		include_once 'pedido.init.php';
	}
	add_function('module_title_page','rest_pedido_title');
	add_function('module_content_main','rest_pedido');
endif;

// Pedido live
if(isset($_GET['pag']) && $_GET['pag']=="rest_pedido_live"):
	function rest_pedido_live_title(){
		return "Pedido Live";
	}

	function rest_pedido_live(){
		global $rb_module_url;
		include_once 'live.init.php';
	}
	add_function('module_title_page','rest_pedido_live_title');
	add_function('module_content_main','rest_pedido_live');
endif;
