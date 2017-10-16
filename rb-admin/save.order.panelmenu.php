<?php
// Recibimos items del menu principal con nuevo orden, y si esta oculto o no.
$obj = json_decode($_GET['mydata'], true);

require_once '../rb-script/funciones.php';
// Consultamos el menu principal en json desde la base de datos
$menu_main_json = rb_get_values_options('menu_panel');

// pasamos json a un array en php
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

//verificar:
print_r($menu_main_array);

//Guardando nueva estructura de menu
rb_set_values_options('menu_panel', json_encode($menu_main_array));
?>
