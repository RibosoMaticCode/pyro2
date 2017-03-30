<?php
include_once("rb-conexion.class.php");

class Usuarios{
 //constructor
	var $con;
 	function Usuarios(){
 		$this->con=new Conector;
	}

	function Insertar($campos){
	   if($this->con->conectar()==true){
		 $result = @mysql_query("INSERT INTO usuarios (nickname, password, nombres, apellidos, ciudad, pais, `telefono-movil`, `telefono-fijo`, correo, direccion, tipo, fecharegistro, fecha_activar, ultimoacceso, sexo,photo_id) VALUES ('".$campos[0]."', '".md5($campos[1])."', '".$campos[2]."', '".$campos[3]."', '".$campos[4]."', '".$campos[5]."', '".$campos[6]."', '".$campos[7]."', '".$campos[8]."', '".$campos[9]."', ".$campos[10].", NOW(), ADDDATE(NOW(), INTERVAL 2 DAY), NOW(), '".$campos[11]."', ".$campos[12].")");
		 return $result;
	   }
	}

	function Editar($campos,$id){
	   if($this->con->conectar()==true){
		 $result = @mysql_query("UPDATE usuarios SET nombres='".$campos[0]."', apellidos='".$campos[1]."', ciudad='".$campos[2]."', pais='".$campos[3]."', `telefono-movil`='".$campos[4]."', `telefono-fijo`='".$campos[5]."', correo='".$campos[6]."', direccion ='".$campos[7]."', tipo=".$campos[8].", sexo ='".$campos[9]."', photo_id = ".$campos[10]." WHERE id=$id");
		 return $result;

	   }
	}

	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}

	function Eliminar($id){
   		if($this->con->conectar()==true){
     		$result = @mysql_query("DELETE FROM usuarios WHERE id=$id");
     		return $result;
   		}
	}
	// metodos adicionales
	function EditarPorCampo($campo,$valor,$id){ // string
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE usuarios SET `$campo`='$valor' WHERE id=$id");
		}
	}

	function EditarPorCampo_Int($campo,$valor,$id){ // int
		if($this->con->conectar()==true){
     		return mysql_query("UPDATE usuarios SET $campo=$valor WHERE id=$id");
		}
	}

	function destinatarios_del_mensaje($mensaje_id){
		if($this->con->conectar()==true){
			return mysql_query("SELECT u.nombres, u.nickname FROM usuarios u, mensajes_usuarios mu WHERE mu.usuario_id = u.id AND mu.mensaje_id=$mensaje_id");
   		}
	}
	// otro metodos no revisados
 function listado_ultimos($limite){
   if($this->con->conectar()==true){
     $result = @mysql_query("SELECT * FROM usuarios ORDER BY fecharegistro DESC LIMIT $limite");
	 return $result;
   }
 }



 function actualizar($campos,$id){
   if($this->con->conectar()==true) {
   		if(empty($campos[1]) || $campos[1]=="") $exp= "";
		else $exp = ", password='".$campos[1]."'";
     $result = @mysql_query("UPDATE usuarios SET nickname='".$campos[0]."', nombres='".$campos[2]."', correo='".$campos[3]."', tipo='".$campos[4]."' ".$exp." WHERE id=$id");
     return $result;
   }
 }


 function mostrar($nickname, $password){ // muestra datos del usuario segun su nick y contra
   if($this->con->conectar()==true){
		 $consult = mysql_query("SELECT u.*, un.nombre, un.nivel_enlace, un.id as nivel_id FROM usuarios u, usuarios_niveles un WHERE u.tipo = un.id AND nickname='$nickname' AND password='$password'");
	 		if(mysql_num_rows($consult)>0):
	 			$result = mysql_fetch_array($consult);
	 		endif;

		 $consult = mysql_query("SELECT u.*, un.nombre, un.nivel_enlace, un.id as nivel_id FROM usuarios u, usuarios_niveles un WHERE u.tipo = un.id AND correo='$nickname' AND password='$password'");
		 if(mysql_num_rows($consult)>0):
		 	$result = mysql_fetch_array($consult);
		 endif;

		 $consult = mysql_query("SELECT u.*, un.nombre, un.nivel_enlace, un.id as nivel_id FROM usuarios u, usuarios_niveles un WHERE u.tipo = un.id AND `telefono-movil`='$nickname' AND password='$password'");
		 if(mysql_num_rows($consult)>0):
		 	$result = mysql_fetch_array($consult);
		 endif;

	     //$result = mysql_fetch_array($consult);
		 $usuario = array();
		 $usuario['id'] = $result['id'];
		 $usuario['nombres'] = $result['nombres'];
		 $usuario['ultimoacceso'] = $result['ultimoacceso'];
		 $usuario['correo'] = $result['correo'];
		 $usuario['tipo'] =  $result['nivel_enlace'];//$result['tipo'];
		 $usuario['nivel_id'] =  $result['nivel_id'];
		 $usuario['activo'] = $result['activo'];
		 return $usuario;
   }
 }
	//validaciones
 	function existe($campo, $valor){ // verifica existencia de nick de usuario
   		if($this->con->conectar()==true){
     		$consult = mysql_query("SELECT nickname FROM usuarios WHERE `$campo`='$valor'");
	 		return mysql_num_rows($consult);
   		}
 	}

	function verificar_activacion($nickname){
	 	//Verificar si esta activo antes de la fecha final de activacion, son 48 horas desde que se registro
	   	if($this->con->conectar()==true){
			$consult = mysql_query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE nickname = '$nickname'");
		    if(mysql_num_rows($consult)>0):
		    	$r = mysql_fetch_array($consult);
			 	if($r['activo']==0 && $r['diferencia']==1) return 0;
				else return 1;
			endif;

			$consult = mysql_query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE correo = '$nickname'");
		    if(mysql_num_rows($consult)>0):
			 	$r = mysql_fetch_array($consult);
				if($r['activo']==0 && $r['diferencia']==1) return 0;
				else return 1;
			endif;

			$consult = mysql_query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE `telefono-movil` = '$nickname'");
		    if(mysql_num_rows($consult)>0):
				$r = mysql_fetch_array($consult);
				if($r['activo']==0 && $r['diferencia']==1) return 0;
				else return 1;
			endif;
		}
	}

	function validar_acceso($nickname,$password){ // verifica datos de acceso
   		if($this->con->conectar()==true){
   	 		$acceso = 0;
     		$consult = mysql_query("SELECT nickname, password FROM usuarios WHERE nickname='$nickname' AND password='$password'");
	 		if(mysql_num_rows($consult)>0):
	 			return mysql_num_rows($consult);
	 		endif;

	 		$consult = mysql_query("SELECT nickname, password FROM usuarios WHERE correo='$nickname' AND password='$password'");
	 		if(mysql_num_rows($consult)>0):
	 			return mysql_num_rows($consult);
	 		endif;

			$consult = mysql_query("SELECT nickname, password FROM usuarios WHERE `telefono-movil`='$nickname' AND password='$password'");
	 		if(mysql_num_rows($consult)>0):
	 			return mysql_num_rows($consult);
	 		endif;
     		return $acceso;
   		}
 	}
}

$objUsuario = new Usuarios;
?>
