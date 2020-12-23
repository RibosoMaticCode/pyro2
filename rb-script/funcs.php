<?php
// La funcion retornar la url actual
function current_url(){
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $url = "https://";   
  else  
    $url = "http://";   
  
  // Append the host(domain name, ip) to the URL.   
  $url.= $_SERVER['HTTP_HOST'];   
       
  // Append the requested resource location to the URL   
  $url.= $_SERVER['REQUEST_URI'];
  return $url;
}

// Enrutamiento amigable en panel administrativo:
// La funcion compara la url establecida por el cliente, Ejemplos:
//    forms/edit/6
//    forms/new
// Y la compara con la url activa, si coincide mostrara contenido
// correspondiente
function custom_url($url_custom){
  global $url_found;
  // Retiramos el directorio (dashboard) de la url
  // Solo consideramos desde dashboard en adelante
  // En directorio dashboard/ debe estar configurado archivo htaccess
  //$requestURI = str_replace("dashboard", "", $_SERVER['REQUEST_URI']);

  // Divimos la url por la barra, y lo convertimos a un array php
  $requestURI = explode("/", $_SERVER['REQUEST_URI']);

  // Limpiamos el array para que solo obtengamos valores no vacios. Ej.
  //    forms
  //    edit
  //    6
  $requestURI = array_values( array_filter( $requestURI ) );

  // Contabilizamos elementos obtenidos
  $numsItemArray = count($requestURI);

  // Si es raiz (http://dominio.com/dashboard/)
  if($url_custom=="/" && $numsItemArray==0){
    $url_found = true;
    return $result=[
      'result' => true
    ];
  }

  // El url establecido por el cliente debemos tambien dividirlo y obtener la cantidad
  $url_custom = explode("/", $url_custom);
  $num_url_custom = count($url_custom);

  //print "custom";
  //print_r($url_custom);
  //print "sistema";
  //print_r($requestURI);

  // Define si hay coincidencia de la url activa con la definida por usuario
  $concidencia = false;

  // Parametros devueltos
  $parameters = [];

  // Si la url activa tiene mas de 0 elementos, empezamos a comparar
  if($numsItemArray>0){
    // Numero elementos url activa debe ser igual a la url cliente
    if($numsItemArray == $num_url_custom){
      $i=0;
      // Comparamos cada elemento de la url activa con la url cliente
      foreach ($requestURI as $URI) {
        // Si el elemento de la url cliente es comodin estilo <comodin>
        // ira como parametro de salida y el valor correspondiente. Ej
        //    forms/edit/<comodin>    - url cliente
        //    forms/edit/7            - url activa
        //  parametro seria [comodin => 7]
        if(comodin($url_custom[$i])){
          $parameter = get_item_value($url_custom[$i]);
          //echo "comodin:".$parameter;
          $parameters[$parameter] = $URI;
          $i++;
          continue;
        }
        // si elemento de url activa coincide con los de url cliente
        if($URI == $url_custom[$i]) {
          //echo "sistema:".$URI."<br>";
          //echo "custom:".$url_custom[$i]."<br>";
          $concidencia = true;
        }else{ // Vasta que uno no coincide, no evalua más y retorna falso
          return $result=[
            'result' => false
          ];
        }
        $i++;
      }
      // Si despues de comparacion todos elementos del url coincide
      // devuelve verdadero con parametros comodin si hubiera
      $url_found = true;
      return $result=[
        'result' => $concidencia,
        'parameters' => $parameters
      ];
    }else{
      // Si numero elemento url activa es distinta que la url cliente
      // retornar falso
      return $result=[
        'result' => false
      ];
    }
  }else{ // Si no hay elementos en url activa
    return $result=[
      'result' => false
    ];
  }
}

function get_title_page($url){
  $str = file_get_contents($url);
  if(strlen($str)>0){
    $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
    return $title[1];
  }
}
// Verifica que sea comodin, que contenga caracteres <> al inicio y final respectivamente
function comodin($comodin_value){
  $verify1 = false;
  $verify2 = false;
  $first = substr($comodin_value, 0, 1);
  $last = substr($comodin_value, -1);
  if($first=="<"){
    $verify1 = true;
  }
  if($last==">"){
    $verify2 = true;
  }
  if($verify1 && $verify2){
    return true;
  }else{
    return false;
  }
}
// retira caracteres <>, del comodin <elemento>
function get_item_value($comodin){
  return substr($comodin, 1, -1);
}

// Enrutamiento amigable en panel administrativo:
// La funcion compara la url establecida por el cliente, Ejemplos:
//    forms/edit/6
//    forms/new
// Y la compara con la url activa, si coincide mostrara contenido
// correspondiente
function rb_module_url($url_custom){
  // Retiramos el directorio (rb-admin) de la url
  // Solo consideramos desde rb-admin en adelante
  // En directorio rb-admin/ debe estar configurado archivo htaccess
  $requestURI = str_replace("rb-admin", "", $_SERVER['REQUEST_URI']);

  // Divimos la url por la barra, y lo convertimos a un array php
  $requestURI = explode("/", $requestURI);

  // Limpiamos el array para que solo obtengamos valores no vacios. Ej.
  //    forms
  //    edit
  //    6
  $requestURI = array_values( array_filter( $requestURI ) );

  // Contabilizamos elementos obtenidos
  $numsItemArray = count($requestURI);

  // El url establecido por el cliente debemos tambien dividirlo y obtener la cantidad
  $url_custom = explode("/", $url_custom);
  $num_url_custom = count($url_custom);

  //print_r($url_custom);
  //print_r($requestURI);

  // Define si hay coincidencia de la url activa con la definida por usuario
  $concidencia = false;

  // Parametros devueltos
  $parameters = [];

  // Si la url activa tiene mas de 0 elementos, empezamos a comparar
  if($numsItemArray>0){
    // Numero elementos url activa debe ser igual a la url cliente
    if($numsItemArray == $num_url_custom){
      $i=0;
      // Comparamos cada elemento de la url activa con la url cliente
      foreach ($requestURI as $URI) {
        // Si el elemento de la url cliente es comodin estilo <comodin>
        // ira como parametro de salida y el valor correspondiente. Ej
        //    forms/edit/<comodin>    - url cliente
        //    forms/edit/7            - url activa
        //  parametro seria [comodin => 7]
        if(comodin($url_custom[$i])){
          $parameter = get_item_value($url_custom[$i]);
          //echo "comodin:".$parameter;
          $parameters[$parameter] = $URI;
          $i++;
          continue;
        }
        // si elemento de url activa coincide con los de url cliente
        if($URI == $url_custom[$i]) {
          //echo "sistema:".$URI."<br>";
          //echo "custom:".$url_custom[$i]."<br>";
          $concidencia = true;
        }else{ // Vasta que uno no coincide, no evalua más y retorna falso
          return $result=[
            'result' => false
          ];
        }
        $i++;
      }
      // Si despues de comparacion todos elementos del url coincide
      // devuelve verdadero con parametros comodin si hubiera
      return $result=[
        'result' => $concidencia,
        'parameters' => $parameters
      ];
    }
  }else{ // Si no hay elementos en url activa
    return $result=[
      'result' => false
    ];
  }
}

// Copia el directorio de la plantilla por defecto: default
// A una posicion para que el usuario pueda modificarlo
function rb_recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                rb_recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

// Marca de agua estandar
// https://www.php.net/manual/es/image.examples-watermark.php
function addImageWatermark($SourceFile, $WaterMark, $DestinationFile=NULL) {
  $main_img = $SourceFile;
  $watermark_img = $WaterMark;
  // create watermark
  $watermark = imagecreatefrompng($watermark_img);
  $image = imagecreatefromjpeg($main_img);
  if(!$image || !$watermark) die("Error: main image or watermark image could not be loaded!");

  $margen_dcho = 10;
  $margen_inf = 10;
  $sx = imagesx($watermark);
  $sy = imagesy($watermark);

  imagecopy($image, $watermark, imagesx($image) - $sx - $margen_dcho, imagesy($image) - $sy - $margen_inf, 0, 0, imagesx($watermark), imagesy($watermark));

  if($DestinationFile<>''){
    imagejpeg($image, $DestinationFile, 100);
  }else{
    header('Content-Type: image/jpeg');
    imagejpeg($image);
  }
  imagedestroy($image);
  imagedestroy($watermark);
}

// Marca de agua con opacidad
// https://www.phpzag.com/how-to-add-watermark-to-image-using-php/
function addImageWatermark_opacity($SourceFile, $WaterMark, $DestinationFile=NULL, $opacity) {
  $main_img = $SourceFile;
  $watermark_img = $WaterMark;
  $padding = 5;
  $opacity = $opacity;
  // create watermark
  $watermark = imagecreatefrompng($watermark_img);
  $image = imagecreatefromjpeg($main_img);
  if(!$image || !$watermark) die("Error: main image or watermark image could not be loaded!");
  $watermark_size = getimagesize($watermark_img);
  $watermark_width = $watermark_size[0];
  $watermark_height = $watermark_size[1];
  $image_size = getimagesize($main_img);
  $dest_x = $image_size[0] - $watermark_width - $padding;
  $dest_y = $image_size[1] - $watermark_height - $padding;
  imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $opacity);
  if($DestinationFile<>'') {
    imagejpeg($image, $DestinationFile, 100);
  }else{
    header('Content-Type: image/jpeg');
    imagejpeg($image);
  }
  imagedestroy($image);
  imagedestroy($watermark);
}

