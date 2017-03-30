<?php
require('../../../global.php');
/*if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');*/
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-menus.class.php");
// Eliminar todo los submenus para volver a ingresarlos
$objMenu = new Menus;
if(!isset($_POST['mainmenu_id'])) die ("Error: Id Main Menu no especificado");

$objMenu->Consultar("DELETE FROM menus_items WHERE mainmenu_id=".$_POST['mainmenu_id']);

$directions = json_decode($_POST['json'],true);
//print_r($directions);
travel_json($directions);
echo "1";
function travel_json($matriz, $padre_id = 0, $nivel = 0){  // De array a base de datos
	require_once(ABSPATH."rb-script/funciones.php");
	require_once(ABSPATH."rb-script/class/rb-menus.class.php");
	$objMenu = new Menus;
	
	foreach($matriz as $row=>$value):
		//echo "El item:". $value['id']."-".$value['title']."; tiene: ";
		$menu_nombre = $value['title'];
		$menu_nombre_enlace = rb_cambiar_nombre(trim($value['title']));
		$menu_url = $value['url'];
		$menu_menuid = $value['menumain'];
		$menu_nivel = $nivel+1;
		$menu_tipo = $value['type'];
		$menu_estilo = $value['style'];
			
		$objMenu->Consultar("INSERT INTO menus_items (nombre_enlace, nombre, url, menu_id, nivel, mainmenu_id, tipo, style) VALUES ('$menu_nombre_enlace', '$menu_nombre', '$menu_url', $padre_id, $nivel, $menu_menuid, '$menu_tipo', '$menu_estilo')");
		$nuevo_padre = mysql_insert_id();
		
		if(isset($matriz[$row]['children']) ):	
			travel_json($matriz[$row]['children'], $nuevo_padre, $menu_nivel);
		endif;
	endforeach;
}
?>