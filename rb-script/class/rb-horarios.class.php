<?php 
include_once("rb-conexion.class.php");

class Horarios{
	//constructor	
 	var $con;
 	function Horarios(){
 		$this->con=new Conector;
 	}
	
	// metodos basicos
	function Insertar($campos){
		if($this->con->conectar()){
			return mysql_query("INSERT INTO horarios (punto_id, dia, horainicio, horafin, usuario_id, fecha_mod) VALUES ( ".$campos[0].",".$campos[1].",'".$campos[2]."','".$campos[3]."',".$campos[4].", NOW() )");
		}
	}
	
	function Eliminar($pto_id, $dia, $horini, $usu_id){
		if($this->con->conectar()){
			
			return mysql_query("DELETE FROM horarios WHERE punto_id=$pto_id AND dia=$dia AND horainicio='$horini' AND usuario_id=$usu_id");
		}
	}
	
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	// metodos adicionales
}
$objHorario = new Horarios;
?>