function is_https(){
    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on')
    {
      return TRUE;
    }
    elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    {
      return TRUE;
    }
    elseif (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on')
    {
      return TRUE;
    }
    return FALSE;
}

function rb_mailing_send($title_message, $message){ // Envia mail a cada usuario activo del sistema
	global $objDataBase;
  $q = $objDataBase->Ejecutar("SELECT nombres, correo FROM ".G_PREFIX."users WHERE activo=1");
  while($mail = $q->fetch_assoc()){
    $subject = $title_message;
    $recipient = $mail['correo'];
    $email_content = "<h2>Hola ".$mail['nombres']."</h2><br />";
    $email_content .= $message;
    $email_content .= "<br /><p>--</p>";
    $email_content .= "<p>Este mensaje fue enviado automaticamente desde la web.</p>";

    $from_name = rb_get_values_options('name_sender');
    $mail_no_reply = rb_get_values_options('mail_sender');
    $email_headers = "From: $from_name <$mail_no_reply> \r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-Type: text/html; UTF-8\r\n";

    // Send the email.
    mail($recipient, $subject, $email_content, $email_headers);
  }
}

function rb_css_list($css_list){
  if(!isset($css_list)) return;
  require_once ABSPATH."global.php";
  $css_list_string = "";
  foreach ($css_list as $value) {
    $css_list_string .= "<link rel='stylesheet' href='".G_SERVER.$value."'>\n";
  }
  return $css_list_string;
}
//https://davidwalsh.name/backup-mysql-database-php
function rb_backup_data($tables="*"){
  $response = false;
  global $objDataBase;
  $objDataBase->Ejecutar('SET NAMES utf8');
  $objDataBase->Ejecutar('SET CHARACTER SET utf8');
  //get all of the tables
	if($tables == '*'){
		$tables = array();
		$result = $objDataBase->Ejecutar('SHOW TABLES');
		while($row = $result->fetch_row()){
			$tables[] = $row[0];
		}
	}else{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}

  $return = "";
  //cycle through
	foreach($tables as $table){
		$result = $objDataBase->Ejecutar('SELECT * FROM '.$table);
		$num_fields = $result->field_count;
    //echo $num_fields; // numero de campos-columnas de cada tabla

		//$return.= 'DROP TABLE `'.$table.'`;'; ??
    $result2 = $objDataBase->Ejecutar('SHOW CREATE TABLE '.$table);
		$row2 = $result2->fetch_row();//mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";

		for ($i = 0; $i < $num_fields; $i++) {
			while($row = $result->fetch_row()){
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
          //$row[$j] = utf8_encode($row[$j]); // Convierte a UTF8 -- no necesaria por que la base datos trabaja con UTF8
          $row[$j] = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
  //die($return);
  if(trim(G_KEYWEB)==""){
    $key_web = randomPassword(12,1,"lower_case,upper_case,numbers,special_symbols");
    $dir_backup = $key_web[0];
  }else{
    $key_web = G_KEYWEB;
  }

  $path_backup = $_SERVER['DOCUMENT_ROOT'].G_DIRECTORY."/".$key_web."/";
  $url_backup = G_SERVER.G_DIRECTORY."/".$key_web."/";

  if (!file_exists($path_backup)) {
    mkdir($path_backup, 0777, true);
  }

	//save file
  $filename = 'db-backup-'.time().'.sql';
	$handle = fopen($path_backup.$filename,'w+');
	fwrite($handle,$return);
	fclose($handle);
  $response = true;

  return ["response" =>$response, "filename" => $filename, "url_backup" => $url_backup];
}
// paginado de listado ->
// Parametros: Pagina actual, total de elementos, link de retorno, elementos a mostrar
function rb_paged_list($pag_act, $total, $link_section, $nums_show){
  if($pag_act<=0) $pag_act = 1;
  $pag_ant=$pag_act-1;
  $pag_sig=$pag_act+1;
  $pag_ult=$total/$nums_show;
  $residuo=$total%$nums_show;
  if($residuo>0) $pag_ult=floor($pag_ult)+1;
  ?>
  <ul>
  <?php
  if($pag_act>1){	?>
    <li><a href="<?= $link_section ?>">«</a></li> <!-- siempre sera 1 -->
    <li><a href="<?= $link_section ?><?php if($pag_ant>1): ?>&page=<?= $pag_ant?> <?php endif ?>">‹</a></li>
  <?php
  }else{?>
    <li class="page-disabled"><a class="pbutton previous">«</a></li>
    <li class="page-disabled"><a class="pbutton previous">‹</a></li>
  <?php
  }
  ?>
  <li>
    <span class="page-info">
    Pagina <?= $pag_act ?> <?php if ($pag_ult > 0) ?> de <?= $pag_ult ?>
    </span>
  </li>
  <?php
  if($pag_act<$pag_ult) {?>
    <li><a href="<?= $link_section ?>&page=<?= $pag_sig?>">›</a></li>
    <li><a href="<?= $link_section ?>&page=<?= $pag_ult?>">»</a></li>
    <?php
  }else{?>
    <li class="page-disabled"><a class="pbutton next">›</a></li>
    <li class="page-disabled"><a class="pbutton next">»</a></li>
  <?php
  }
  ?>
  </ul>
  <?php
}

// nuevas funciones usando msqyli
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname( dirname(__FILE__) ) . '/');

require_once ABSPATH."rb-script/class/rb-database.class.php";
$objDataBase = new DataBase;

// Grabar una entrada en la lista de registro dela db
function rb_log_register( $values ){
  global $objDataBase;
  $objDataBase->Ejecutar("INSERT INTO log (usuario_id, usuario, observacion, fecha) VALUES ( ".$values[0].",'".$values[1]."','".$values[2]."', NOW() )");
}

// La funcion retorna valor segun la opcion de la tabla opciones, que almacena los valores iniciales y generales de la web
function rb_get_values_options($option){
  global $objDataBase;
  $q = $objDataBase->Ejecutar("SELECT value FROM ".G_PREFIX."configuration WHERE option_name='".$option."'");
  $rows = $q->fetch_assoc();
  $q->free();
  return $rows['value'];
}

function rb_set_values_options($option, $new_value){
  global $objDataBase;
  $q = $objDataBase->Ejecutar("UPDATE ".G_PREFIX."configuration SET value='".$new_value."' WHERE option_name='".$option."'");
	return $q;
}

function rb_get_user_info($User_id){
  global $objDataBase;
	$q = $objDataBase->Ejecutar('SELECT * FROM '.G_PREFIX.'users WHERE id='.$User_id);
	if($q->num_rows==0)
		return false;

	$UserArray = array();
	while($Users = $q->fetch_assoc()):
		$UserArray['id'] = $Users['id'];
		$UserArray['nickname'] = $Users['nickname'];
    $UserArray['nombrecompleto'] = $Users['nombres']." ".$Users['apellidos'];
    $UserArray['nombres'] = $Users['nombres'];
		$UserArray['apellidos'] = $Users['apellidos'];
		$UserArray['telefono_movil'] = $Users['telefono-movil'];
		$UserArray['telefono_fijo'] = $Users['telefono-fijo'];
		$UserArray['correo'] = $Users['correo'];
		$UserArray['direccion'] = $Users['direccion'];
    $UserArray['ciudad'] = $Users['ciudad'];
    $UserArray['codigo_postal'] = $Users['codigo_postal'];
    $UserArray['pais'] = $Users['pais'];
    $UserArray['photo_id'] = $Users['photo_id'];
		$UserArray['url_img'] = rb_get_img_profile($Users['id']);
		$UserArray['url'] = rb_url_link( 'user', $Users['id'] );
	endwhile;
	return $UserArray;
}

// mostrar foto de perfil
function rb_get_img_profile($user_id){
  global $objDataBase;

	$q = $objDataBase->Ejecutar("SELECT photo_id FROM ".G_PREFIX."users WHERE id=".$user_id);
	$Usuario = $q->fetch_assoc();

  $photo_user = G_SERVER."rb-admin/img/user-default.png";
  if($Usuario['photo_id'] > 0){
    $Photo = rb_get_photo_details_from_id($Usuario['photo_id']);
    $photo_user =G_SERVER."rb-media/gallery/tn/".$Photo['file_name'];
  }

  return $photo_user;

}

/* OBTIENE DATOS FILES FROM ID*/
function rb_get_photo_details_from_id($photo_id){
  $DetailsPhoto = array();

  // Si id foto es 0, retornar valores vacios
  if($photo_id==0){
    $DetailsPhoto['file_name'] = "";
    $DetailsPhoto['file_url'] = G_SERVER."rb-script/images/no_image_available.jpg";
    $DetailsPhoto['thumb_url'] = G_SERVER."rb-script/images/no_image_available.jpg";
    return $DetailsPhoto;
  }

  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE id=".$photo_id);

  // Si no existe id imagen, retornar image por defecto.
  if($q->num_rows == 0){
    $DetailsPhoto['file_url'] = G_SERVER."rb-script/images/no_image_available.jpg";
    $DetailsPhoto['thumb_url'] = G_SERVER."rb-script/images/no_image_available.jpg";
    return $DetailsPhoto;
  }

  // Si todo es correcto retorna valores de la imagen
	$Photo = $q->fetch_assoc();

  $DetailsPhoto['file_name'] = $Photo['src'];
  $DetailsPhoto['file_url'] = G_SERVER."rb-media/gallery/".$Photo['src'];
  $DetailsPhoto['thumb_url'] = G_SERVER."rb-media/gallery/tn/".$Photo['src'];
	return $DetailsPhoto;
}

function rb_photo_login($photo_id){ // logo image login (antes: rb_url_photo_from_id)
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE id=".$photo_id);
  if($q->num_rows==0) return G_SERVER."rb-admin/img/user-default.png";
  $Photos = $q->fetch_assoc();
	return G_SERVER."rb-media/gallery/".$Photos['src'];
}

function rb_favicon($photo_id){
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE id=".$photo_id);
  if($q->num_rows==0) return G_SERVER."rb-script/images/blackpyro-logo.png";
  $Photos = $q->fetch_assoc();
	return G_SERVER."rb-media/gallery/".$Photos['src'];
}

function rb_image_exists($name_img){
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$path_img = ABSPATH."rb-media/gallery/".$name_img;
	if(file_exists ($path_img)) return true;
	else return false;
}

/* MUESTRA CONTENIDO DE UNA PÁGINA EN PARTICULAR */
function rb_show_specific_page($page_id){
  global $objDataBase;

	if($page_id=="") return false;
	//$objPagina = new Paginas;

	// Probamos con Nombre_Enlace
	$qp  = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE titulo_enlace='".$page_id."'");
	if(!$qp) return false;
	$num_reg = $qp->num_rows;
	if($num_reg==0):
		//Probamos con el Id
		$qp  = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE id=".$page_id);
		if(!$qp) return false;
		//$num_reg = mysql_num_rows($qp);
	endif;

	$Pages = $qp->fetch_assoc();
	return $Pages;
}

/* FUNCION FECHAS / INICIO */
function rb_a_ddmmyyyy($yyyymmdd, $separate = "-"){
	$fec_frag = explode("-",$yyyymmdd);
	return $fec_frag[2].$separate.$fec_frag[1].$separate.$fec_frag[0];
}

function rb_a_yyyymmdd($ddmmyyyy, $separate = "-"){
	$fec_frag = explode("-",$ddmmyyyy);
	return $fec_frag[2].$separate.$fec_frag[1].$separate.$fec_frag[0];
}

// Antes rb_fecha_format
function rb_sqldate_to($sqlfecha, $format = 'd-m-Y'){ // Convierte fecha SQl (formato ingles) a fecha unix y luego a formato español.
  if($sqlfecha == "0000-00-00 00:00:00"){
    return "--";
  }
	$date_unix = strtotime($sqlfecha);
	$format_date = date($format,$date_unix);
	return $format_date;
}
/* FUNCION FECHAS / FIN */

function rb_list_files($dir){
	$files = array();
	if(@$handle = opendir($dir)) {
 		while (false !== ($file = readdir($handle))) {
 			if ($file != '.' && $file != '..') {
 				array_push($files, $file);
 			}
 		}
 		closedir($handle);
		return $files;
	}else {
 		return 'ERROR: No se ha localizado el directorio $dir';
	}
}

function rb_get_images_from_gallery($album_id, $limit = 0){
  global $objDataBase;
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$rm_url = G_SERVER;

	if(empty($album_id)) return false;
	// Probamos con Nombre_Enlace
  $q_link = "SELECT id FROM ".G_PREFIX."galleries WHERE nombre_enlace='".$album_id."'";
	$qg = $objDataBase->Ejecutar($q_link);
	$num_reg = $qg->num_rows;
	if($num_reg==0):
		//Probamos con el Id
		$qg = $objDataBase->Ejecutar("SELECT id FROM ".G_PREFIX."galleries WHERE id='$album_id'");
		$num_reg = $qg->num_rows;
	endif;
  if($limit > 0 ){
    $limit_filter = " LIMIT ".$limit;
  }else{
    $limit_filter = " ";
  }
	if($qg && $num_reg > 0 ):
		$rg = $qg->fetch_assoc();
		$album_id = $rg['id'];
    $q = "SELECT * FROM ".G_PREFIX."files WHERE album_id=".$album_id." ORDER BY orden ".$limit_filter;
		$qp = $objDataBase->Ejecutar( $q );

		$FotosArray = array();
		$i=0;
		while($Fotos = $qp->fetch_assoc()):
			$FotosArray[$i]['id'] = $Fotos['id'];
      $FotosArray[$i]['title'] = $Fotos['title'];
			$FotosArray[$i]['description'] = $Fotos['description'];
			$FotosArray[$i]['tipo'] = $Fotos['tipo'];
			$FotosArray[$i]['url_max'] = $rm_url.'rb-media/gallery/'.$Fotos['src'];
			$FotosArray[$i]['url_min'] = $rm_url.'rb-media/gallery/tn/'.$Fotos['src'];
			$FotosArray[$i]['class'] = "";
			switch($FotosArray[$i]['tipo']){
				case '':
					$FotosArray[$i]['goto_url'] = $rm_url.'rb-media/gallery/'.$Fotos['src'];
					break;
				case 'fac':
					$FotosArray[$i]['goto_url'] = G_SERVER."rb-script/modules/rb-faceplayer/show.php?fbUrlVideo=".$Fotos['url'];
					$FotosArray[$i]['class'] = "fancybox.ajax";
					break;
				case 'you':
					$FotosArray[$i]['goto_url'] = "https://www.youtube.com/embed/".$Fotos['url'];
					$FotosArray[$i]['class'] = "fancybox.iframe";
					break;
				default:
					$FotosArray[$i]['goto_url'] = rb_url_link( $Fotos['tipo'] , $Fotos['url'] );
			}

			$i++;
		endwhile;
		return $FotosArray;
	else:
		return false;
	endif;
}

/*function rb_get_num_comments_by_post_id($articulo_id){
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT id FROM comentarios WHERE articulo_id=".$articulo_id);
	return $q->num_rows;
}*/

/* LA FUNCION DEVUELVE LA RUTA COMPLETA DE LA IMAGEN DE PORTADA DE CADA PUBLICACION */
function rb_get_url_image($article_id, $size = "m", $section = "portada", $showImgAlt = false){
	require_once( dirname( dirname(__FILE__) ) ."/global.php");

	$url = G_SERVER;
	$dir_media = "rb-media";

	if($size=="m"):
		$dir = "tn/";
	elseif($size=="l"):
		$dir = "";
	endif;

	if( rb_select_object_publication( $section, $article_id ) ){
		$file = rb_select_object_publication( $section, $article_id );
		$url_img = $url.$dir_media."/gallery/".$dir.rawurlencode($file); //rawurlencode - convierte espacio en %20 para ubicarlos en el servidor
		$path_img = ABSPATH.$dir_media."/gallery/".$dir.$file;
		if(file_exists ($path_img)):
			return $url_img;
		else:
			return G_SERVER."rb-script/images/gallery-default.jpg";
		endif;
	}else{
		return G_SERVER."rb-script/images/gallery-default.jpg";
	}
}

/* LA FUNCION GENERA EL LINK DE ACUERDO A LA SECCION
 * Y EL ID (PUEDE SER CATEGORIA, PUBLICACION O PAGINA )*/
function rb_url_link($section, $id, $page=0){
  global $objDataBase;
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	// obtener variables globales
	$url_web = G_SERVER;
	$link_friendly = G_ENL_AMIG;
	switch($section){
		case "pag":
			// Consultamos por -titulo-id
			$q  = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE titulo_enlace='".$id."'");
			if(!$q) return false;
			$num_reg = $q->num_rows;
			if($num_reg==0):
				// Consultamos por -id
				$q  = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE id=".$id);
				if(!$q) return false;
				$num_reg = $q->num_rows;
			endif;
			$r = $q->fetch_assoc();

			if($link_friendly){
				$name_link = $r['titulo_enlace'];
				return $url_web.$name_link."/";
			}else{
				return $url_web."?p=".$r['id'];
			}
			break;
		case "user":
				return $url_web."?user=".$id;
			break;
		case "per":
			return rb_BBCodeToGlobalVariable($id);
			break;
    default:
      return "#";
	}
}

/*
La funcion extrae un fragmento de texto del contenido del post.
*/
function rb_fragment_text($cadena, $longitud, $html=true, $elipsis = "..."){ /* palabras por defecto */
	// Antes resumen
	if(!$html){
		$cadena =  strip_tags($cadena); // Si HTML es falso, no incluira etiquetas HTML
		$cadena = preg_replace('[\n|\r|\n\r]', '', $cadena);
	}
	$palabras = explode(' ', $cadena);
	if (count($palabras) > $longitud)
		return implode(' ', array_slice($palabras, 0, $longitud)) . $elipsis;
	else
		return $cadena;
}
function rb_fragment_letters($cadena, $longitud, $elipsis = "..."){
	// Antes resumen_letras

	$letras = strlen($cadena);
	if ($letras > $longitud)
		return substr($cadena, 0, $longitud). $elipsis;
	else
		return $cadena;
}
/*
 * function thanks!
 * by http://wizardinternetsolutions.com/articles/web-programming/dynamic-multilevel-css-menu-php-mysql
 *
*/
function rb_path_menu($menu_id){
  global $objDataBase;
	if($menu_id==0) return false;
	$q = $objDataBase->Ejecutar("SELECT * FROM menus_items WHERE id=$menu_id");
	$Menu = $q->fetch_assoc();
	rb_path_menu($Menu['menu_id']);
	echo $Menu['nombre']."/";
}

//function rb_display_menu($mainmenu_id, $parent=0, $level=0, $item_selected="") { // ANTES display_childrenv- linea original
function rb_display_menu($mainmenu_id, $params = array()) {
  //$button_show = array_key_exists('params', $params) ? $params['button_show'] : 0;
  $button_close = array_key_exists('button_close', $params) ? $params['button_close'] : false;
  $parent = array_key_exists('parent', $params) ? $params['parent'] : 0;
  $level = array_key_exists('level', $params) ? $params['level'] : 0;
  $item_selected = array_key_exists('item_selected', $params) ? $params['item_selected'] : "";

  global $objDataBase;
  $result = $objDataBase->Ejecutar("SELECT a.style, a.id, a.nombre, a.url, a.tipo, Deriv1.Count FROM `menus_items` a
    LEFT OUTER JOIN (SELECT menu_id, COUNT(*) AS Count FROM `menus_items` GROUP BY menu_id) Deriv1 ON a.id = Deriv1.menu_id
    WHERE a.menu_id=". $parent." AND mainmenu_id=".$mainmenu_id. " ORDER BY id");
  $style_menu = " class='navbar-nav' ";
  $style_parent = "";

  /*if($button_show==1){
    echo '<a href="#" class="menu_show">Show Menu</a>';
  }*/
  if($parent ==0 && $level ==1) $style_parent = " class=\"parent\"";
	if($parent >0 && $level > 0) $style_menu = " class=\"navbar-dropdown\"";
    echo "\n<ul".$style_menu.">\n";
    while ($row = $result->fetch_assoc()): //mysql_fetch_assoc($result)
      $tipo = trim($row['tipo']);
      $id = ($row['style']== "" ? $row['id'] : $row['style']);
      $style_selected = ($item_selected == isset($row['style']) ? " class=\"selected\"" : "");

      if ($row['Count'] > 0) {
        if($level > 1 ) $style_parent = " class=\"parent\"";
        echo "<li id='".$id."-li'><a id='".$id."' class='".$id."' ".$style_parent.$style_selected." href='" . rb_url_link($tipo, $row['url'])  . "'><span>" . $row['nombre'] . "</span></a>";
        rb_display_menu($mainmenu_id, array('parent' => $row['id'], 'level' => $level + 1, 'item_selected' => $item_selected) );
        echo "</li>\n";
        $style_parent = "";
      }elseif ($row['Count']==0) {
        echo "<li id='".$id."-li'><a id='".$id."' class='".$id."' ".$style_parent.$style_selected." href='" .rb_url_link($tipo, $row['url']) . "'><span>" . $row['nombre'] . "</span></a></li>\n";
      }//else;
    endwhile;
    if($button_close){
      echo '<li class="menu_close"><a href="#">Cerrar</a></li>';
    }
    echo "</ul>\n";
}

function rb_numadia($num){
	switch($num){
		case 1:
			return "Lunes";
			break;
		case 2:
			return "Martes";
			break;
		case 3:
			return "Miercoles";
			break;
		case 4:
			return "Jueves";
			break;
		case 5:
			return "Viernes";
			break;
		case 6:
			return "Sabado";
			break;
    case 7:
  		return "Domingo";
  		break;
	}
}
function rb_mes_nombre($num){
	switch($num){
		case 1:
			return "Enero";
			break;
		case 2:
			return "Febrero";
			break;
		case 3:
			return "Marzo";
			break;
		case 4:
			return "Abril";
			break;
		case 5:
			return "Mayo";
			break;
		case 6:
			return "Junio";
			break;
		case 7:
			return "Julio";
			break;
		case 8:
			return "Agosto";
			break;
		case 9:
			return "Septiembre";
			break;
		case 10:
			return "Octubre";
			break;
		case 11:
			return "Noviembre";
			break;
		case 12:
			return "Diciembre";
			break;
	}
}
function rb_cambiar_nombre($url) {
	$url = utf8_decode($url);

	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ','Á', 'É', 'Í', 'Ó', 'Ú', 'ü', 'Ü', 'Ñ',"Ã¡","Ã©","Ã­","Ã³","Ãº","Ã±","Ã","Ã","Ã","Ã","Ã","Ã","Ã¼","Ã");
	$repl = array('a', 'e', 'i', 'o', 'u', 'n','a', 'e', 'i', 'o', 'u', 'u', 'u', 'n','a', 'e', 'i', 'o', 'u', 'n','a', 'e', 'i', 'o', 'u', 'n', 'u', 'U');
	$url = str_replace ($find, $repl, $url);

	// Tranformamos todo a minusculas
	$url = strtolower($url);

	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);

	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);

	return $url;
}

function rb_createThumbnail($original_file, $path_to_thumbs_directory, $path_to_image_directory,$final_width_of_image=100) {
  require_once( dirname( dirname(__FILE__) ) ."/global.php");

		$destination_file = $path_to_thumbs_directory.$original_file;
		$original_file = $path_to_image_directory.$original_file;

		$height = empty(G_THEIGHT) ? "190" : strval(G_THEIGHT); //"190";
		$width = empty(G_TWIDTH) ? "280" : strval(G_TWIDTH); //"280";

		// get width and height of original image
		$imagedata = getimagesize($original_file);
		$original_width = $imagedata[0];
		$original_height = $imagedata[1];

		if($original_width > $original_height){
			$new_height = $height; // $square_size;
			$new_width = $new_height*($original_width/$original_height);
		}
		if($original_height > $original_width){
			$new_width = $width; //$square_size;
			$new_height = $new_width*($original_height/$original_width);
		}
		if($original_height == $original_width){
			if($width > $height){
				$new_width = $width;
				$new_height = $new_width;
			}
			if($height > $width){
				$new_height = $height;
				$new_width = $new_height;
			}
			if($width == $height){
				$new_height = $height;
				$new_width = $width;
			}
			//$new_width = $width; //$square_size;
			//$new_height = $height; //$square_size;
		}

		$new_width = round($new_width);
		$new_height = round($new_height);

		// load the image
		if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")){
			$original_image = imagecreatefromjpeg($original_file);
		}
		if(substr_count(strtolower($original_file), ".gif")){
			$original_image = imagecreatefromgif($original_file);
		}
		if(substr_count(strtolower($original_file), ".png")){
			$original_image = imagecreatefrompng($original_file);
		}

		$smaller_image = imagecreatetruecolor($new_width, $new_height);
		imagealphablending($smaller_image, false);
		imagesavealpha($smaller_image, true);
		//$square_image = imagecreatetruecolor($square_size, $square_size);
		$square_image = imagecreatetruecolor($width, $height); // cuadro de corte
		imagealphablending($square_image, false);
		imagesavealpha($square_image, true);

		imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

		if($new_width>$new_height){
			$difference = $new_width-$new_height;
			$half_difference =  round($difference/2);
			//imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
			imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $width+$difference, $height, $new_width, $new_height);
		}
		if($new_height>$new_width){
			$difference = $new_height-$new_width;
			$half_difference =  round($difference/2);
			//imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
			imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $width, $height+$difference, $new_width, $new_height);
		}
		if($new_height == $new_width){
			//imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
			if($new_height > $height){
				$difference = $new_height-$height;
				$half_difference =  round($difference/2);
				imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $width, $height+$difference, $new_width, $new_height);
			}
			if($new_width > $width){
				$difference = $new_width-$width;
				$half_difference =  round($difference/2);
				imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $width+$difference, $height, $new_width, $new_height);
			}

			if($new_height == $height && $new_width == $width){
				$difference = 0;
				$half_difference =  round($difference/2);
				imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $width, $height, $new_width, $new_height);
			}
			//imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $width, $height, $new_width, $new_height);
		}

		// if no destination file was given then display a png
		if(!$destination_file){
			imagepng($square_image,NULL,9);
		}

		// save the smaller image FILE if destination file given
		if(substr_count(strtolower($destination_file), ".jpg")){
			imagejpeg($square_image,$destination_file,100);
		}
		if(substr_count(strtolower($destination_file), ".jpeg")){
			imagejpeg($square_image,$destination_file,100);
		}
		if(substr_count(strtolower($destination_file), ".gif")){
			imagegif($square_image,$destination_file);
		}
		if(substr_count(strtolower($destination_file), ".png")){
			imagepng($square_image,$destination_file,9);
		}

		imagedestroy($original_image);
		imagedestroy($smaller_image);
		imagedestroy($square_image);

    return true;
}


