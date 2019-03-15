<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

function plato($plato_id, $campo){
  global $objDataBase;
  $qp = $objDataBase->Ejecutar("SELECT * FROM rest_plato WHERE id=".$plato_id);
  $plato = $qp->fetch_assoc();
  return $plato[$campo];
}
function mesa($mesa_id, $campo){
  global $objDataBase;
  $qp = $objDataBase->Ejecutar("SELECT * FROM rest_mesa WHERE id=".$mesa_id);
  $mesa = $qp->fetch_assoc();
  return $mesa[$campo];
}
function get_rows($table, $value, $column_id = "id"){
	global $objDataBase;
  $r = $objDataBase->Ejecutar("SELECT * FROM $table WHERE $column_id=$value");
	if($r->num_rows == 0){
		return false;
	}
	$row = $r->fetch_assoc();
	return $row;
}
