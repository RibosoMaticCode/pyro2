<?php
/*
Module Name: Gestion de Clientes 1.0
Plugin URI: http://emocion.pe
Description: Gestion de base de datos de clientes y relacionados
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "crm";
$rb_module_url = G_SERVER."/rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."/rb-script/modules/$rb_modure_dir/crm.png";

// Ubicacion en el Menu
$menu1 = [
	'key' => 'crm',
	'nombre' => "Gestion de clientes",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'show' => true,
	'item' => [
        [
            'key' => 'customers',
			'nombre' => "Clientes",
			'url' => "module.php?pag=customers",
			'url_imagen' => "none",
			'pos' => 1
		],
		[
            'key' => 'notifications',
            'nombre' => "Notificaciones",
            'url' => "module.php?pag=notifications",
            'url_imagen' => "none",
            'pos' => 4
        ],
        [
            'key' => 'visits',
            'nombre' => "Visitas / Atencion",
            'url' => "module.php?pag=visits",
            'url_imagen' => "none",
            'pos' => 2
		],
		[
            'key' => 'reports',
            'nombre' => "Reportes",
            'url' => "module.php?pag=reports",
            'url_imagen' => "none",
            'pos' => 3
        ]
	]
];

$menu = [
	"crm" => $menu1
];

// Titulo de la pagina web
function crm_title(){
	return "Gestion de clientes";
}

/* CUSTOMS FUNCTIONS */


// ------ CLIENTES ------ //
if(isset($_GET['pag']) && $_GET['pag']=="customers"):
	function crm_customers(){
		global $rb_module_url;
		include_once 'customers.php';
	}
	add_function('module_title_page','crm_title');
	add_function('module_content_main','crm_customers');
endif;

// ------ VISITAS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="visits"):
	function crm_visits(){
		global $rb_module_url;
		include_once 'visits.php';
	}
	add_function('module_title_page','crm_title');
	add_function('module_content_main','crm_visits');
endif;

// ----- REPORTES ------- //
if(isset($_GET['pag']) && $_GET['pag']=="reports"):
	function crm_reports(){
		require_once 'funcs.php';
		global $rb_module_url;
		include_once 'reportintro.php';
		include_once 'report1.php';
		include_once 'report2.php';
		include_once 'report3.php';
	}
	add_function('module_title_page','crm_title');
	add_function('module_content_main','crm_reports');
endif;

// ------ NOTIFICACIONES ------ //
if(isset($_GET['pag']) && $_GET['pag']=="notifications"):
	function crm_notifications(){
		global $rb_module_url;
		require_once 'funcs.php';
		include_once 'notifications.php';
	}
	add_function('module_title_page','crm_title');
	add_function('module_content_main','crm_notifications');
endif;