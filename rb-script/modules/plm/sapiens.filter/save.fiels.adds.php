<?php
die('test');
$sapiens_vals = [
	'universidad' => $_POST['sapiens_universidad'],
	'tipo_libro' => $_POST['sapiens_tipo_libro'],
	'area' => $_POST['sapiens_area']
];

if($id==0){
	$sapiens_vals['product_id'] = $product_id;
	$r = $objDataBase->Insert('sapiens_fields_adds', $sapiens_vals);
}elseif($id > 0){
	$qr = $objDataBase->Ejecutar("SELECT * FROM sapiens_fields_adds WHERE product_id=".$id);
	if($qr->num_rows == 0){
		$sapiens_vals['product_id'] = $id;
		$r = $objDataBase->Insert('sapiens_fields_adds', $sapiens_vals);
	}else{
		$r = $objDataBase->Update('sapiens_fields_adds', $sapiens_vals, ["product_id" => $id]);
	}
}

