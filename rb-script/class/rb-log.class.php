<?php 
include_once("rb-conexion.class.php");

class Logs{
	//constructor	
 	var $con;
 	function Logs(){
 		$this->con=new Conector;
 	}
	
	// metodos basicos
	function Insertar($campos){
		if($this->con->conectar()){
			return mysql_query("INSERT INTO log (usuario_id, usuario, observacion, fecha) VALUES ( ".$campos[0].",'".$campos[1]."','".$campos[2]."', NOW() )");
		}
	}
	
	/*function Editar($campos, $id){
		if($this->con->conectar($campos, $id)){
			return mysql_query("UPDATE logs SET nombre='".$campos[0]."', descripcion='".$campos[1]."', src='".$campos[2]."', coordenadas='".$campos[3]."' WHERE id=".$id);
		}
	}*/
	
	function Eliminar($id){
		if($this->con->conectar()){
			return mysql_query("DELETE FROM logs WHERE id=$id");
		}
	}
	
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	// metodos adicionales
}
$objLog = new Logs;
?>
