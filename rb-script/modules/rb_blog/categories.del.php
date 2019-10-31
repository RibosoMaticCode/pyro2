<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$value_id = $_GET['id'];
function EliminarNodos($categoria_id){
	global $objDataBase;
	$r = $objDataBase->Ejecutar("SELECT a.id, a.nombre, subcat.Count FROM blog_categories a  LEFT OUTER JOIN (SELECT categoria_id, COUNT(*) AS Count FROM blog_categories GROUP BY categoria_id) subcat ON a.id = subcat.categoria_id WHERE a.categoria_id=" . $categoria_id);
 	while ($row = $r->fetch_assoc()) {
 		if ($row['Count'] > 0) {
			EliminarNodos($row['id']);
 			$objDataBase->Ejecutar("DELETE FROM blog_categories WHERE id=".$row['id']);
 		}elseif ($row['Count']==0) {
 			$objDataBase->Ejecutar("DELETE FROM blog_categories WHERE id=".$row['id']);
 		}
	}
}
$r = $objDataBase->Ejecutar("DELETE FROM blog_categories WHERE id = $value_id");
EliminarNodos($value_id);

header('Content-type: application/json; charset=utf-8');
if($r){
  $arr = array('result' => 1, 'url' => G_SERVER );
  die(json_encode($arr));
}else{
  $arr = array('result' => 0, 'url' => G_SERVER );
  die(json_encode($arr));
}
?>
