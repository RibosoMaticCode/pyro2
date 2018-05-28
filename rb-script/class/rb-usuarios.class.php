<?php
include_once("rb-conexion.class.php");

class Usuarios{
 //constructor
	var $con;
 	function Usuarios(){
 		$this->con=new Conector;
	}

	function Editar($campos,$id){
		$conexion = $this->con->conectar();
		$result = $conexion->query("UPDATE usuarios SET nombres='".$campos[0]."', apellidos='".$campos[1]."', ciudad='".$campos[2]."', pais='".$campos[3]."', `telefono-movil`='".$campos[4]."', `telefono-fijo`='".$campos[5]."', correo='".$campos[6]."', direccion ='".$campos[7]."', tipo=".$campos[8].", sexo ='".$campos[9]."', photo_id = ".$campos[10]." WHERE id=$id");
		return $result;
	}

	function destinatarios_del_mensaje($mensaje_id){
		$conexion = $this->con->conectar();
		//if($this->con->conectar()==true){
		$result = $conexion->query("SELECT u.nombres, u.nickname FROM usuarios u, mensajes_usuarios mu WHERE mu.usuario_id = u.id AND mu.mensaje_id=$mensaje_id");
		return $result;
   		//}
	}

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
		/* Actualizacion - anti injection sql
		+ Doc: http://php.net/manual/es/mysqli.quickstart.prepared-statements.php
		+ https://ricardogeek.com/como-evitar-ataques-sql-injection-usando-php/
		*/
		$conexion = $this->con->conectar();
    /*$result = $conexion->query("SELECT nickname FROM usuarios WHERE `$campo`='$valor'");
	 	return $result->num_rows;*/

		/* Sentencia preparada, etapa 1: preparación */
		if (!($sentencia = $conexion->prepare( 'SELECT nickname FROM usuarios WHERE `'.$campo.'` = ?' ))) {
		    echo "Falló la preparación: (" . $conexion->errno . ") " . $conexion->error;
		}
		/* Sentencia preparada, etapa 2: vincular y ejecutar */
		if (!$sentencia->bind_param("s", $valor)) {
			echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $sentencia->error;
		}

		if (!$sentencia->execute()) {
		    echo "Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;
		}
		$result = $sentencia->get_result();
		//Verificaciones
		//print_r ($sentencia);

		$num_results = $sentencia->affected_rows;
		$sentencia->close();
		return $num_results;
 	}

	function verificar_activacion($nickname){
		$conexion = $this->con->conectar();
	 	//Verificar si esta activo antes de la fecha final de activacion, son 48 horas desde que se registro
			$result = $conexion->query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE nickname = '$nickname'");
		  if($result->num_rows>0):
		   	$r = $result->fetch_assoc();
			 	if($r['activo']==0 && $r['diferencia']==1){
					return 2; // Inactivo y a tiempo de activar la cuenta
				}elseif($r['activo']==0 && $r['diferencia']==0){
					return 1; // Inactivo, pero con tiempo vencido para activar cuenta
				}else{
					return 0;
				}
			endif;

			$result = $conexion->query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE correo = '$nickname'");
		  if($result->num_rows>0):
			 	$r = $result->fetch_assoc();
				if($r['activo']==0 && $r['diferencia']==1){
					return 2;
				}elseif($r['activo']==0 && $r['diferencia']==0){
					return 1;
				}else{
					return 0;
				}
			endif;

			$result = $conexion->query("SELECT activo, (NOW() > fecha_activar) AS diferencia FROM usuarios WHERE `telefono-movil` = '$nickname'");
		  if($result->num_rows>0):
				$r = $result->fetch_assoc();
				if($r['activo']==0 && $r['diferencia']==1){
					return 2;
				}elseif($r['activo']==0 && $r['diferencia']==0){
					return 1;
				}else{
					return 0;
				}
			endif;
	}

	function validar_acceso($nickname,$password){ // verifica datos de acceso
		$conexion = $this->con->conectar();
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
 	}
}

$objUsuario = new Usuarios;
?>
