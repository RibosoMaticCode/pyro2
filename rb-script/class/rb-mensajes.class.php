<?php 
include_once("rb-conexion.class.php");

class Mensajes{
	// Constructor
	var $con;
 	function Mensajes(){
 		$this->con=new Conector;
 	}

	// Metodos basicos
 	function Insertar($campos){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("INSERT INTO mensajes (remitente_id, asunto, contenido, fecha_envio) VALUES (".$campos[0].",'".$campos[1]."','".$campos[2]."', NOW() )");
			 //echo "INSERT INTO mensajes (remitente_id, asunto, contenido, fecha_envio) VALUES (".$campos[0].",'".$campos[1]."','".$campos[2]."', NOW() )";
    		 return $result;
   		}
	}

	function Editar($campos, $id){
   		/*if($this->con->conectar()==true) {
     		$result = @mysql_query("UPDATE mensajes SET web_nombre='".$campos[0]."', link='".$campos[1]."', link_img='".$campos[2]."', descripcion='".$campos[3]."', webmaster='".$campos[4]."', webmaster_mail='".$campos[5]."', activo='".$campos[6]."' WHERE id=$id");
     		return $result;
   		}*/
 	}	
	
	function Eliminar($id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("DELETE FROM mensajes WHERE id=$id");
     		return $result;
   		}
 	}

	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	// Metodos Avanzados
	function EditarPorCampo_int($campo,$valor,$id){ // int
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE mensajes SET $campo=$valor WHERE id=$id");
		}
	}

	function DesactivarRecibidos($mensaje_id, $usuario_id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("UPDATE mensajes_usuarios SET inactivo = 1 WHERE mensaje_id=$mensaje_id AND usuario_id=$usuario_id");
     		return $result;
   		}
	}
	
	function DesactivarEnviados($mensaje_id, $usuario_id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("UPDATE mensajes SET inactivo = 1 WHERE remitente_id=$usuario_id AND id=$mensaje_id");
     		return $result;
   		}
	}
			
	function Leido($mensaje_id, $usuario_id){
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE mensajes_usuarios SET leido=1, fecha_leido=NOW() WHERE mensaje_id = $mensaje_id AND usuario_id = $usuario_id");
		}
	}
}

$objMensaje = new Mensajes;
?>
