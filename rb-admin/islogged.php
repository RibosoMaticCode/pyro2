<?php
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR

// SI no existe clase y/o definida entonces signfica q esta independeite
if(!class_exists('Opciones')){
	// VERIFICA SI ESTA LOGUEADO PARA USAR EL ARCHIVO
	$root =  dirname(dirname(__FILE__)) . '/';
	//require($root.'global.php');
	require($root."rb-script/class/rb-opciones.class.php");

	// verifica datos en tabla, sino inicial el instalador
	$q = $objOpcion->Consultar("SELECT * FROM opciones");
	define('G_SERVER', $objOpcion->obtener_valor(1,'direccion_url'));

	session_start();

	if(isset($_SESSION['usr']) and isset($_SESSION['pwd'])){
		define('G_ACCESOUSUARIO',1);
		/*define('G_USERID', $_SESSION['usr_id']);
		define('G_USERTYPE', $_SESSION['type']);*/
	}else{
		define('G_ACCESOUSUARIO',0);
		/*define('G_USERID', 0);
		define('G_USERTYPE', 0);*/
	}

	// USUARIO NO LOGUEADO, AL INICIAR SESION
	if(G_ACCESOUSUARIO==0){
		header('Location: '.G_SERVER.'/index.php');
	}elseif(G_ACCESOUSUARIO==1){
	// USUARIO LOGUEADO, REENVIAMOS A DONDE CORRESPONDE
		if(isset($_SESSION['type'])){
	    switch ($_SESSION['type']) {
	      case 'admin':
	      case 'user-panel':
	        header('Location: '.G_SERVER.'/rb-admin/');
	      break;
	      case 'user-front':
	        header('Location: '.G_SERVER);
	      break;
	    }
		}else{
	    header('Location: '.G_SERVER);
	  }
	}
}
?>
