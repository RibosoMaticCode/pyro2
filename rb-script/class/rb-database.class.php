<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');

require_once(ABSPATH.'config.php');

if( G_BASEDATOS=="" || G_SERVIDOR=="" || G_USUARIO=="" ) {
	die("Debe especificar valores iniciales en archivo <code>config.php</code>");
}

class DataBase{
	private $BaseDatos = G_BASEDATOS;
	private $Servidor = G_SERVIDOR;
	private $Usuario = G_USUARIO;
	private $Clave = G_CLAVE;

	function Conexion() {
		$mysqli = new mysqli($this->Servidor, $this->Usuario, $this->Clave, $this->BaseDatos);

		if ($mysqli->connect_error) {
	    die('Error de Conexión (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
		}else{
			return $mysqli;
			$mysqli -> mysqli_close();
		}
	}

	function Insertar($q){ // Solo para sentencias Insert SQL, retorna un Array con valores True/False dependiendo del resultado, y el ID registrado
		$conexion = $this->Conexion();
		if($conexion->query($q)){
			$resultArray = array('result' => true, 'insert_id' => $conexion->insert_id );
		}else{
			$resultArray = array('result' => false, 'insert_id' => $conexion->insert_id, 'error' => $conexion->connect_errno.$conexion->connect_error );
		}
		return $resultArray;
	}

	function Ejecutar($q){
		$conexion = $this->Conexion();
		return $conexion->query($q);
	}

	function EditarPorCampo($tabla,$campo,$valor,$id){ // string
    $conexion = $this->Conexion();
		return $conexion->query("UPDATE `$tabla` SET `$campo`='$valor' WHERE id=$id");
	}

	function EditarPorCampo_Int($tabla,$campo,$valor,$id){ // int
		$conexion = $this->Conexion();
		return $conexion->query("UPDATE `$tabla` SET `$campo`=$valor WHERE id=$id");
	}
}
$objDataBase = new DataBase;
?>
