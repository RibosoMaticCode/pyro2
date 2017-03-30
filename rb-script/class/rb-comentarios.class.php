<?php 
include_once("rb-conexion.class.php");

class Comentarios{
	//constructor	
 	var $con;
 	function Comentarios(){
 		$this->con=new Conector;
 	}
	
	// metodos basicos
	function Insertar($campos){
		if($this->con->conectar()){
			return mysql_query("INSERT INTO comentarios (articulo_id, nombre, contenido, mail, web, spam, ip, source, url_referencia, fecha) VALUES ($campos[0],'$campos[1]','$campos[2]','$campos[3]','$campos[4]', $campos[5],'$campos[6]','$campos[7]','$campos[8]',NOW())");
		}
	}
	
	function Editar($campos, $id){
		if($this->con->conectar()){
			return mysql_query("UPDATE comentarios SET nombre='".$campos[0]."', contenido='".$campos[1]."', mail='".$campos[2]."', web='".$campos[3]."' WHERE id=$id");
		}
	}
	
	function Eliminar($id){
		if($this->con->conectar()){
			return mysql_query("DELETE FROM comentarios WHERE id=$id");
		}
	}
	
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	// metodos adicionales
	function EditarPorCampo($campo,$valor,$id){
    	if($this->con->conectar()==true){
     		return mysql_query("UPDATE comentarios SET $campo=$valor WHERE id=$id");
		}
	}
}
$objComentario = new Comentarios;
?>
