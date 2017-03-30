<?php
include 'islogged.php';
require_once("../rb-script/class/rb-fotos.class.php");

$jsonOrder = $_GET['jsonOrder'];
$arrayOrder = json_decode($jsonOrder, true);

foreach ($arrayOrder as $item => $value):
	$file_id = $value['id'];
	$file_order = $value['order'];
    if( !$objFoto->Consultar ("UPDATE photo SET orden = $file_order WHERE id = $file_id") ) die("0");
endforeach;
return "1";
?>
