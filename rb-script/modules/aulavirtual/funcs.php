<?php
function path_classification($id){
	global $objDataBase;
	if($id==0){
		return "/";
	}else{
		// Ubicamos el parent_id
		$q = "SELECT * FROM aula_contenidos WHERE id=$id";
		$r = $objDataBase->Ejecutar( $q );
		$row = $r->fetch_assoc();
		$arrow = "";
		$prev = "";
		if($row['padre_id']>0){
			$arrow = " > ";
			$prev = path_classification($row['padre_id']);
		}
		return $prev.$arrow.$row['titulo'];
	}
}