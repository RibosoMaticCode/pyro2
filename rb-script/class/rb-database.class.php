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
			$resultArray = array('result' => false, 'insert_id' => $conexion->insert_id, 'error' => $conexion->connect_errno.$conexion->error );
		}
		return $resultArray;
	}

	function Ejecutar($q){
		$conexion = $this->Conexion();
		return $conexion->query($q);
	}

	function Editar($q){ // Solo para sentecnias UPDATE, devuelve si algunas filas fueron afectadas o no por la actualizacion
		$conexion = $this->Conexion();
		if($conexion->query($q)){
			$resultArray = array('result' => true, 'affected_rows' => $conexion->affected_rows );
		}else{
			$resultArray = array('result' => false, 'affected_rows' => $conexion->affected_rows, 'error' => $conexion->connect_errno.$conexion->error );
		}
		return $resultArray;
	}

	function EditarPorCampo($tabla,$campo,$valor,$id){ // string
    $conexion = $this->Conexion();
		return $conexion->query("UPDATE `$tabla` SET `$campo`='$valor' WHERE id=$id");
	}

	function EditarPorCampo_Int($tabla,$campo,$valor,$id){ // int
		$conexion = $this->Conexion();
		return $conexion->query("UPDATE `$tabla` SET `$campo`=$valor WHERE id=$id");
	}

	function Insert($table, $data){ // con array - key - value
		$conexion = $this->Conexion();
		// Columnas
		$columns = "(";
		$coma = "";
		foreach ($data as $key => $value) {
			$columns .= $coma.$key;
			$coma = ",";
		}
		$columns .= ")";
		//valores
		$values = "(";
		$coma = "";
		foreach ($data as $key => $value) {
			$values .= $coma."'".$value."'";
			$coma = " ,";
		}
		$values .= ")";
		$sentence = "INSERT INTO $table $columns VALUES $values";
		//echo $sentence;
		if($conexion->query($sentence)){
			$resultArray = array('result' => true, 'insert_id' => $conexion->insert_id );
		}else{
			$resultArray = array('result' => false, 'error' => $conexion->connect_errno.":".$conexion->error );
		}
		return $resultArray;
	}

	function Update($table, $data, $condition){ // con array - key - value
		$conexion = $this->Conexion();
		// Cols to edit
		$coma = "";
		$cols_and_vals = "";
		foreach ($data as $key => $value) {
			$cols_and_vals .= $coma.$key." = '".$value."'";
			$coma = ", ";
		}
		// Where condition
		$and = "";
		$condition_cols_vals = "";
		foreach ($condition as $key => $value) {
			$condition_cols_vals .= $and.$key." = '".$value."'";
			$and = " AND ";
		}

		$sentence = "UPDATE $table SET $cols_and_vals WHERE $condition_cols_vals";
		//echo $sentence;
		if($conexion->query($sentence)){
			$resultArray = array('result' => true, 'affected_rows' => $conexion->affected_rows );
		}else{
			$resultArray = array('result' => false, 'error' => $conexion->connect_errno.":".$conexion->error );
		}
		return $resultArray;
	}

	function Search($data_to_search, $table, $columns){
		// Busqueda avanzada
		$conexion = $this->Conexion();
		$cols_vals = "";
		$coma = "";
		foreach ($columns as $key) {
			$cols_vals .= $coma.$key;
			$coma = ", ";
		}
		// campo score para ver prioridad de resultado: "SELECT *, MATCH ( $cols_vals ) AGAINST ( '$data_to_search' ) AS score FROM $table WHERE MATCH ( $cols_vals ) AGAINST ( '$data_to_search' ) ORDER BY score DESC";
		return $conexion->query("SELECT * FROM $table WHERE MATCH ( $cols_vals ) AGAINST ( '$data_to_search' WITH QUERY EXPANSION)");
	}
}
$objDataBase = new DataBase;
?>
