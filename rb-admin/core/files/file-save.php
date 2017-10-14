<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

// Modo
$mode=$_POST['mode'];
$error;

// variables
$des = $_POST['title'];
$album_id = $_POST['album_id'];

    // validates the form input
    //if(strlen($_POST['descripcion']) < 4) die("Se necesita agregar una descripcion");

    // imagen
    $loadimage = false;
    if($mode == "new"){
        // si es nuevo y no hay imagen cargada - rebotar
        if($_FILES['fupload']['name'] == "") die("Debe seleccionar una imagen");
        $loadimage = true;

    }elseif($mode == "update"){
        // si es actualizar y no hay imagen, no carga imagen
        if($_FILES['fupload']['name'] == "") $loadimage = false;
        else $loadimage = true;
    }

    // si la orden es cargar imagen
    if($loadimage){
  if(isset($_FILES['fupload'])) {

            // file's directory
    $directorio = '../rb-media/gallery/';
    $directorio_thumbs = '../rb-media/gallery/tn/';

    $filename = addslashes($_FILES['fupload']['name']);
    $source = $_FILES['fupload']['tmp_name'];
    $target = $directorio . $filename;
    $src = $directorio . $filename;
    $tn_src = $directorio_thumbs  . $filename;

    // Validates the form input

    if($filename == '' || !preg_match('/[.](jpg)|(gif)|(png)|(jpeg)$/', $filename))
    $error['no_file'] = '<p class="alert">Por favor seleccionar una imagen! </p>';

    if(!$error) {  // esta linea genera un error (averiguar): Notice: Undefined variable: error in E:\xampp\htdocs\dev.clasmoche\rb-admin\save.php on line 145
      move_uploaded_file($source, $target);
      createThumbnail($filename, $directorio_thumbs, $directorio, 300);

      die("300");
    }  // end preg_match
  }
}

    // tipo de accion
  /*  if($mode=="new"){
        $objDataBase->Insertar(array($des,$filename,$filename,$album_id));
        $campos = array($des,$filename,$filename,$album_id);
        $q = "INSERT INTO photo (title, src, tn_src, album_id, type, tipo, usuario_id) VALUES ('".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",'".$campos[4]."','".$campos[5]."', ".$campos[6].")";
        $objDataBase->Ejecutar( $q );


  //redireccionar a la pagina de edicion
  $urlreload=G_SERVER.'/rb-admin/index.php?pag=img&album_id='.$album_id."&m=ok";
  header('Location: '.$urlreload);

}else*/

if($mode=="update"){

    $id = $_POST['id'];

    if($loadimage) {
            // si cargo imagen, actualizar imagen y descripcion
            $objDataBase->EditarPorCampo("photo","title",$des,$id);
            $objDataBase->EditarPorCampo("photo","src",$filename,$id);
            $objDataBase->EditarPorCampo("photo","tn_src",$filename,$id);
        }else{
            // si no cargo imagen, actualizar solo descripcion
            $objDataBase->EditarPorCampo("photo","title",$des,$id);

        }

        //redireccionar a la pagina de edicion
        $urlreload=G_SERVER.'/rb-admin/index.php?pag=file_edit&opc=edt&id='.$id.'&m=ok';
        header('Location: '.$urlreload);
}
?>