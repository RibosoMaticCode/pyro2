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
		switch ( $row['tipo'] ) {
			case 1:
				$tipo = "curso";
				break;
			case 2:
				$tipo = "sesion";
				break;
			case 3:
				$tipo = "categoria";
				break;
		}
		$arrow = "";
		$prev = "";
		if($row['padre_id']>0){
			$arrow = " > ";
			$prev = path_classification($row['padre_id']);
		}
		$link = '<a href="'.G_SERVER.$tipo.'/'.$row['id'].'">'.$row['titulo'].'</a>';
		return $prev.$arrow.$link;
	}
}