function rb_compress($source, $destination) {
	$info = getimagesize($source);

	switch($info['mime']){
			case "image/png":
					$src = imagecreatefrompng($source);
			break;
			case "image/jpeg":
			case "image/jpg":
					$src = imagecreatefromjpeg($source);
			break;
			case "image/gif":
					$src = imagecreatefromgif($source);
			break;
			default:
					$src = imagecreatefromjpeg($source);
			break;
	}

	switch($info['mime']){
			case "image/png":
					imagepng($src, $destination, 6); //Nivel de compresión: desde 0 (sin compresión) hasta 9.
			break;
			case "image/jpeg":
			case "image/jpg":
					imagejpeg($src, $destination, 80);
			break;
			case "image/gif":
					imagegif($src, $destination);
			break;
			default:
					imagejpeg($src, $destination, 80);
			break;
	}

	return $destination;
}

function rb_BBCodeToGlobalVariable($texto,$id=1){
  global $objDataBase, $bb_codes, $bb_htmls;

  // BBcode personalizados de los modulos externos
  $custom_bbcode = [];
  foreach ($bb_codes as $key => $value) {
    $params = $value['params'];
    $params_string = "";
    foreach ($params as $param => $value) {
      $params_string .= " ".$value."=\"(.*?)\"";
    }
    array_push($custom_bbcode, "/\[".$key.$params_string."]/is");
  }

  // Ejecucion de los bbcodes personalizados de los modulos
  $custom_bbhtml = [];
  foreach ($bb_codes as $key => $value) {
    $params = $value['params'];
    $func = $key;
    $html_content = do_bbcode($func, $params);
    array_push($custom_bbhtml, $html_content);
  }

  // BB codes del sistema
  $default_bb_codes = array(
		"/\[LOGUEO]/is",
    "/\[LOGUEO_PANEL]/is",
    "/\[LOGUEO_REGISTRO]/is",
    "/\[RUTA_SITIO]/is",
    "/\[RUTA_TEMA]/is",
    "/\[FECHA_DIA]/is",
    "/\[FECHA_NOMBREDIA]/is",
    "/\[FECHA_MES]/is",
    "/\[FECHA_NOMBREMES]/is",
    "/\[FECHA_ANIO]/is",
    "/\[YOUTUBE=\"(.*?)\"]/is",
    "/\[MAPA coordenadas=\"(.*?)\" altura=\"(.*?)\"]/is"
	);

	$acceso = '<a href="'.G_SERVER.'login.php">Ingresar</a>';
	if(G_ACCESOUSUARIO==1){
		$acceso = '¡Bienvenido! <a href="'.G_SERVER.'login.php?out">Cerrar sesión</a>';
	}

  if(G_USERTYPE=="admin"){
    $panel = '<a href="'.G_SERVER.'rb-admin">Gestionar el sitio</a> ';
  }

  $acceso_panel = '<a href="'.G_SERVER.'login.php">Ingresar</a>';
  if(G_ACCESOUSUARIO==1){
    $acceso_panel = $panel. '<a href="'.G_SERVER.'login.php?out">Cerrar sesión</a>';
  }

  $acceso_reg = '<a href="'.G_SERVER.'login.php">Ingresar</a> / <a href="'.G_SERVER.'login.php?reg">Registrarse</a>';
	if(G_ACCESOUSUARIO==1){
		$acceso_reg = '<a href="'.G_SERVER.'?pa=panel">Panel usuario</a> / <a href="'.G_SERVER.'login.php?out">Cerrar sesión</a>';
	}

  // Ejecucion de los bbcodes del sistema
  $default_bb_htmls = array(
		$acceso,
    $acceso_panel,
    $acceso_reg,
    G_SERVER,
    G_URLTHEME,
    date("j"),
    rb_numadia(date("N")),
    date("n"),
    rb_mes_nombre(date("n")),
    date('Y'),
    '<iframe class="img-responsive" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
    '<iframe frameborder="0" height="$2" src="'.G_SERVER.'rb-script/map.php?ubicacion='.G_TITULO.'&coordenadas=$1&alto=$2" class="img-responsive"></iframe>'
  );

  // Combinamos arrays nuevos y los por defecto del sistema
  $newbb_codes = array_merge($default_bb_codes, $custom_bbcode);
  $newbb_htmls = array_merge($default_bb_htmls, $custom_bbhtml);

  $texto = preg_replace($newbb_codes, $newbb_htmls, $texto);
  return $texto;
}

