<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_GET['id'];
function EliminarNodos($padre_id){
	global $objDataBase;
	$r = $objDataBase->Ejecutar("SELECT a.id, subcat.Count FROM aula_contenidos a LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM aula_contenidos GROUP BY padre_id) subcat ON a.id = subcat.padre_id WHERE a.padre_id=" . $padre_id);
 	while ($row = $r->fetch_assoc()) {
 		if ($row['Count'] > 0) {
			EliminarNodos($row['id']);
 			$objDataBase->Ejecutar("DELETE FROM aula_contenidos WHERE id=".$row['id']);
 		}elseif ($row['Count']==0) {
 			$objDataBase->Ejecutar("DELETE FROM aula_contenidos WHERE id=".$row['id']);
 		}
	}
}
$r = $objDataBase->Ejecutar("DELETE FROM aula_contenidos WHERE id = $id");
EliminarNodos($id);

if(G_ACCESOUSUARIO){
	$r = $objDataBase->Ejecutar('DELETE FROM aula_contenidos WHERE id='.$id);
	if($r){
		$arr = ['resultado' => true, 'contenido' => 'Contenido eliminado' ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{
	$arr = ['resultado' => false, 'contenido' => 'No ha iniciado sesion'];
}
die(json_encode($arr));
?>
