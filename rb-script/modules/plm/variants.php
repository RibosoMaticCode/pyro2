<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
/* start */
header('Content-type: application/json; charset=utf-8');

/* demo de la estructura a combinar
$data1[]=array('azul', 'rojo', 'verde');
$data1[]=array('pequeño','mediano');
$data1[]=array('nuevo','usado');

echo "<pre>";
print_r($data1);
echo "</pre>"; */

// Obtenemos combos guardados en la base de datos
/*$variants_array = [];
if($_GET['product_id']>0){
  $product_id = $_GET['product_id'];
  $qv = $objDataBase->Ejecutar("SELECT * FROM plm_products_variants WHERE product_id =".$product_id);
  if($qv->num_rows > 0) {
    while($variant = $qv->fetch_assoc()){
      array_push($variants_array, $variant['name']);
    }
  }
}*/
// Ver arrays
$develop_view = false;

// Obtenemos combos previos, si hubiera
$variants_array = json_decode($_GET['array_prev'], true);
$previos = [];
foreach ($variants_array as $key) {
	array_push($previos, $key['name']);
}

//print_r($previos);
// Verificar si hay elementos repetidos
/**/

$combos_json = json_decode($_GET['array'], true);

// Obtenemos combos nuevos generados
$combos=possible_combos($combos_json);

/*foreach(array_count_values($combos) as $val => $c) // verificar repetidos a nivel de servidor
    if($c > 1) {
			$arr = [
				'result' => false,
				'message' => "Hay alternativas repetidas."
			];
			die( json_encode($arr, JSON_FORCE_OBJECT) );
		};*/

//calculate all the possible comobos creatable from a given choices array
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

$eliminar = [];
if($develop_view){
	echo "array guardado";
	print_r($previos);

	echo "array por guardar";
	print_r($combos);
}

if(count($previos)>0){
  foreach ($previos as $key=>$value) {
		//echo "existe |".$value."|?";
    if(in_array(trim($value), $combos, true)){

			$clave = array_search($value, $combos);
      unset($combos[$clave]);
      //echo " SI\n";
    }else{
			//echo " NO\n";
			array_push($eliminar, preg_replace('/[^a-zA-Z0-9]/', '', $previos[$key]));
			//echo $previos[$key];
		}
  }
	$combos = array_values($combos);
}

if($develop_view){
	echo "array nuevos";
	print_r($combos);

	echo "array eliminar";
	print_r($eliminar);
}
$arr = [
	'result' => true,
	'previos' => $previos,
	'nuevos' => $combos,
	'eliminar' =>  $eliminar
];

die(json_encode($arr, JSON_FORCE_OBJECT)); // Forzamos a retornar json en formato objeto para ser leido por javascript como tal,No como array