function rb_showvisiblename($acceso){
	switch($acceso):
		case "privat":
			return "Privado (con login)"; break;
		case "public":
			return "Publico (no requiere login)"; break;
	endswitch;
}
// Retorna nombre del nivel de usuario
function rb_shownivelname($nivel_id){
	global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT nombre FROM ".G_PREFIX."users_levels WHERE id = ".$nivel_id);
	$r = $q->fetch_assoc();
	return $r['nombre'];
}
// Retorna un array con los datos del nivel de usuario
function rb_show_nivel_data($nivel_id){
	global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_levels WHERE id = ".$nivel_id);
	$r = $q->fetch_assoc();
	return $r;
}

function rb_niveltoname($niveles){
	if($niveles=="") return "";
	$array_niveles = explode(',', trim($niveles));
	$num_array = count($array_niveles);
	$string = "";
	$coma = "";
	$i=0;
	while($i<$num_array){
		$string .=$coma.rb_shownivelname(trim($array_niveles[$i]));
		$coma= ", ";
		$i++;
	}
	return $string;
}

function rb_file_type($type){ //Antes File_Type 27-9-16:  pasa tipo de archivo capturado de archivo subido y compara para mostrar nombre mas conocido, usado para mce_tiny al seleccionar image o file
	switch($type){
		case "application/vnd.ms-excel":
		case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
			return "excel";
			break;
		case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
		case "application/msword":
			return "word";
			break;
		case "application/pdf":
			return "pdf";
			break;
		case "image/png":
		case "image/jpeg":
		case "image/gif":
			return "image";
			break;
		default:
			return "desconocido";
	}
}

