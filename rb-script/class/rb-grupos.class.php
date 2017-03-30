<?php 
include_once("rb-conexion.class.php");

class Grupos{
	// Constructor
	var $con;
 	function Grupos(){
 		$this->con=new Conector;
 	}

	// Metodos basicos
 	function Insertar($campos){
   		if($this->con->conectar()==true){
     		$result = @mysql_query(" INSERT INTO grupos (nombre) VALUES ('".$campos[0]."') ");
    		 return $result;
   		}
	}

	function Editar($campos, $id){
   		if($this->con->conectar()==true) {
     		$result = @mysql_query("UPDATE grupos SET nombre='".$campos[0]."' WHERE id=$id");
     		return $result;
   		}
 	}	
	
	function Eliminar($id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("DELETE FROM grupos WHERE id=$id");
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

$objGrupo = new Grupos;
?>
