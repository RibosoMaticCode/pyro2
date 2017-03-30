<?php 
include_once("rb-conexion.class.php");

class Opciones{
 	var $con;
 	function Opciones(){
 		$this->con=new Conector;
 	}
 
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	function insert_valor($blog_id, $opcion, $valor){
		if($this->con->conectar()==true){
			mysql_query("INSERT INTO opciones (blog_id, opcion, valor) VALUES ($blog_id, '$opcion','$valor')");
		}
	}
	
 	function obtener_valor($blog_id, $opcion){ 
   		if($this->con->conectar()==true){
     		$q = @mysql_query("SELECT valor FROM opciones WHERE blog_id=$blog_id AND opcion='$opcion'");
	 		if(!$q){
	 			die('No hay estructura de datos ó datos');
	 		}
	 		$opc = mysql_fetch_array($q);
			return $opc['valor'];
   		}
 	}
 
 	function modificar_valor($blog_id, $opcion, $nuevo_valor){
   		if($this->con->conectar()==true){
     		$q = mysql_query("UPDATE opciones SET valor='$nuevo_valor' WHERE blog_id=$blog_id AND opcion='$opcion'");
	 		return $q;
   		}
 	}
}

$objOpcion =new Opciones;
?>
