<?php
header('Content-type: application/json; charset=utf-8');
// Recibimos items del menu principal con nuevo orden, y si esta oculto o no.
$obj = json_decode($_GET['mydata'], true);

// ID del nivel
$nivel_id = $_GET['nivel_id'];

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'rb-script/funciones.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

// Consultamos el menu gestor en json desde la base de datos
$menu_main_json = rb_get_values_options('menu_panel');

// pasamos menu gestor json a un array en php
$menu_main_array = json_decode($menu_main_json, true);

// recorrer $obj, el nuevo orden del menu principal
foreach ($obj as $key => $value) {
  $item_key = $value['name']; // obtenemos el id o nombre del menu, para ubicarlo en el array php
  $item_pos = $value['position']; // obtenemos el valor de la nueva posion que tendra el item del menu
  $item_show = $value['show'];

  // Asignar nueva posicion al item del menu
  $menu_main_array[$item_key]['pos'] = $item_pos;
  // Asignar si estara oculto o no
  $menu_main_array[$item_key]['show'] = $item_show;
}

// ordenar por campo "pos": https://stackoverflow.com/questions/1597736/how-to-sort-an-array-of-associative-arrays-by-value-of-a-given-key-in-php
$orden = array();
foreach ($menu_main_array as $key => $row){
  $orden[$key] = $row['pos'];
}
array_multisort($orden, SORT_ASC, $menu_main_array);

// Asignar valor al campo permisos de la tabla usuario_niveles, que sera actualizado
$valores = [
  'permisos' => json_encode($menu_main_array)
];

//Guardando nueva estructura de menu, en los permisos del nivel de usuario
$r = $objDataBase->Update('usuarios_niveles', $valores, ["id" => $nivel_id]);
if($r['result']){
  $arr = ['resultado' => true, 'contenido' => 'Estructura del menu actualizada' ];
}else{
  $arr = ['resultado' => false, 'contenido' => $r['error']];
}

// Retornando datos de respuesta en formato json
die(json_encode($arr));
?>
