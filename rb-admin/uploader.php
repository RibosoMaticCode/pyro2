<?php
//header('Content-Type: text/html;charset=UTF-8');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$album_id = $_POST['albumid'];
$user_id = $_POST['user_id'];

$output_dir = ABSPATH."rb-media/gallery/";
if(isset($_FILES["myfile"]))
{
	$error =$_FILES["myfile"]["error"];
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

    $campos = array($originalfileName,$fileName,$fileName,$album_id,$fileType,"",$user_id);
    $q = "INSERT INTO photo (title, src, tn_src, album_id, type, tipo, usuario_id) VALUES ('".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",'".$campos[4]."','".$campos[5]."', ".$campos[6].")";
		$result = $objDataBase->Insertar( $q );
    if($result){
      $ultimo_id = $result['insert_id'];
    }
	}
  echo $ultimo_id;
}
?>
