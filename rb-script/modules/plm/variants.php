<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
// Devolver formato JSON
header('Content-type: application/json; charset=utf-8');

//calculate all the possible comobos creatable from a given choices array
/* demo de la estructura a combinar
$data1[]=array('azul', 'rojo', 'verde');
$data1[]=array('pequeño','mediano');
$data1[]=array('nuevo','usado');
*/
function possible_combos($groups, $prefix='') {
    $result = array();
    $group = array_shift($groups); // array_shift : Quita un elemento del principio del array y es asignada a la variable,
    // dejando el array sin dicho elemento.
    // en este caso el primer elemento es un array (azul, rojo, verde) asignado a group
    // y deja a groups, sin el primer array
    foreach($group as $selected) { // cada elemento del  array $group es asignado a la variable $selected, empezara por azul
        if($groups) {
            $result = array_merge($result, possible_combos($groups, $prefix . $selected. ' | '));
            // array_merge: combina dos o mas arrays
        } else {
            $result[] = $prefix . $selected;
        }
    }
    return $result;
}

// Ver arrays -> para prueba de desarrollo
$develop_view = false;

// Obtenemos combinaciones previos, si hubiera
$variants_array = json_decode($_GET['array_prev'], true);
$previos = [];
foreach ($variants_array as $key) {
	array_push($previos, $key['name']); // Pasamos aun array unidimensional
}

// Generamos nuevas combinaciones, las pasamos a un array
$combos_json = json_decode($_GET['array'], true);

// Obtenemos combos nuevos generados
$combos=possible_combos($combos_json);

// Array con elementos a eliminar
$eliminar = [];
if($develop_view){
	echo "array guardado";
	print_r($previos);

	echo "array por guardar";
	print_r($combos);
}

// Verificamos si hay elementos en array de combinaciones previas
if(count($previos)>0){
	// Recorremos cada elemento
  foreach ($previos as $key=>$value) {
		// Verificacmos si valor existen en el array de combos nuevas
    if(in_array(trim($value), $combos, true)){
			// Si existe los eliminamos del combo nuevo
			$clave = array_search($value, $combos);
      unset($combos[$clave]);
    }else{
			// Si no existe, entonces tendremos que retirarlo
			// Los pasamos al array $eliminar
			array_push($eliminar, preg_replace('/[^a-zA-Z0-9]/', '', $previos[$key]));
		}
  }
	// Reiniciamos el array combos nuevos (con la eliminacion de algunos elementos se pierde numeracion de indices)
	$combos = array_values($combos);
}

if($develop_view){
	echo "array nuevos";
	print_r($combos);

	echo "array eliminar";
	print_r($eliminar);
}

// Finalmente arrojamos todos los array obtenidos
$arr = [
	'result' => true,
	'previos' => $previos, // Los que se enviaron previamente
	'nuevos' => $combos, // Las nuevos elementos
	'eliminar' =>  $eliminar // Los que sera retirados, por que ya no existen en los elementos enviados previamente
];

die(json_encode($arr, JSON_FORCE_OBJECT)); // Forzamos a retornar json en formato objeto para ser leido por javascript como tal,No como array
