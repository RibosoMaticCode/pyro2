<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

header('Content-type: application/json; charset=utf-8');
// obtener id del usuario en sesion en navegador
if(isset($_SESSION['usr_id'])) {
  $user_id = $_GET['uid'];
  $id = $_GET['id'];
  // validar id del usuario del navegador con el que ingreso al sistema
  if($_SESSION['usr_id']==$user_id){
    // uso de variable auxiliar
    if(!isset($_GET['mode'])) die("[!] Ocurrio un error.");

    if($_GET['mode']=="rd"){
      //if($objDataBase->DesactivarRecibidos($id,$user_id)) echo "Good";
      $objDataBase->Ejecutar("UPDATE mensajes_usuarios SET inactivo = 1 WHERE mensaje_id=$id AND usuario_id=$user_id");
      //include('listado.php');
      $arr = array('result' => 1, 'message' => "Mensaje recibido eliminado" );
      die(json_encode($arr));
    }elseif($_GET['mode']=="sd"){
      //if($objDataBase->DesactivarEnviados($id,$user_id)) echo "Good";
      $objDataBase->Ejecutar("UPDATE mensajes SET inactivo = 1 WHERE remitente_id=$user_id AND id=$id");
      //include('listado.php');
      $arr = array('result' => 1, 'message' => "Mensaje enviado eliminado" );
      die(json_encode($arr));
    }
  }else{
    //die("Usuario online no valido");
    $arr = array('result' => 0, 'message' => "Usuario online no valido" );
    die(json_encode($arr));
  }
}else{
  //die("[!] Necesita iniciar sesion con su cuenta de usuario");
  $arr = array('result' => 0, 'message' => "[!] Necesita iniciar sesion con su cuenta de usuario" );
  die(json_encode($arr));
}
?>
