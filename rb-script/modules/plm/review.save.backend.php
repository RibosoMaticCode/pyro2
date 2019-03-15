<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['comment_id'];
$valores = [
  'title' => $_POST['review_title'],
  'comment' => $_POST['review_comment']
];


$r = $objDataBase->Update('plm_comments', $valores, ["id" => $id]);
if($r['result']){
	$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado', 'id' => $id ];
}else{
	$arr = ['resultado' => false, 'contenido' => $r['error']];
}

die(json_encode($arr));
?>
