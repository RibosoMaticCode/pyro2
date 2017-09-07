<?php
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR
// REVISAR REVISAR REVISAR

// SI no existe clase y/o definida entonces signfica q esta independeite
/*if(!class_exists('Opciones')){
	$root =  dirname(dirname(__FILE__)) . '/';
	require($root."rb-script/class/rb-opciones.class.php");

	$q = $objOpcion->Consultar("SELECT * FROM opciones");
	define('G_SERVER', $objOpcion->obtener_valor(1,'direccion_url'));

	session_start();

	if(isset($_SESSION['usr']) and isset($_SESSION['pwd'])){
		define('G_ACCESOUSUARIO',1);
	}else{
		define('G_ACCESOUSUARIO',0);
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
}*/
?>