function rb_list_themes($dir,$dirselec){ //antes listar_directorios();
	if(@$handle = opendir($dir)) {
 		while (false !== ($file = readdir($handle))) {
 			if ($file != '.' && $file != '..') {
				if($file==$dirselec) $selected="selected=\"selected\"";
				else $selected="";
 				echo "<option $selected>$file</option>";
 			}
 		}
 		closedir($handle);
	}else {
 		echo 'ERROR: No se ha localizado el directorio $dir';
	}
}

/*
 * Funciones relacionadas con la generacion del Menu del Panel de Administraccion:
 *
 * */

/* Crear la estructura visual en HTML del Menu del Panel
 * Parametros:
 * 		@menu_panel = Array que contiene el la estructura del menu.
 * 		@subitem_selected = Item hijo seleccionado, para que se pinte de otro color.
 * 		@item_selected = Item padre seleccionado, para que se despliegue y se pinte de otro color.
 *
 * Devuelve:
 * 		Toda una estructura en HTML con elementos LI y UL.
 * */

function rb_show_menu($menu_panel, $subitem_selected="0", $item_selected="index"){
	//echo "<ul>";
	foreach ($menu_panel as $menu => $item) {
		$style_parent_css = "";
		$cover_parent_item = ' class="menu-item" ';
		if($item['show']==false) continue;
    if(isset($item['extend']) && $item['extend']==true){
      $style_parent_css = ' class="selected-parent" ';
			$cover_parent_item = "";
    }
		if($item['key']==$item_selected){
			$style_parent_css = ' class="selected-parent" ';
			$cover_parent_item = "";
		}
		echo '<li '.$style_parent_css.'>';
		echo '<a '.$cover_parent_item.' href="'.$item['url'].'">';
		echo '<img class="img-icon-menu" src="'.$item['url_imagen'].'" alt="Icon Menu">';
		echo '<span class="text">'.$item['nombre'].'</span>';
		echo '</a>';
		if( !is_null($item['item']) ){
			// De momento solo tendra 2 niveles el menu del panel
			echo '<ul class="hidden">';
			foreach ($item['item'] as $item => $subitem) {
				echo '<li>';
				$style_css = "";
				if($subitem['key']==$subitem_selected){
					$style_css .= 'selected ';
				}
        if(isset($subitem['css'])){
          $style_css .= $subitem['css'];
          //$style_parent_css = ' class="selected-parent" ';
    			//$cover_parent_item = "";
        }
				echo '<a id="'.$subitem['key'].'" class="'.$style_css.'" title="'.$subitem['nombre'].'" href="'.$subitem['url'].'">';
				echo '<span class="text">';
				echo $subitem['nombre'];
				echo '</span>';
				echo '</a>';
				echo '</li>
				';
			}
			echo '</ul>';
			// rb_show_menu($item['item']); -> Recursividad si fuera necesario
		}
		echo '</li>';
	}
	//echo '</ul>';
}

/* Agrega items al Menu del Panel, acepta como parametro todo un array asociativo
 * Parametros:
 * 		@array_var: Array que contiene una estructura de un item (y sus items) a añadir.
 * */
/*function rb_add_item_menu($array_var){
	global $menu_panel;
	array_push($menu_panel, $array_var );
}*/

/* Agrega subitems a los items del Menu del Panel, acepta como parametro key del item-padre y un array con valores del subitem
 * Parametros:
 * 		@$item_padre: Key del elemento padre
 * 		@$data: Array con valors del nuevo subitem
 * */
function rb_add_specific_item_menu($item_padre, $data){
	global $menu_panel;
  if(isset($menu_panel)) array_push($menu_panel[$item_padre]['item'], $data );
}

/* Busca dentro del Menu del Panel (en cada menu hijo), el modulo que se activara cuando el menu este desplegado
 * Parametros:
 * 		@menu_panel: Array que contiene la estructura del menu
 * 		@value_search: Subitem a buscar dentro de los elementos hijos
 *
 * Devuelve:
 * 		El identificador del item padre, caso contrario "index"
 * */
function rb_action_menu($menu_panel, $value_search){
	foreach($menu_panel as $menu_key => $menu_value) {
		if( !is_null($menu_value['item']) ){ // Si contiene sub elementos
			foreach ($menu_value['item'] as $subitem_key => $subitem_value) {
        		if($subitem_value['key'] == $value_search) return $menu_value['key'];
        	}
        }
    }
    return "index";
}

