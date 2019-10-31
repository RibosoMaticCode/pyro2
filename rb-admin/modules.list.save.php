<?php
require_once "../global.php";
require_once '../rb-script/hook.php';;
include 'islogged.php';

// Capturando nombre del modulo
$module_name = $_GET['name'];

// Carga lista de modulos en formato json, de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array php
$array_modules = json_decode($modules_prev, true);

// ACTIVAR UN MODULO
if(isset($_GET['action']) && $_GET['action']=='active'):
	// Capturando ruta de sistema del modulo
	$module_ruta = $_GET['path'];

	// Sino existe el nombre del modulo en la lista, lo agregamos al array
	if (!array_key_exists($module_name, $array_modules)){
		$array_modules[$module_name] = $module_ruta;

		// Cargar modulo para cargar su menu,y agregarlo al menu_panel caso lo hubiera
		require_once $module_ruta;
		if(isset($menu)){ // La variable $menu es un array que se encuentra detallado en el archivo inicial del modulo
			// cargar menu del gestor (json) de la base de datos y lo pasamos a un array php
			$menu_panel_array = json_decode(rb_get_values_options('menu_panel'), true);

			// Añadimos menu(s) del modulo al Menu Principal
			$menu_panel_array = array_merge($menu_panel_array, $menu);

			// añade el menu del modulo
			//$menu_panel_array[$rb_module_unique] = $menu; // La variable $rb_module_unique, se encuentra en el archivo inicial del modulo, y especifica un nombre unico para modulo y menu

			// actualiza el menu_panel ahora incluyendo el menu del modulo
			rb_set_values_options('menu_panel', json_encode($menu_panel_array, JSON_UNESCAPED_UNICODE));

			// ACTUALIZAR MENU DE CADA NIVEL DE USUARIO, AÑADIENDO EL MENU DEL MODULO NUEVO
			$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_levels WHERE permisos <> ''");// Consultar si nivel tiene datos de su propio menu
			// Recorremos todos los niveles que tiene menus
			while($row= $q->fetch_assoc()):
				$nivel_id = $row['id'];
				$menu_panel_nivel = json_decode($row['permisos'], true);
				// añade el menu(s) del modulo al menu principal del usuario
				$menu_panel_nivel = array_merge($menu_panel_nivel, $menu);

				// Asignar valor al campo permisos de la tabla usuario_niveles, que sera actualizado
				$valores = [
				  'permisos' => json_encode($menu_panel_nivel, JSON_UNESCAPED_UNICODE)
				];

				//Guardando nueva estructura de menu, en los permisos del nivel de usuario
				$objDataBase->Update(G_PREFIX.'users_levels', $valores, ["id" => $nivel_id]);
			endwhile;
		}
	}
endif;
// DESACTIVAR UN MODULO
if(isset($_GET['action']) && $_GET['action']=='desactive'):
	$module_ruta = $_GET['path'];

	// Si existe el nombre del modulo en la lista, lo quitamos al array de Modulos de la DB
	if (array_key_exists($module_name, $array_modules)){
		unset($array_modules[$module_name]);

		// Cargar modulo para quitar el menu o menus, caso lo hubiera
		require_once $module_ruta;
		if(isset($menu)){
			// ACTUALIZAR MENU PRINCIPAL DE LA BASE DE DATOS POR DEFECTO
			// cargar menu_panel(json) de la base de datos en un array
			$menu_panel_array = json_decode(rb_get_values_options('menu_panel'), true);

			// elimina el menu(s) del modulo del menu principal
			foreach ($menu as $key => $value) {
				unset($menu_panel_array[$key]);
			}

			// actualiza el menu_panel ahora incluyendo el menu del modulo
			rb_set_values_options('menu_panel', json_encode($menu_panel_array, JSON_UNESCAPED_UNICODE));

			// ACTUALIZAR MENU DE CADA NIVEL
			$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_levels WHERE permisos <> ''");// Consultar si nivel tiene datos de su propio menu
			// Recorremos todos los niveles que tiene menus
			while($row= $q->fetch_assoc()):
				$nivel_id = $row['id'];
				$menu_panel_nivel = json_decode($row['permisos'], true);
				// elimina el menu(s) del modulo del menu principal
				foreach ($menu as $key => $value) {
					unset($menu_panel_nivel[$key]);
				}

				// Asignar valor al campo permisos de la tabla usuario_niveles, que sera actualizado
				$valores = [
				  'permisos' => json_encode($menu_panel_nivel, JSON_UNESCAPED_UNICODE)
				];

				//Guardando nueva estructura de menu, en los permisos del nivel de usuario
				$objDataBase->Update(G_PREFIX.'users_levels', $valores, ["id" => $nivel_id]);
			endwhile;
		}
	}
endif;

// Convierte array en json
$array_modules_json = json_encode($array_modules);

// Guarda formato js en base datos
rb_set_values_options('modules_load',$array_modules_json);

// Retornar a lista de modulos
$urlreload =  G_SERVER."rb-admin/modules.php";
header('Location: '.$urlreload);
?>
