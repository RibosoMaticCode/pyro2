<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$option = $_GET['option'];
$product_id = $_GET['product_id'];

// Buscamos la opcion en la base de datos
// Que combos se formaron con esa opcion
// Ej. Si buscamos Rojo, saber sus combinacion Rojo | Peque, Rojo | Mediano
$q = "SELECT * FROM plm_products_variants WHERE product_id = $product_id AND name LIKE '%".$option."%'";
$qo = $objDataBase->Ejecutar($q);

$options_hidden = [];
// Recorremos los resultado de combos
while($row = $qo->fetch_assoc()){
  // Si el combo no es visible
  if($row['visible']==0){
    // Todas las opciones de la combinacion, las separamos
    // Ej. Rojo | Peque | Nuevo, los separamos en un array
    $array = array_map('trim', explode( "|", $row['name'] ) );

    // Retirar la opcion que se buscó, y dejar el resto
    // Como buscamos Rojo, la retiramos del combo
    $key = array_search($option, $array);
    unset($array[$key]);

    // Del los elementos que quedaron, los pasamos a un nuevo array sin que se repitan
    foreach ($array as $key=>$value) {
      if (!in_array($value, $options_hidden)) { // Evitar qye se repita algun elemento.
        array_push($options_hidden, $value);
      }
    }
  }
}

// El resultado sera un array con los elementos que se han ocultado en las combinaciones.
//print_r($options_hidden);

$arr = [
  'num_hidden' => count($options_hidden),
  'elements_hidden' => $options_hidden
];

die(json_encode($arr, JSON_FORCE_OBJECT)); // Forzamos a retornar json en formato objeto para ser leido por javascript como tal,No como array
?>
