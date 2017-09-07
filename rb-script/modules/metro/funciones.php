<?php
// msotrar info de almacen
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
$objDataBase = new DataBase;

function metro_show_store($store_id){
  global $objDataBase;
  $c = $objDataBase->Consultar("SELECT * FROM metro_almacen WHERE id=$store_id");
  $Array = array();
	while($Data = mysql_fetch_array($c)):
    $Array['nombre_almacen'] = $Data['nombre_almacen'];
	endwhile;
	return $Array;
}
function metro_show_publication($publication_id){
  global $objDataBase;
  $c = $objDataBase->Consultar("SELECT * FROM metro_publicacion WHERE id=$publication_id");
  $Array = array();
	while($Data = mysql_fetch_array($c)):
    $Array['titulo'] = $Data['titulo'];
	endwhile;
	return $Array;
}
?>
