<?php

$sapiens_vals = [
	'universidad' => $_POST['sapiens_universidad'],
	'tipo_libro' => $_POST['sapiens_tipo_libro'],
	'area' => $_POST['sapiens_area']
];

if($id==0){
	$sapiens_vals['product_id'] = $product_id;
	$r = $objDataBase->Insert('sapiens_fields_adds', $sapiens_vals);
}else{
	$r = $objDataBase->Update('sapiens_fields_adds', $sapiens_vals, ["product_id" => $id]);
}

