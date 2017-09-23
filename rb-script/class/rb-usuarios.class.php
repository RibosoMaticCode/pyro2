<?php
include_once("rb-conexion.class.php");

class Usuarios{
 //constructor
	var $con;
 	function Usuarios(){
 		$this->con=new Conector;
	}

	function Insertar($campos){
	   //if($this->con->conectar()==true){
		$conexion = $this->con->conectar();
		$result = $conexion->query("INSERT INTO usuarios (nickname, password, nombres, apellidos, ciudad, pais, `telefono-movil`, `telefono-fijo`, correo, direccion, tipo, fecharegistro, fecha_activar, ultimoacceso, sexo,photo_id) VALUES ('".$campos[0]."', '".md5($campos[1])."', '".$campos[2]."', '".$campos[3]."', '".$campos[4]."', '".$campos[5]."', '".$campos[6]."', '".$campos[7]."', '".$campos[8]."', '".$campos[9]."', ".$campos[10].", NOW(), ADDDATE(NOW(), INTERVAL 2 DAY), NOW(), '".$campos[11]."', ".$campos[12].")");
		return $result;
	   //}
	}

	function Editar($campos,$id){
		$conexion = $this->con->conectar();
	  //if($this->con->conectar()==true){
		$result = $conexion->query("UPDATE usuarios SET nombres='".$campos[0]."', apellidos='".$campos[1]."', ciudad='".$campos[2]."', pais='".$campos[3]."', `telefono-movil`='".$campos[4]."', `telefono-fijo`='".$campos[5]."', correo='".$campos[6]."', direccion ='".$campos[7]."', tipo=".$campos[8].", sexo ='".$campos[9]."', photo_id = ".$campos[10]." WHERE id=$id");
		return $result;
	  //}
	}

	/*function Consultar($q){
		$conexion = $this->con->conectar();
		return $conexion->query($q);
	}

	function Eliminar($id){
   	//if($this->con->conectar()==true){
		$conexion = $this->con->conectar();
    $result = $conexion->query("DELETE FROM usuarios WHERE id=$id");
    return $result;
   	//}
	}*/
	// metodos adicionales
	/*function EditarPorCampo($campo,$valor,$id){ // string
		$conexion = $this->con->conectar();
    //if($this->con->conectar()==true){
		// incluir scapes a comillas simples
		$result = $conexion->query("UPDATE usuarios SET `$campo`='$valor' WHERE id=$id");
		//}
		return $result;
	}

	function EditarPorCampo_Int($campo,$valor,$id){ // int
		$conexion = $this->con->conectar();
		//if($this->con->conectar()==true){
    $result = $conexion->query("UPDATE usuarios SET $campo=$valor WHERE id=$id");
		//}
		return $result;
	}*/

	function destinatarios_del_mensaje($mensaje_id){
		$conexion = $this->con->conectar();
		//if($this->con->conectar()==true){
		$result = $conexion->query("SELECT u.nombres, u.nickname FROM usuarios u, mensajes_usuarios mu WHERE mu.usuario_id = u.id AND mu.mensaje_id=$mensaje_id");
		return $result;
   		//}
	}
	// otro metodos no revisados
 /*function listado_ultimos($limite){
   $conexion = $this->con->conectar();
	 $result = $conexion->query("SELECT * FROM usuarios ORDER BY fecharegistro DESC LIMIT $limite");
	 return $result;
   //}
 }*/

 /*function actualizar($campos,$id){
	$conexion = $this->con->conectar();
   //if($this->con->conectar()==true) {
  if(empty($campos[1]) || $campos[1]=="") $exp= "";
	else $exp = ", password='".$campos[1]."'";
  $result = $conexion->query("UPDATE usuarios SET nickname='".$campos[0]."', nombres='".$campos[2]."', correo='".$campos[3]."', tipo='".$campos[4]."' ".$exp." WHERE id=$id");
  return $result;
   //}
 }*/

