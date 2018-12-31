<?php
/*
Module Name: Staff
Plugin URI: http://tuslegal.com.pe
Description: Gestiona lista de informacion de personal
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "staff";
$rb_module_url = G_SERVER."/rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."/rb-script/modules/$rb_modure_dir/staff.png";

// Ubicacion en el Menu
$menu1 = [
					'key' => 'staffs',
					'nombre' => "Staff",
					'url' => "#",
					'url_imagen' => $rb_module_url_img,
					'pos' => 1,
					'show' => true,
					'item' => [
						[
							'key' => 'staff',
							'nombre' => "Staff",
							'url' => "module.php?pag=staff",
							'url_imagen' => "none",
							'pos' => 1
						]
					]
				];

$menu = [
	"staff" => $menu1
];

function staff_title(){
	return "Staff";
}

// SIMULADOR:
if(isset($_GET['pag']) && $_GET['pag']=="staff"):
	function staff_js(){
		$js = "<script src='".G_DIR_MODULES_URL."staff/funcs.js'></script>\n";
		return $js;
	}

	function staff_content(){
		if(isset($_GET['id'])){
			include_once 'staff.form.php';
		}else {
			include_once 'staff.list.php';
		}
	}

	add_function('module_title_page','staff_title');
	add_function('panel_header_js','staff_js');
	add_function('module_content_main','staff_content');
endif;

// CSS Front End
function staff_front_css(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."staff/staff.css'>\n";
	return $css;
}
add_function('theme_header','staff_front_css');