/* Genera la estructura del Menu del Panel por "defecto", se pueden agregar.
 *
 * Devuelve:
 * 		Un array con toda la estructura inicial del menu del panel admin.
 *
 * */
function rb_menu_panel(){
	$menu_panel =  array(
					'index' => array(
						'key' => 'index',
						'nombre' => "Inicio",
						'url' => "index.php",
						'url_imagen' => "img/icon_home.png",
						'pos' => 1,
						'show' => true,
						'item' => NULL
					),
					'blogs' => array(
						'key' => 'blogs',
						'nombre' => "Blog",
						'url' => "#",
						'url_imagen' => "img/icon_post.png",
						'pos' => 2,
						'show' => true,
						'item' => array(
							array(
								'key' => 'art',
								'nombre' => "Publicaciones",
								'url' => "index.php?pag=art",
								'url_imagen' => "none",
								'pos' => 1,
							),
							array(
								'key' => 'cat',
								'nombre' => "Categorias",
								'url' => "index.php?pag=cat",
								'url_imagen' => "none",
								'pos' => 1,
							),
							array(
								'key' => 'com',
								'nombre' => "Comentarios",
								'url' => "index.php?pag=com",
								'url_imagen' => "none",
								'pos' => 1,
							)
						)
					),
					'files' => array(
						'key' => 'files',
						'nombre' => "Archivos",
						'url' => "#",
						'url_imagen' => "img/icon_media.png",
						'pos' => 3,
						'show' => true,
						'item' => array(
							'0' => array(
								'key' => 'files',
								'nombre' => "Explorar",
								'url' => "index.php?pag=files",
								'url_imagen' => "none",
								'pos' => 1,
							),
							'1' => array(
								'key' => 'gal',
								'nombre' => "Galeria y/o Album",
								'url' => "index.php?pag=gal",
								'url_imagen' => "none",
								'pos' => 1,
							)
						)
					),
					'users' => array(
						'key' => 'users',
						'nombre' => "Usuarios",
						'url' => "#",
						'url_imagen' => "img/icon_user.png",
						'pos' => 4,
						'show' => true,
						'item' => array(
							'0' => array(
								'key' => 'usu',
								'nombre' => "Gestionar",
								'url' => "index.php?pag=usu",
								'url_imagen' => "none",
								'pos' => 1,
							),
							'2' => array(
								'key' => 'men',
								'nombre' => "Mensajeria",
								'url' => "index.php?pag=men",
								'url_imagen' => "none",
								'pos' => 1,
							),
							'3' => array(
								'key' => 'nivel',
								'nombre' => "Niveles de acceso",
								'url' => "index.php?pag=nivel",
								'url_imagen' => "none",
								'pos' => 1,
							)
						)
					),
					'visual' => array(
						'key' => 'visual',
						'nombre' => "Contenidos y Estructuras",
						'url' => "#",
						'url_imagen' => "img/icon_design.png",
						'pos' => 5,
						'show' => true,
						'item' => array(
              '0' => array(
								'key' => 'pages',
								'nombre' => "Paginas",
								'url' => "index.php?pag=pages",
								'url_imagen' => "none",
								'pos' => 1,
							),
							'1' => array(
								'key' => 'menus',
								'nombre' => "Menus",
								'url' => "index.php?pag=menus",
								'url_imagen' => "none",
								'pos' => 1,
							),
							'2' => array(
								'key' => 'editfile',
								'nombre' => "Plantillas",
								'url' => "index.php?pag=editfile",
								'url_imagen' => "none",
								'pos' => 1,
							)
						)
					)
				);

	// reemplaza el contenido de iten
	/*$menu_panel['contents']['item'][3] =  array(
			'key' => 'com',
			'nombre' => "Comentarios",
			'url' => "index.php?pag=com",
			'url_imagen' => "none",
			'pos' => 1,

	);*/
	return $menu_panel;
}

/* Informacion de una galeria o album de imagenes */

function rb_get_info_gallery($album_id){
  global $objDataBase;
  $rm_url = G_SERVER;
	if($album_id=="") return false;
	$qg = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."galleries WHERE nombre_enlace='$album_id'");
	$num_reg = $qg->num_rows;
	if($num_reg==0):
		$qg = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."galleries WHERE id=".$album_id);
		$num_reg = $qg->num_rows;
    if($num_reg==0) return false;
	endif;

  $GaleriasArray = Array();
	while($Galerias = $qg->fetch_assoc()):
			$GaleriasArray['id'] = $Galerias['id'];
			$GaleriasArray['nombre'] = $Galerias['nombre'];
			$GaleriasArray['nombre_enlace'] = $Galerias['nombre_enlace'];
			$GaleriasArray['usuario_id'] = $Galerias['usuario_id'];
			$GaleriasArray['galeria_grupo'] = $Galerias['galeria_grupo'];
      $GaleriasArray['private'] = $Galerias['private'];
      
    	if($Galerias['photo_id']==0):
    		$GaleriasArray['url_bgimage'] = G_SERVER."rb-script/images/gallery-default.jpg";
        $GaleriasArray['url_bgimagetn'] = G_SERVER."rb-script/images/gallery-default.jpg";
    	else:
        $photos = rb_get_photo_details_from_id($Galerias['photo_id']);
    		$GaleriasArray['url_bgimage'] = G_SERVER."rb-media/gallery/".$photos['file_name'];
        $GaleriasArray['url_bgimagetn'] = G_SERVER."rb-media/gallery/tn/".$photos['file_name'];
    	endif;
	endwhile;
	return $GaleriasArray;
}

/* Lista las galerias de la base de datos
 * Parametros:
 * 		@limitar cantidad a mostrar
 *    @groupname mostrar un grupo en particular
 * */
function rb_list_galleries($limit=0, $groupname=""){
	global $objDataBase;

  $add_limit = "";
  if($limit>0){
    $add_limit = " LIMIT ".$limit;
  }
  if(empty($groupname)){
      $q= $objDataBase->Ejecutar("SELECT a.*, (
				SELECT COUNT( id )
				FROM ".G_PREFIX."files
				WHERE album_id = a.id
      ) AS nrophotos FROM ".G_PREFIX."galleries a ORDER BY fecha DESC".$add_limit);
  }else{
      $q= $objDataBase->Ejecutar("SELECT a.*, (
				SELECT COUNT( id )
				FROM ".G_PREFIX."files
				WHERE album_id = a.id
      ) AS nrophotos FROM ".G_PREFIX."galleries a WHERE galeria_grupo='".$groupname."' ORDER BY fecha DESC".$add_limit);
  }
  $GaleriasArray = Array();
  //$FotosArray = array();
	$i=0;
	while($Galerias = $q->fetch_assoc()):
			$GaleriasArray[$i]['id'] = $Galerias['id'];
			$GaleriasArray[$i]['nombre'] = $Galerias['nombre'];
      $GaleriasArray[$i]['fecha'] = $Galerias['fecha'];
      $GaleriasArray[$i]['descripcion'] = $Galerias['descripcion'];
			$GaleriasArray[$i]['nombre_enlace'] = $Galerias['nombre_enlace'];
			$GaleriasArray[$i]['usuario_id'] = $Galerias['usuario_id'];
			$GaleriasArray[$i]['galeria_grupo'] = $Galerias['galeria_grupo'];
			$GaleriasArray[$i]['nrophotos'] = $Galerias['nrophotos'];

      if($Galerias['photo_id']==0):
        $GaleriasArray[$i]['url_bgimage'] = G_SERVER."rb-script/images/gallery-default.jpg";
        $GaleriasArray[$i]['url_bgimagetn'] = G_SERVER."rb-script/images/gallery-default.jpg";
      else:
        $photos = rb_get_photo_details_from_id($Galerias['photo_id']);

        $GaleriasArray[$i]['url_bgimage'] = G_SERVER."rb-media/gallery/".$photos['file_name'];
        $GaleriasArray[$i]['url_bgimagetn'] = G_SERVER."rb-media/gallery/tn/".$photos['file_name'];
      endif;
		$i++;
	endwhile;
	return $GaleriasArray;
}

function rb_show_bar_admin(){
  require_once( dirname( dirname(__FILE__) ) ."/global.php");
  if(G_ACCESOUSUARIO==1):
    echo '<div class="wrap-content wrap-content-bar-admin"><div class="inner-content inner-content-bar-admin">
      Hola, tienes iniciado el gestor de contenido. <a href="'.G_SERVER.'rb-admin/">Admistrarlo</a>. <a href="'.G_SERVER.'login.php?out">Cerrar Session</a>.
    </div></div>';
  endif;
}

