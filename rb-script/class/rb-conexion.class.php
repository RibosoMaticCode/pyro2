<?php
// devuelve 3 niveles hacia arriba
// rm_conexion.class.php ubicada en dev.clasmoche/script/class/
// y config.php ubicaca en dev.clasmoche asi que son 3 niveles hacia arriba

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');

require_once(ABSPATH.'config.php');

if( G_BASEDATOS=="" || G_SERVIDOR=="" || G_USUARIO=="" ) {
	die("Debe especificar valores iniciales en archivo <code>config.php</code>");
}

class Conector{
	var $conect;
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;

	function Conector(){
		$this->BaseDatos = G_BASEDATOS;
		$this->Servidor = G_SERVIDOR;
		$this->Usuario = G_USUARIO;
		$this->Clave = G_CLAVE;
	}

	function conectar() {
		/*if(!($con=mysql_connect($this->Servidor,$this->Usuario,$this->Clave))){
			echo "Error al conectar a la base de datos";
			exit();
		}*/

		$con = mysql_connect($this->Servidor,$this->Usuario,$this->Clave) or die('[!] No se pudo conectar: ' . mysql_error());

		mysql_select_db($this->BaseDatos,$con) or die('[!] No se pudo seleccionar la base de datos. <br />
		Probablemente la base de datos no ha sido creada ó no lo ha especificado correctamente en el archivo <code>config.php</code> <br />
		Entre los archivos del paquete, esta el directorio <code>_sql</code> que contiene la estructura de la base de datos en <code>sql</code> <br />
		Asegurese de ejecutarlo y establecer el nombre de la base de datos en el archivo <code>config.php</code>. <br />
		Mysql error:' . mysql_error());

		/*if (!@mysql_select_db($this->BaseDatos,$con)){
			echo "Error al seleccionar la base de datos";
			exit();
		}*/

		$this->conect=$con;
		return true;
	}
}
?>
