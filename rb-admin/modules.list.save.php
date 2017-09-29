<?php
require_once("../global.php");
include 'islogged.php';
//require_once("../rb-script/class/rb-opciones.class.php");
$module_name = $_GET['name'];

// Carga formato json de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array php
$array_modules = json_decode($modules_prev, true);

// ACTIVAR UN MODULO
if(isset($_GET['action']) && $_GET['action']=='active'):
	$module_ruta = $_GET['path'];

	// Sino existe el nombre del modulo en la lista, lo agregamos al array
	if (!array_key_exists($module_name, $array_modules)){
		$array_modules[$module_name] = $module_ruta;

		// Cargar modulo para cargar su menu,y agregarlo al menu_panel caso lo hubiera
		require_once $module_ruta;
		if(isset($menu)){
			// cargar menu_panel(json) de la base de datos en un array
			$menu_panel_array = json_decode(rb_get_values_options('menu_panel'), true);

			// añade el menu del modulo
			$menu_panel_array[$rb_module_unique] = $menu;

			// actualiza el menu_panel ahora incluyendo el menu del modulo
			rb_set_values_options('menu_panel', json_encode($menu_panel_array));
		}
	}
endif;
// DESACTIVAR UN MODULO
if(isset($_GET['action']) && $_GET['action']=='desactive'):
	$module_ruta = $_GET['path'];

	// Si existe el nombre del modulo en la lista, lo quitamos al array
	if (array_key_exists($module_name, $array_modules)){
		unset($array_modules[$module_name]);

		// Cargar modulo para quitar el menu, caso lo hubiera
		require_once $module_ruta;
		if(isset($menu)){
			// cargar menu_panel(json) de la base de datos en un array
			$menu_panel_array = json_decode(rb_get_values_options('menu_panel'), true);

			// añade el menu del modulo
			unset($menu_panel_array[$rb_module_unique]);

			// actualiza el menu_panel ahora incluyendo el menu del modulo
			rb_set_values_options('menu_panel', json_encode($menu_panel_array));
		}
	}
endif;

// Convierte array en json
$array_modules_json = json_encode($array_modules);

// Guarda formato js en base datos
rb_set_values_options('modules_load',$array_modules_json);

// Retornar a lista de modulos
$urlreload =  G_SERVER."/rb-admin/modules.php";
header('Location: '.$urlreload);
?>
