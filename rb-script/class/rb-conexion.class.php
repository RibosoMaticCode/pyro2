<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');

require_once(ABSPATH.'config.php');

if( G_BASEDATOS=="" || G_SERVIDOR=="" || G_USUARIO=="" ) {
	die("Debe especificar valores iniciales en archivo <code>config.php</code>");
}

class Conector{
	private $BaseDatos = G_BASEDATOS;
	private $Servidor = G_SERVIDOR;
	private $Usuario = G_USUARIO;
	private $Clave = G_CLAVE;

	function conectar() {
		$mysqli = new mysqli($this->Servidor, $this->Usuario, $this->Clave, $this->BaseDatos);

		if ($mysqli->connect_error) {
	    die('Error de Conexión (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
		}else{
			return $mysqli;
			//$mysqli -> mysqli_close();
		}
	}
}
?>
