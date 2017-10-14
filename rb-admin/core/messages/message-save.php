<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';
// Modo
$mode=$_POST['mode'];

// DEFINICION DE VARIABLES
$remitente_id =$_POST['remitente_id'];
$asunto =$_POST['asunto'];
$contenido = addslashes($_POST['contenido']);

// USUARIOS
if(!isset($_REQUEST['users'])) {
  print "[!] Debe seleccionar el o los destinatarios";
  die();
}
$array_users_id = $_REQUEST['users'];

// tipo de accion
if($mode=="new"){
  $campos = array($remitente_id, $asunto, $contenido);
  $q = "INSERT INTO mensajes (remitente_id, asunto, contenido, fecha_envio) VALUES (".$campos[0].",'".$campos[1]."','".$campos[2]."', NOW() )";
  $result = $objDataBase->Insertar($q);
  if($result){
    $ultimo_id=$result['insert_id'];

    // GRABA DATOS EN LA TABLA DETALLES
    foreach($array_users_id as $user_id){
      $objDataBase->Ejecutar("INSERT INTO mensajes_usuarios (mensaje_id, usuario_id) VALUES ($ultimo_id,$user_id)");
    }

    // REDIRECCIONAR
    $enlace=G_SERVER.'/rb-admin/index.php?pag=men&opc=send';
    header('Location: '.$enlace);
  }else{
    echo "Problemas";
  }
}
?>
