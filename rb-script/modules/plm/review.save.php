<?php
header('Content-type: application/json; charset=utf-8');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$id = $_POST['comment_id'];
if(isset($_POST['state'])){
  $state = $_POST['state'];
}else{
  $state = 0;
}
$valores = [
  'user_id' => G_USERID,
  'title' => strip_tags($_POST['review_title']),
  'comment' => strip_tags($_POST['review_comment']),
	'date_register' => date('Y-m-d G:i:s'),
  'product_id' => $_POST['product_review_id'],
  'score' => $_POST['review_score'],
  'state' => $state,
	'img_ids' => $_POST['img_ids']
];

if($id==0){ // Nuevo
	$r = $objDataBase->Insert('plm_comments', $valores);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento añadido', 'id' => $r['insert_id'] ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}else{ // Update
	$r = $objDataBase->Update('plm_comments', $valores, ["id" => $id]);
	if($r['result']){
		$arr = ['resultado' => true, 'contenido' => 'Elemento actualizado', 'id' => $id ];
	}else{
		$arr = ['resultado' => false, 'contenido' => $r['error']];
	}
}
die(json_encode($arr));
?>
