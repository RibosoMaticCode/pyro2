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
