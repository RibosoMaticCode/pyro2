<?php
//header('Content-Type: text/html;charset=UTF-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-fotos.class.php");

$album_id = $_POST['albumid'];
$user_id = $_POST['user_id'];

$output_dir = ABSPATH."rb-media/gallery/";
if(isset($_FILES["myfile"]))
{
	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData()
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
		$temp = explode(".", $_FILES["myfile"]["name"]);

		$originalfileName = pathinfo(utf8_decode($_FILES['myfile']['name']), PATHINFO_FILENAME); // 22/06/17 utf8_decode -> Para que acepte carecteres especiales Ñ tildes y espacios
		$i = count(glob(ABSPATH."rb-media/gallery/".$originalfileName.'*.'.end($temp))) + 1;
		if($i>1){
			$fileName = $originalfileName.$i.'.'.end($temp);
		}else{
			$fileName = $originalfileName.'.'.end($temp);
		}

 		move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.$fileName);

		// creando thumbnails
		$directorio = ABSPATH.'rb-media/gallery/';
		$directorio_thumbs = ABSPATH.'rb-media/gallery/tn/';
		$fileType = $_FILES["myfile"]["type"];
		if($fileType == "image/png" || $fileType == "image/jpeg" || $fileType == "image/gif") rb_createThumbnail($fileName, $directorio_thumbs, $directorio, 300);

		$objFoto->Insertar(array($originalfileName,$fileName,$fileName,$album_id,$fileType,"",$user_id));
		$ultimo_id=mysql_insert_id();
	}/*else{  //Multiple files, file[]
	  	$fileCount = count($_FILES["myfile"]["name"]);
		for($i=0; $i < $fileCount; $i++){
			$temp = explode(".", $_FILES["myfile"]["name"]);
			//$fileName = $uniqid . '.' . end($temp);

			$originalfileName = pathinfo(utf8_decode($_FILES['myfile']['name']), PATHINFO_FILENAME); // 22/06/17 utf8_decode -> Para que acepte carecteres especiales Ñ tildes y espacios
			$i = count(glob(ABSPATH."rb-media/gallery/".$originalfileName.'*.'.end($temp))) + 1;
			if($i>1){
				$fileName = $originalfileName.$i.'.'.end($temp);
			}else{
				$fileName = $originalfileName.'.'.end($temp);
			}
			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);

			// creando thumbnails
			$directorio = ABSPATH.'rb-media/gallery/';
			$directorio_thumbs = ABSPATH.'rb-media/gallery/tn/';

			$fileType = $_FILES["myfile"]["type"];
			if($fileType == "image/png" || $fileType == "image/jpeg" || $fileType == "image/gif") rb_createThumbnail($fileName, $directorio_thumbs, $directorio, 300);

			rb_createThumbnail($fileName, $directorio_thumbs, $directorio, 300);

			// guardando en bd
			$objFoto->Insertar(array($originalfileName,$fileName,$fileName,$album_id,$fileType,"",$user_id));
			$ultimo_id=mysql_insert_id();
	  	}
	}*/
    echo $ultimo_id;
}
?>
