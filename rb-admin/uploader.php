<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

if(G_ACCESOUSUARIO>0){
	$album_id = $_POST['albumid'];
	$user_id = $_POST['user_id'];
	$dir_gallery =  ABSPATH."rb-media/gallery/";
	$dir_gallery_thumbs = ABSPATH."rb-media/gallery/tn/";

	if(isset($_FILES["myfile"])){

		$error =$_FILES["myfile"]["error"]; // ???

		if(!is_array($_FILES["myfile"]["name"])) {//single file

			// Verificando si existe archivo con el mismo nombre
			$temp = explode(".", $_FILES["myfile"]["name"]);
			$originalfileName = pathinfo(utf8_decode($_FILES['myfile']['name']), PATHINFO_FILENAME); // 22/06/17 utf8_decode -> Para que acepte carecteres especiales Ñ tildes y espacios
			$i = count(glob($dir_gallery.$originalfileName.'*.'.end($temp))) + 1;
			if($i>1){
				$fileName = $originalfileName.$i.'.'.end($temp);
			}else{
				$fileName = $originalfileName.'.'.end($temp);
			}

			// Comprimiendo y guardan en directorio
			rb_compress($_FILES["myfile"]["tmp_name"], $dir_gallery.$fileName);

			// Creando thumbnails
			$fileType = $_FILES["myfile"]["type"];
			if($fileType == "image/png" || $fileType == "image/jpeg" || $fileType == "image/gif") rb_createThumbnail($fileName, $dir_gallery_thumbs, $dir_gallery, 300);

			// Almacenando informacion de archivo en base de datos
			$valores = [
				'title' => $originalfileName,
				'src' => $fileName,
				'tn_src' => $fileName,
				'album_id' => $album_id,
				'type' => $fileType,
				'tipo' => "",
				'usuario_id' => $user_id
			];

			$r = $objDataBase->Insert('photo', $valores);
	    if($r['result']){
				$ultimo_id = $r['insert_id'];
	    }
		}

		$arr = ['resultado' => true, 'last_id' => $ultimo_id, 'type' => $fileType ];
	}

}else{
  $arr = ['resultado' => false, 'contenido' => 'No cuenta con los permisos'];
}
die(json_encode($arr));
?>
