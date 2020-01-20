<?php
header('Content-type: application/json; charset=utf-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/funcs.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";

if(G_ACCESOUSUARIO>0){
	$album_id = isset($_POST['albumid']) ? $_POST['albumid'] : -1;
	$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : -1;
	if($album_id == -1){
		$arr = ['resultado' => false, 'contenido' => 'Valores no reconocidos'];
	}
	if($user_id == -1){
		$arr = ['resultado' => false, 'contenido' => 'Valores no reconocidos'];
	}
	$dir_gallery =  ABSPATH."rb-media/gallery/";
	$dir_gallery_thumbs = ABSPATH."rb-media/gallery/tn/";
	$watermark = rb_get_values_options('water_mark_image');

	if(isset($_FILES["myfile"])){

		$error =$_FILES["myfile"]["error"]; // ???

		if(!is_array($_FILES["myfile"]["name"])) {// Carga de un solo archivo (opcion de multiples subidas no usada)

			// Verificando si existe archivo con el mismo nombre
			$temp = explode(".", $_FILES["myfile"]["name"]);
			$originalfileName = pathinfo(utf8_decode($_FILES['myfile']['name']), PATHINFO_FILENAME); // 22/06/17 utf8_decode -> Para que acepte carecteres especiales Ñ tildes y espacios
			$originalfileName = rb_cambiar_nombre($originalfileName); // cambios caracteres español y espacios vacios

			// Le añade un numero al final a los archivos con el mismo nombre
			$i = count(glob($dir_gallery.$originalfileName.'*.'.end($temp))) + 1;
			if($i>1){
				$fileName = $originalfileName.$i.'.'.end($temp);
			}else{
				$fileName = $originalfileName.'.'.end($temp);
			}

			// Comprimiendo y guardan en directorio (desactivado por momento)
			//rb_compress($_FILES["myfile"]["tmp_name"], $dir_gallery.$fileName);

			// Verificar que tipo de archivo enviado no sea vacio, asi evitar subida de cualquier archivo
			$fileType = $_FILES["myfile"]["type"];
			if($fileType==""){
				$arr = ['resultado' => false, 'contenido' => 'No se reconoce el tipo de archivo.'];
				die(json_encode($arr));
			}

			// Verificar si hay marca de agua y subida del archivo al servidor
			if ( $watermark > 0 && $fileType == "image/jpeg"){
				// Aplicar marca de agua y subida
				$photos = rb_get_photo_from_id( rb_get_values_options('water_mark_image') );
				$WaterMark = ABSPATH."rb-media/gallery/".$photos['src'];
				addImageWatermark($_FILES["myfile"]["tmp_name"], $WaterMark, $dir_gallery.$fileName, 10);
			}else{
				// Solo subida
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$dir_gallery.$fileName);
			}

			// Creando thumbnails sin archivo es imagen
			if($fileType == "image/png" || $fileType == "image/jpeg" || $fileType == "image/gif") {
				if(!rb_createThumbnail($fileName, $dir_gallery_thumbs, $dir_gallery, 300)){ // Si arroja error en el proceso
					$arr = ['resultado' => false, 'contenido' => 'El archivo no es una imagen'];
					die(json_encode($arr));
				}
			}
			// Si todo proceso de subida salio bien, almacenar informacion de archivo en base de datos
			$valores = [
				'title' => $originalfileName,
				'src' => $fileName,
				'tn_src' => $fileName,
				'album_id' => $album_id,
				'type' => $fileType,
				'tipo' => "",
				'usuario_id' => $user_id
			];

			$r = $objDataBase->Insert(G_PREFIX."files", $valores);
	    if($r['result']){
				$ultimo_id = $r['insert_id'];
	    }
		}
		$arr = ['resultado' => true, 'last_id' => $ultimo_id, 'type' => $fileType, 'filename' => $fileName, 'watermark' => $watermark ];
	}
}else{
  $arr = ['resultado' => false, 'contenido' => 'No cuenta con los permisos'];
}
die(json_encode($arr));
?>
