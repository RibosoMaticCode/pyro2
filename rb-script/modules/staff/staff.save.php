<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$mode = $_POST['mode'];
$id = $_POST['id'];
$valores = [
  'name' => $_POST['name'],
  'position' => $_POST['position'],
	'email' => $_POST['email'],
  'area' => $_POST['area'],
  'city' => $_POST['city'],
	'telefono' => $_POST['telefono'],
  'photo_id' => $_POST['photo_id'],
	'description' => $_POST['description']
];

if($mode=="new"):
	$r = $objDataBase->Insert('staff', $valores);
	$id = $r['insert_id'];
	$m = "Inserción correcta";
elseif($mode=="upd"):
	$r = $objDataBase->Update('staff', $valores, ['id' => $id]);
	$id = $id;
	$m = "Actualización correcta";
endif;

if($r['result']):
  $results = ['result' => true, 'message' => $m, 'id' => $id];
  die( json_encode($results) );
else:
  $results = ['result' => false, 'message' => $r['error']];
  die( json_encode($results) );
endif;
?>