function rb_show_block($box, $type="page"){ //Muestra bloque
  global $objDataBase;
  global $widgets;
  if(isset($box['box_save_id'])){
    $box_save_id = $box['box_save_id'];
  }else{
    $box_save_id = 0;
  }

  if($box_save_id > 0){
    //$box_save_id = $box['box_save_id'];
    // Consultar los datos del bloque
    $qb = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages_blocks WHERE id=".$box_save_id);
    $boxsave = $qb->fetch_assoc();
    $box = json_decode($boxsave['contenido'], true);
    /*$box_saved_css = " saved";
    $box_save_title = '<span class="box-save-title">'.$boxsave['nombre'].'</span>';*/
  }else{
    $box_save_id = 0;
    /*$box_saved_css = "";
    $box_save_title = '<a href="#" class="SaveBox"><i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar</a><span class="box-save-title"></span>';*/
  }

  //Bloque externo
  $ext_class = isset($box['boxext_class']) && $box['boxext_class']!="" ? $box['boxext_class'] : "";
  $ext_parallax = isset($box['boxext_values']['extparallax']) && $box['boxext_values']['extparallax']!="" ? $box['boxext_values']['extparallax'] : "";
  $style_extbgcolor = isset($box['boxext_values']['bgcolor']) && $box['boxext_values']['bgcolor']!="" ? "background-color:#".$box['boxext_values']['bgcolor'].";" : "";
  if(isset($box['boxext_values']['bgimage'])) $file = rb_get_photo_details_from_id($box['boxext_values']['bgimage']);
  //$file['file_url'];
  $style_extbgimage = isset($box['boxext_values']['bgimage']) && $box['boxext_values']['bgimage']!="" ? "background-image:url(".$file['file_url'].");background-position:center;background-size:cover;" : "";
  $style_extpaddingtop = isset($box['boxext_values']['paddingtop']) && $box['boxext_values']['paddingtop']!="" ? "padding-top:".$box['boxext_values']['paddingtop'].";" : "";
  $style_extpaddingright = isset($box['boxext_values']['paddingright']) && $box['boxext_values']['paddingright']!="" ? "padding-right:".$box['boxext_values']['paddingright'].";" : "";
  $style_extpaddingbottom = isset($box['boxext_values']['paddingbottom']) && $box['boxext_values']['paddingbottom']!="" ? "padding-bottom:".$box['boxext_values']['paddingbottom'].";" : "";
  $style_extpaddingleft = isset($box['boxext_values']['paddingleft']) && $box['boxext_values']['paddingleft']!="" ? "padding-left:".$box['boxext_values']['paddingleft'].";" : "";

  //Parallax
  if($ext_parallax==1){
    $ext_class .= " parallax-window";
    $addons = ' data-parallax="scroll" data-image-src="'.$file['file_url'].'" ';
    $styles_ext = $style_extbgcolor.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
  //Estilos
  }elseif($ext_parallax==0){
    $styles_ext = $style_extbgcolor.$style_extbgimage.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
    $addons = '';
  }

  if($type=="page") echo '<div class="clear '.$ext_class.'" style="'.$styles_ext.'" '.$addons.'>'; // start outer box
  //BLoque interno
  $default_class = "inner-content"; // default
  $style_inwidth = ""; // default
  if(isset($box['boxin_values']['width']) && $box['boxin_values']['width']=="yes"){
    $default_class = "full-content ";
    $style_inwidth = "";
  }elseif(isset($box['boxin_values']['width']) && $box['boxin_values']['width']!="yes" && $box['boxin_values']['width']!=""){
    $default_class = "inner-content";
    $style_inwidth = "width:".$box['boxin_values']['width'].";margin:0 auto;";
  }elseif(isset($box['boxin_values']['width']) && $box['boxin_values']['width']==""){
    $default_class = "inner-content ";
    $style_inwidth = "";
  }
  $in_class = isset($box['boxin_class']) && $box['boxin_class']!="" ? $box['boxin_class'] : "";
  $style_inbgcolor = isset($box['boxin_values']['bgcolor']) && $box['boxin_values']['bgcolor']!="" ? "background-color:#".$box['boxin_values']['bgcolor'].";" : "";
  if(isset($box['boxin_values']['bgimage']))  $file = rb_get_photo_details_from_id($box['boxin_values']['bgimage']);
  $style_inbgimage = isset($box['boxin_values']['bgimage']) && $box['boxin_values']['bgimage']!="" ? "background-image:url(".$file['file_url'].");background-position:center;background-size:cover;" : "";
  $style_inheight = isset($box['boxin_values']['height']) && $box['boxin_values']['height']!="" ? "height:".$box['boxin_values']['height'].";" : "";
  $style_inpaddingtop = isset($box['boxin_values']['paddingtop']) && $box['boxin_values']['paddingtop']!="" ? "padding-top:".$box['boxin_values']['paddingtop'].";" : "";
  $style_inpaddingright = isset($box['boxin_values']['paddingright']) && $box['boxin_values']['paddingright']!="" ? "padding-right:".$box['boxin_values']['paddingright'].";" : "";
  $style_inpaddingbottom = isset($box['boxin_values']['paddingbottom']) && $box['boxin_values']['paddingbottom']!="" ? "padding-bottom:".$box['boxin_values']['paddingbottom'].";" : "";
  $style_inpaddingleft = isset($box['boxin_values']['paddingleft']) && $box['boxin_values']['paddingleft']!="" ? "padding-left:".$box['boxin_values']['paddingleft'].";" : "";

  $styles_in = $style_inheight.$style_inbgcolor.$style_inbgimage.$style_inpaddingtop.$style_inpaddingright.$style_inpaddingbottom.$style_inpaddingleft.$style_inwidth;

  if($type=="page") echo '<div class="'.$default_class.$in_class.' clear" style="'.$styles_in.'">'; // start inner box
  if($type=="sidebar") echo '<div class="box'.$in_class.' clear" style="'.$styles_in.'">';
  echo '<div class="cols">'; // start cols
  $array_cols =$box['columns'];
  foreach ($array_cols as $col):
    $col_class = "";
    if(isset($col['col_class'])){
      $col_class = " ".$col['col_class'];
    }
    echo '<div class="col'.$col_class.'">';
    // Widgets
    $array_widgets =$col['widgets'];
    foreach ($array_widgets as $widget) {
      if(isset($widget['widget_save_id']) && $widget['widget_save_id']!="0"){
        $block_id = $widget['widget_save_id'];
        include ABSPATH.'rb-script/modules/pages.view3/widgets.customs.php'; //
      }else{
        // $widgets = array global que contiene widgets del sistema y personalizados
        $widget_type = $widget['widget_type'];
        // Recorreremos para ver si hay coincidencias
        $clave = array_search($widget_type, array_column($widgets, 'type')); // https://stackoverflow.com/questions/8102221/php-multidimensional-array-searching-find-key-by-specific-value
        //echo "<strong>".$widgets[$clave]['type']."</strong>";
        if( isset($widgets[$clave]['custom']) ){
          $dir_module = ABSPATH.'rb-script/modules/';
          include $dir_module.$widgets[$clave]['dir'].'/'.$widgets[$clave]['type'].'.frontend.php';
        }else{
          $dir_module = ABSPATH.'rb-admin/core/pages3/';
          include $dir_module.'widgets/'.$widgets[$clave]['dir'].'/'.$widgets[$clave]['type'].'.frontend.php';
        }
      }
    }
    echo '</div><!--end col or coverwidgets-->';// end col or coverwidgets
  endforeach; // end columns
  echo '</div><!--end cols-->'; //end cols
	echo '</div><!--end inner box-->'; //end inner box
  if($type=="page") echo '</div><!--end outer box-->'; //end outer box
}
/*
* Muestra la cabecera de la plantilla, por defecto el archivo se llama header.php, tambien se puede adicional algunos otros,
* los cuales se incluyen DESPUES de header.php
*/
function rb_header($add_header = array(), $page=true){
  global $show_header, $block_header_id;
  global $objDataBase;

  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname( dirname(__FILE__) ) . '/');

  require_once ABSPATH."global.php";
  include_once ABSPATH."rb-themes/".G_ESTILO."/header.php";

  if($page){
    // Si es pagina generada por el sistema
    if($show_header==1){
      foreach ($add_header as $header) {
        include_once ABSPATH."rb-themes/".G_ESTILO."/".$header;
      }
    }elseif($show_header==2){
      // New version
      $Header = rb_show_specific_page($block_header_id);
      $array_content = json_decode($Header['contenido'], true);
      foreach ($array_content['boxes'] as $box) {
        rb_show_block($box);
      }
    }
  }else{
    // Si son paginas de las plantilla
    if(G_BLOCK_HEADER!="0"){
      // New version
      $Header = rb_show_specific_page(G_BLOCK_HEADER);
      $array_content = json_decode($Header['contenido'], true);
      foreach ($array_content['boxes'] as $box) {
        rb_show_block($box);
      }
    }else{
      foreach ($add_header as $header) {
        if(!file_exists(ABSPATH."rb-themes/".G_ESTILO."/".$header))
          continue;

        include_once ABSPATH."rb-themes/".G_ESTILO."/".$header;
      }
    }
  }
}

/*
* Muestra el pie de la plantilla, por defecto el archivo se llama footer.php, tambien se puede adicional algunos otros,
* los cuales se incluyen ANTES de footer.php
*/
function rb_footer($add_footer = array(), $page=true){
  global $show_footer, $block_footer_id;
  global $objDataBase;

  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname( dirname(__FILE__) ) . '/');

  require_once ABSPATH."global.php";

  if($page){
    // Si es pagina generada por el sistema
    if($show_footer==1){
      foreach ($add_footer as $footer) {
        include_once ABSPATH."rb-themes/".G_ESTILO."/".$footer;
      }
    }elseif($show_footer==2){
      // New version
      $Footer = rb_show_specific_page($block_footer_id);
      $array_content = json_decode($Footer['contenido'], true);
      foreach ($array_content['boxes'] as $box) {
        rb_show_block($box);
      }
    }
  }else{
    // Si son paginas de las plantilla
    if(G_BLOCK_FOOTER!="0"){
      // New version
      $Footer = rb_show_specific_page(G_BLOCK_FOOTER);
      $array_content = json_decode($Footer['contenido'], true);
      foreach ($array_content['boxes'] as $box) {
        rb_show_block($box);
      }
    }else{
      foreach ($add_footer as $footer) {
        if(!file_exists(ABSPATH."rb-themes/".G_ESTILO."/".$footer))
          continue;

        include_once ABSPATH."rb-themes/".G_ESTILO."/".$footer;
      }
    }
  }
  include_once ABSPATH."rb-themes/".G_ESTILO."/footer.php";
}

