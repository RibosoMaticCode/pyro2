<?php
include_once("rb-conexion.class.php");

class Galerias{
	// Constructor
	var $con;
 	function Galerias(){
 		$this->con=new Conector;
 	}

	// Metodos basicos
 	function Insertar($campos){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("INSERT INTO albums (
	 		nombre, descripcion, imagenes, fecha, nombre_enlace, galeria_grupo, usuario_id, photo_id) VALUES (
			'".$campos[0]."','".$campos[1]."',0,NOW(),'".$campos[2]."','".$campos[3]."', ".$campos[4].", ".$campos[5].")");
    		 return $result;
   		}
	}

	function Editar($campos, $id){
   		if($this->con->conectar()==true) {
     		$result = @mysql_query("UPDATE albums SET nombre='".$campos[0]."', descripcion='".$campos[1]."', nombre_enlace = '".$campos[2]."', galeria_grupo= '".$campos[3]."', photo_id = $campos[4] WHERE id=$id");
     		return $result;
   		}
 	}

	function Eliminar($id){
   		if($this->con->conectar()==true){
   			// quitamos referencia del album en las fotos
   			$q = mysql_query("SELECT * FROM photo WHERE album_id=$id");
			while($r = mysql_fetch_array($q)):
				mysql_query("UPDATE photo SET album_id='0' WHERE id=".$r['id']);
			endwhile;

			// luego eliminamos
     		$result = @mysql_query("DELETE FROM albums WHERE id=$id");
     		return $result;
   		}
 	}

	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}

	// Metodos Avanzados
}

$objGaleria = new Galerias;
?>
