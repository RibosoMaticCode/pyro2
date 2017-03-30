<?php
include_once("rb-conexion.class.php");

class Fotos{
	// Constructor
	var $con;
 	function Fotos(){
 		$this->con=new Conector;
 	}

	// Metodos basicos
 	function Insertar($campos){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("INSERT INTO photo (
	 		title, src, tn_src, album_id, type, tipo, usuario_id) VALUES (
			'".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",'".$campos[4]."','".$campos[5]."', ".$campos[6].")");
    		return $result;
   		}
	}

	function Editar($campos, $id){
   		if($this->con->conectar()==true) {
     		$result = @mysql_query("UPDATE photo SET title='".$campos[0]."', src='".$campos[1]."', tn_src='".$campos[2]."', album_id=".$campos[3].", url='".$campos[4]."', tipo='".$campos[5]."' WHERE id=$id");
     		return $result;
   		}
 	}


	function Eliminar($id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("DELETE FROM photo WHERE id=$id");
     		return $result;
   		}
 	}

	function EliminarFromAlbum($id,$album_id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("DELETE FROM photo WHERE id=$id AND album_id=$album_id");
     		return $result;
   		}
 	}

	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}

    // metodos adicionales
    function EditarPorCampo($campo,$valor,$id){ // string
        if($this->con->conectar()==true){
            return mysql_query("UPDATE photo SET $campo='$valor' WHERE id=$id");

        }
    }
}
$objFoto = new Fotos;
?>