 function mostrar($nickname, $password){ // muestra datos del usuario segun su nick y contra
	 $conexion = $this->con->conectar();
   //if($this->con->conectar()==true){
		 $result = $conexion->query("SELECT u.*, un.nombre, un.nivel_enlace, un.id as nivel_id FROM usuarios u, usuarios_niveles un WHERE u.tipo = un.id AND nickname='$nickname' AND password='$password'");
	 		if($result->num_rows>0):
				$rows = $result->fetch_assoc();
	 			//$result = mysql_fetch_array($consult);
	 		endif;

		 $result = $conexion->query("SELECT u.*, un.nombre, un.nivel_enlace, un.id as nivel_id FROM usuarios u, usuarios_niveles un WHERE u.tipo = un.id AND correo='$nickname' AND password='$password'");
		 if($result->num_rows>0):
		 	$rows = $result->fetch_assoc();
		 endif;

		 $result = $conexion->query("SELECT u.*, un.nombre, un.nivel_enlace, un.id as nivel_id FROM usuarios u, usuarios_niveles un WHERE u.tipo = un.id AND `telefono-movil`='$nickname' AND password='$password'");
		 if($result->num_rows>0):
		 	$rows = $result->fetch_assoc();
		 endif;

	     //$result = mysql_fetch_array($consult);
		 $usuario = array();
		 $usuario['id'] = $rows['id'];
		 $usuario['nombres'] = $rows['nombres'];
		 $usuario['ultimoacceso'] = $rows['ultimoacceso'];
		 $usuario['correo'] = $rows['correo'];
		 $usuario['tipo'] =  $rows['nivel_enlace'];//$result['tipo'];
		 $usuario['nivel_id'] =  $rows['nivel_id'];
		 $usuario['activo'] = $rows['activo'];
		 return $usuario;
   //}
 }
	//validaciones
 	function existe($campo, $valor){ // verifica existencia de nick de usuario
		$conexion = $this->con->conectar();
   		//if($this->con->conectar()==true){
    $result = $conexion->query("SELECT nickname FROM usuarios WHERE `$campo`='$valor'");
	 	return $result->num_rows;
   		//}
 	}

	function verificar_activacion($nickname){
		$conexion = $this->con->conectar();
	 	//Verificar si esta activo antes de la fecha final de activacion, son 48 horas desde que se registro
	   	//if($this->con->conectar()==true){
			$result = $conexion->query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE nickname = '$nickname'");
		    if($result->num_rows>0):
		    	$r = $result->fetch_assoc();
			 	if($r['activo']==0 && $r['diferencia']==1) return 0;
				else return 1;
			endif;

			$result = $conexion->query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE correo = '$nickname'");
		    if($result->num_rows>0):
			 	$r = $result->fetch_assoc();
				if($r['activo']==0 && $r['diferencia']==1) return 0;
				else return 1;
			endif;

			$result = $conexion->query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE `telefono-movil` = '$nickname'");
		    if($result->num_rows>0):
				$r = $result->fetch_assoc();
				if($r['activo']==0 && $r['diferencia']==1) return 0;
				else return 1;
			endif;
		//}
	}

	function validar_acceso($nickname,$password){ // verifica datos de acceso
		$conexion = $this->con->conectar();
   		//if($this->con->conectar()==true){
   	 		$acceso = 0;
     		$result = $conexion->query("SELECT nickname, password FROM usuarios WHERE nickname='$nickname' AND password='$password'");
	 		if($result->num_rows>0):
	 			return $result->num_rows;
	 		endif;

	 		$result = $conexion->query("SELECT nickname, password FROM usuarios WHERE correo='$nickname' AND password='$password'");
	 		if($result->num_rows>0):
	 			return $result->num_rows;
	 		endif;

			$result = $conexion->query("SELECT nickname, password FROM usuarios WHERE `telefono-movil`='$nickname' AND password='$password'");
	 		if($result->num_rows>0):
	 			return $result->num_rows;
	 		endif;
     		return $acceso;
   		//}
 	}
}

$objUsuario = new Usuarios;
?>
