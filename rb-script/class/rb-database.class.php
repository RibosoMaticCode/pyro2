<?php 
include_once("rb-conexion.class.php");

class DataBase{
	var $con;
 	function DataBase(){
 		$this->con=new Conector;
	}
	
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	function EditarPorCampo($tabla,$campo,$valor,$id){ // string
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE `$tabla` SET `$campo`='$valor' WHERE id=$id");
		}
	}
	
	function EditarPorCampo_Int($tabla,$campo,$valor,$id){ // int
		if($this->con->conectar()==true){
     		return mysql_query("UPDATE `$tabla` SET `$campo`=$valor WHERE id=$id");
		}
	}
}
$objDataBase = new DataBase;
?>