/*
* Muestra la columna lateral de la plantilla, por defecto el archivo se llama sidebar.php
*/
function rb_sidebar(){
  global $show_sidebar;

  if(isset($show_sidebar) && $show_sidebar==0) return false;

  print '<aside class="wrap-sidebar '.class_col_2.'">';
  /*if(count($sidebar_files)>0){
    foreach ($sidebar_files as $sidebar_file) {
      if(!file_exists($sidebar_file)) continue;
      include_once $sidebar_file;
    }
  }else{*/
    $SidebarId = rb_get_values_options('sidebar_id');
    if($SidebarId == 0) return false;

    $Sidebar = rb_show_specific_page($SidebarId);

    $array_content = json_decode($Sidebar['contenido'], true);
    foreach ($array_content['boxes'] as $box) {
      rb_show_block($box, "sidebar");
    }
  //}
  
  print '</aside>';
}

function rb_validar_mail($pMail) { // Antes validar_mail, solo usado en registro de usuario
  if (filter_var($pMail, FILTER_VALIDATE_EMAIL)) {
    return true;
  }else{
    return false;
  }
}
/*
* Guarda/Actualiza contenido de un archivo. 11-01-18
*/
function rb_write_file($file_name, $file_content){
  $handle = fopen($file_name, 'w') or die('Cannot open file:  '.$file_name);
  if(fwrite($handle, $file_content)):
  	fclose($handle);
  	return true;
  else:
    return false;
  endif;
}

/* Evitar cache */
function rb_disabled_cache(){
  header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  }

/* Pass valid */
function rb_valid_pass($pass){
  //http://w3.unpocodetodo.info/utiles/regex-ejemplos.php?type=psw
  // Update 3/1/20 https://www.imtiazepu.com/password-validation/
  if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $pass)){
    return true; // Valido
  }else{
    return false;
  }
}

/* SECURITY - SEGURIDAD */

function rb_encrypt_decrypt($action, $string, $secret_key='oW%c76+jb2', $secret_iv='A)2!u467a^') {
  //https://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt/e
  $output = false;

  $encrypt_method = "AES-256-CBC";
  /*$secret_key = 'This is my secret key';
  $secret_iv = 'This is my secret iv';*/

  // hash
  $key = hash('sha256', $secret_key);

  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);

  if( $action == 'encrypt' ) {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  }elseif( $action == 'decrypt' ){
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}

function random($length, $chars = ''){ // Genera un valor aleatorio - NO USADO AUN
	if (!$chars) {
		$chars = implode(range('a','f'));
		$chars .= implode(range('0','9'));
	}
	$shuffled = str_shuffle($chars);
	return substr($shuffled, 0, $length);
}
function randomPassword($length,$count, $characters) { // Genera un valor aleatorio para cada instalacion de Pyro CMS

// $length - the length of the generated password
// $count - number of passwords to be generated
// $characters - types of characters to be used in the password

// define variables used within the function
    $symbols = array();
    $passwords = array();
    $used_symbols = '';
    $pass = '';

// an array of different character types
    $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
    $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $symbols["numbers"] = '1234567890';
    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

    $characters = explode(",",$characters); // get characters types to be used for the passsword
    foreach ($characters as $key=>$value) {
        $used_symbols .= $symbols[$value]; // build a string with all characters
    }
    $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

    for ($p = 0; $p < $count; $p++) {
        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $symbols_length); // get a random character from the string with all characters
            $pass .= $used_symbols[$n]; // add the character to the password string
        }
        $passwords[] = $pass;
    }

    return $passwords; // return the generated password
}

function rb_shortcode($content){
  // Shortcode, es un array que contiene las funciones a ejecutar y sus parametros (por defecto vacios)
  global $shortcodes;

  // Ver shortcodes en array
  /*echo "<pre style='font-size:.6em;line-height:10px'>";
  print_r($shortcodes);
  echo "</pre>";*/

  // Si no hay shortcodes, no pasais nada
  if( count($shortcodes)==0){
    return $content;
  }

  $code = array();
  $html = array();

  /* Recorremos el array SHORTCODES para transformar cada elemento en formato BBCODE. Ej. [FORM id="2"] */
  foreach ($shortcodes as $key => $index) {
    $tag_name = $key;
    foreach ($index as $key => $value) {
      // Primero verificar si tiene parametros
      $params = $value['params'];
      $params_string = "";
      foreach ($params as $param => $value) {
        $params_string .= " ".$param."=\"".$value."\"";
      }
      array_push($code, "/\[".$tag_name.$params_string."]/is");
    }
  }

  // Ver Shortcodes en formato BBCODE
  /*echo "<pre>"; // test code and parameters
  print_r($code);
  echo "</pre>";*/

  // Recorremos nuevamente cada elemento de array $shortcodes, y pasamos la ejecucion de su funcion a array $html
  foreach ($shortcodes as $key => $index) {
    $tag_name = $key;
    foreach ($index as $key => $value) {
      // Primero verificar si tiene parametros
      $params = $value['params'];
      $func = $tag_name;
      $html_content = do_shortcode($func, $params);
      array_push($html, $html_content);
    }
  }

  // Ver la ejecucion de los Shortcodes
  /*echo "<pre>"; // test
  print_r($html);
  echo "</pre>";*/

  $content_html = preg_replace($code, $html, $content); // Reemplazamos cada key-tag, conla ejecucion de la funcion
  return $content_html;
}

function rb_generate_nickname($mail){ // Generar nickname en base a correo electronico
	global $objDataBase;

	$array_mail = explode("@", $mail);
	$user = $array_mail[0];
	$q = $objDataBase->Ejecutar("SELECT nickname FROM ".G_PREFIX."users WHERE nickname LIKE '%$user%'");
	$nums = $q->num_rows;
	if($nums>0):
		$user = $user."_".$nums;
	endif;

	return $user;
}

function rb_link_gallery($gallery_id){
  if($gallery_id==0) return;
  $photos = rb_get_images_from_gallery($gallery_id);
  $i=1;
  foreach ($photos as $photo) {
    ?>
    <a href="<?= $photo['url_max'] ?>" data-fancybox-group="album_<?= $gallery_id ?>" class="fancybox" <?php if($i>1) echo ' style="display:none"' ?>>
      <?php
      if($i>1) echo $photo['id'];
      else echo '<img src="'.$photo['url_min'].'" alt="previa" style="max-width:50px;" />';
      ?>
    </a>
    <?php
    $i++;
  }
}

function searchForId($id, $array) { // Buscar valor dentro un array multidimensional
  $response = [];
   foreach ($array as $key => $val) {
       if ($val['id'] === $id) {
         $response = ['result' => true, 'key' => $key];
           return $response;
       }
   }
   return false;
}

// Validacion de array de campos,
// parametros: u
//    un array de validacion, en formato json
//    el array de campos
function rb_validate_fields($array_validations, $array_fields){
  $keys_config = json_decode($array_validations, true); // Pasamos campos a validar en formato JSON a Array PHP
  $rspmail = [
    'result' => true
  ];
	foreach ($keys_config as $key => $value) {
		// Verificamos si el campo a validar existe
		if(array_key_exists($key, $array_fields)==false){
			$rspmail = [
				'result' => false,
				'msg' => "Campo ".$key." no existe. No podemos continuar"
			];
			//die(json_encode($rspmail));
      return $rspmail;
		}else{
			// Extraemos su configuracion de validacion
			$settings = explode("|", $value);

			// Navegamos por cada configuracion
			foreach ($settings as $setting){
				//echo $setting;
				// Si requerido esta activo
				if($setting=="req"){
					if(trim($array_fields[$key])==""){
						$rspmail = [
							'result' => false,
							'msg' => "Campo ".$key." no debe quedar vacio"
						];
						//die(json_encode($rspmail));
            return $rspmail;
					}
				}

				// Si es min esta activo
				if( substr($setting,0,3)=="min"){
					$min_config = explode("=", $setting);
					if( strlen(trim($array_fields[$key])) <= $min_config[1]){
						$rspmail = [
							'result' => false,
							'msg' => "Campo ".$key." debe tener mas de ".$min_config[1]." caracteres de longitud"
						];
						//die(json_encode($rspmail));
            return $rspmail;
					}
				}

				// Si es max esta activo
				if( substr($setting,0,3)=="max"){
					$max_config = explode("=", $setting);
					if( strlen(trim($array_fields[$key])) > $max_config[1]){
						$rspmail = [
							'result' => false,
							'msg' => "Campo ".$key." debe tener maximo ".$max_config[1]." caracteres de longitud"
						];
						//die(json_encode($rspmail));
            return $rspmail;
					}
				}
			}
		}
	}
  return $rspmail;
}
?>
