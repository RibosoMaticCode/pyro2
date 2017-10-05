<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/class/rb-usuarios.class.php';
require_once ABSPATH.'rb-script/funciones.php';

// Modo
$mode=$_POST['mode'];

// DEFINICION DE VARIABLES Y VALIDACIONES
$nm = (empty($_POST['nom']) ? die('[!] Falta Nombres') : $_POST['nom']);
$ap = (empty($_POST['ape']) ? die('[!] Falta Apellidos') : $_POST['ape']);
$cn = $_POST['ciu'];
$cr = $_POST['pais'];
$di = $_POST['dir'];
$tipo = $_POST['tipo'];

if($tipo>0):
  $mail=(empty($_POST['mail']) ? die('[!] Falta E-mail') : $_POST['mail']);
  $nickname = (empty($_POST['nickname']) ? die('[!] Falta Nickname') : $_POST['nickname']);
else:
  $mail= $_POST['mail'];
  $nickname = $_POST['nickname'];
endif;

$tf = $_POST['telfij'];
$tm = $_POST['telmov'];

$pwd=$_POST['password'];
$pwd1=$_POST['password1'];

    $sex = $_POST['sexo'];
$photo = $_POST['photo_id'];

$bio = $_POST['bio'];
$tw = $_POST['tw'];
$fb = $_POST['fb'];
$gplus = $_POST['gplus'];
$in = $_POST['in'];
$pin = $_POST['pin'];
$insta = $_POST['insta'];
$youtube = $_POST['youtube'];
$grupo_id = $_POST['grupo'];

// tipo de accion
if($mode=="new"){
  // VALIDAR NOMBRE DE USUARIO
  if($tipo>0):
    if($objUsuario->existe('nickname',$nickname)!=0) die('Error: Nombre de usuario registrado');
  endif;

  // VALIDAR CORREO
  //if($objUsuario->existe('correo',$mail)!=0) die('Error: Correo electronico usado por otro usuario');

  // VALIDAR PASSWORDS
  if($tipo>0):
    $pwd=(empty($_POST['password']) ? die('[!] Ingrese una contrasena') : $_POST['password']);
    $pwd1=(empty($_POST['password1']) ? die('[!] Ingrese una contrasena') : $_POST['password1']);

    if($pwd!=$pwd1){
      die('Las contrasenas no coinciden');
    }
  endif;

  // INSERTAR USUARIO NUEVO
	$campos = array($nickname, $pwd, $nm, $ap, $cn, $cr, $tm, $tf, $mail, $di, $tipo, $sex, $photo);
	$q = "INSERT INTO usuarios (nickname, password, nombres, apellidos, ciudad, pais, `telefono-movil`, `telefono-fijo`, correo, direccion, tipo, fecharegistro, fecha_activar, ultimoacceso, sexo,photo_id) VALUES ('".$campos[0]."', '".md5($campos[1])."', '".$campos[2]."', '".$campos[3]."', '".$campos[4]."', '".$campos[5]."', '".$campos[6]."', '".$campos[7]."', '".$campos[8]."', '".$campos[9]."', ".$campos[10].", NOW(), ADDDATE(NOW(), INTERVAL 2 DAY), NOW(), '".$campos[11]."', ".$campos[12].")";
	$result = $objDataBase->Insertar($q);
  if($result){

    $ultimo_id=$result['insert_id'];

    $objDataBase->EditarPorCampo("usuarios", "bio", $bio, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "tw", $tw, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "fb", $fb, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "gplus", $gplus, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "in", $in, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "pin", $pin, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "insta", $insta, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "youtube", $youtube, $ultimo_id);
    $objDataBase->EditarPorCampo("usuarios", "grupo_id", $grupo_id, $ultimo_id);

    $enlace=G_SERVER.'/rb-admin/index.php?pag=usu&opc=edt&id='.$ultimo_id."&m=ok";
    header('Location: '.$enlace);
  }else{
    echo "[!] Problemas a guardar el nuevo usuario";
  }
}elseif($mode=="update"){
  $id=$_POST['id'];
  $change_pwd = 0;

  // SI NO ESTAN VACIOS LOS CAMPOS DE CONTRASENA, ESTAS DEBEN SER IGUALES
  if( strlen(trim($pwd))>0 || strlen(trim($pwd1))>0 ){
    if($pwd!=$pwd1){
      die('Las contrasenas no coinciden');
    }else{
      // SE APRUEBA EL CAMBIO DE PASSWORD
      $change_pwd = 1;
    }
  }

  // EDITAR
  if($objUsuario->Editar(array($nm, $ap, $cn, $cr, $tm, $tf, $mail, $di, $tipo, $sex, $photo),$id)){

    if($change_pwd==1) $objDataBase->EditarPorCampo("password", md5(trim($pwd)),$id);

    $objDataBase->EditarPorCampo("usuarios", "bio", $bio, $id);
    $objDataBase->EditarPorCampo("usuarios", "tw", $tw, $id);
    $objDataBase->EditarPorCampo("usuarios", "fb", $fb, $id);
    $objDataBase->EditarPorCampo("usuarios", "gplus", $gplus, $id);
    $objDataBase->EditarPorCampo("usuarios", "in", $in, $id);
    $objDataBase->EditarPorCampo("usuarios", "pin", $pin, $id);
    $objDataBase->EditarPorCampo("usuarios", "insta", $insta, $id);
    $objDataBase->EditarPorCampo("usuarios", "youtube", $youtube, $id);
    $objDataBase->EditarPorCampo("usuarios", "grupo_id", $grupo_id, $id);

    $enlace=G_SERVER.'/rb-admin/index.php?pag=usu&opc=edt&id='.$id."&m=ok";
    header('Location: '.$enlace);
  }else{
    echo "[!] Problemas a actualizar datos del usuario";
  }
}
?>
