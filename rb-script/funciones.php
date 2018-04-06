<?php
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

/*function rb_header($header_template=""){ // REVISAR
  if($header_template==""){
    include_once ABSPATH.'rb-temas/'.G_ESTILO.'/header.php';
  }elseif($header_template!=""){
    include_once ABSPATH.'rb-temas/'.G_ESTILO.'/'.$header_template;
  }
}*/

/* CAPTURA CONSULTA Y ENVIA UN ARRAY CON DATOS DE LA PUBLICACION - TODA CONSULTA DE LISTADO DE POST DEBE USAR ESTA FUNCION*/
function rb_return_post_array($qa){
	$PostsArray = array();
	$i=0;
	//while($Posts = mysql_fetch_array($qa)):
  while($Posts = $qa->fetch_array(MYSQLI_ASSOC)): // funciona tbm fetch_assoc()
		$PostsArray[$i]['id'] = $Posts['id'];
    $PostsArray[$i]['titulo_id'] = $Posts['titulo_enlace'];
		$PostsArray[$i]['autor_id'] = $Posts['autor_id'];
		$PostsArray[$i]['autor_names'] = $Posts['id'];
		$PostsArray[$i]['titulo'] = $Posts['titulo'];
		$PostsArray[$i]['contenido'] = $Posts['contenido'];
		$PostsArray[$i]['video_embed'] = $Posts['video_embed'];
		$PostsArray[$i]['vistas'] = $Posts['lecturas'];
		$PostsArray[$i]['comentarios'] = rb_get_num_comments_by_post_id($Posts['id']);
		$PostsArray[$i]['url'] = rb_url_link( 'art' , $Posts['id'] );
		$PostsArray[$i]['fec_dia'] = isset( $Posts['fecha_dia'] ) ? $Posts['fecha_dia'] : "";
		$PostsArray[$i]['fec_mes'] = isset( $Posts['fecha_mes'] ) ? $Posts['fecha_mes'] : "";
		$PostsArray[$i]['fec_mes_l'] = rb_mes_nombre( isset( $Posts['fecha_mes'] ) ? $Posts['fecha_mes'] : "" );
		$PostsArray[$i]['fec_anio'] = isset( $Posts['fecha_anio'] ) ? $Posts['fecha_anio'] : "";
		$PostsArray[$i]['url_img_por_max'] = rb_get_url_image( $Posts['id'] , "l", "portada" );
		$PostsArray[$i]['url_img_por_min'] = rb_get_url_image( $Posts['id'] , "m", "portada" );
		$PostsArray[$i]['url_img_pri_max'] = rb_get_url_image( $Posts['id'] , "l", "logo" );
		$PostsArray[$i]['url_img_pri_min'] = rb_get_url_image( $Posts['id'] , "m", "logo" );
		$PostsArray[$i]['url_img_sec_max'] = rb_get_url_image( $Posts['id'] , "l", "adjunto" );
		$PostsArray[$i]['url_img_sec_min'] = rb_get_url_image( $Posts['id'] , "m", "adjunto" );
		$i++;
	endwhile;
	return $PostsArray;
}

// Grabar una entrada en la lista de registro dela db
function rb_log_register( $values ){
  global $objDataBase;
  $objDataBase->Ejecutar("INSERT INTO log (usuario_id, usuario, observacion, fecha) VALUES ( ".$values[0].",'".$values[1]."','".$values[2]."', NOW() )");
}

// La funcion retorna valor segun la opcion de la tabla opciones, que almacena los valores iniciales y generales de la web
function rb_get_values_options($option){
  global $objDataBase;
  $q = $objDataBase->Ejecutar("SELECT valor FROM opciones WHERE opcion='$option'");
  $rows = $q->fetch_assoc();
  $q->free();
  return $rows['valor'];
}

function rb_set_values_options($option, $new_value){
  global $objDataBase;
  $q = $objDataBase->Ejecutar("UPDATE opciones SET valor='$new_value' WHERE opcion='$option'");
	return $q;
}

function rb_encrypt_decrypt($action, $string) {
  //https://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt/e
  $output = false;

  $encrypt_method = "AES-256-CBC";
  $secret_key = 'This is my secret key';
  $secret_iv = 'This is my secret iv';

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

function rb_post_related_by_category($Post_id, $Category_id,  $Limit = 5){
  global $objDataBase;
	$qa = $objDataBase->Ejecutar("SELECT a.* FROM articulos a, articulos_categorias ac, categorias c WHERE a.id=ac.articulo_id AND ac.categoria_id=c.id AND a.activo='A' AND c.id = ".$Category_id." AND a.id <> ".$Post_id." ORDER BY RAND() LIMIT $Limit");
	return rb_return_post_array($qa);
}
function rb_get_user_info($User_id){
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE id=$User_id");

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
    $UserArray['photo_id'] = $Users['photo_id'];
		$UserArray['url_img'] = rb_get_img_profile($Users['id']);
		$UserArray['url'] = rb_url_link( 'user', $Users['id'] );
	endwhile;
	return $UserArray;
}
function rb_photos_from_album_post($Post_id){
  global $objDataBase;
  $result = $objDataBase->Ejecutar( "SELECT b.nombre, b.id FROM articulos a, albums b, articulos_albums ab WHERE a.id=ab.articulo_id AND ab.album_id = b.id AND a.id =".$Post_id." LIMIT 1" );
  $row = $result->fetch_assoc();
	$album_id = $row['id'];
	if($album_id==0) return false;

	$qa = $objDataBase->Ejecutar("SELECT * FROM photo WHERE album_id = ".$album_id." ORDER BY orden ASC");

	if($qa->num_rows==0) return false;

	$rm_url = G_SERVER."/";

	$FotosArray = array();
	$i=0;
	while($Fotos = $qa->fetch_assoc()):
			$FotosArray[$i]['id'] = $Fotos['id'];
			$FotosArray[$i]['description'] = $Fotos['description'];
			$FotosArray[$i]['tipo'] = $Fotos['tipo'];
			$FotosArray[$i]['url_max'] = $rm_url.'rb-media/gallery/'.$Fotos['src'];
			$FotosArray[$i]['url_min'] = $rm_url.'rb-media/gallery/tn/'.$Fotos['src'];
			$FotosArray[$i]['goto_url'] = rb_url_link( $Fotos['tipo'] , $Fotos['url'] );
		$i++;
	endwhile;
	return $FotosArray;
}

function rb_show_post($post_id){
  global $objDataBase;
	if( G_ENL_AMIG == 1 ):
		$q = $objDataBase->Ejecutar("SELECT id FROM articulos WHERE titulo_enlace='$post_id' OR id ='$post_id'");
		$num_posts = $q->num_rows;
		if( $num_posts > 0):
			$Post = $q->fetch_assoc();
			$post_id = $Post['id'];
		else:
			return false;
		endif;
	endif;
	$qa  = $objDataBase->Ejecutar("SELECT a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio FROM articulos a WHERE activo='A' AND id =".$post_id);
	// Como solo buscamos un unico valor y queremos usar la funcion "rb_return_post_array" que devuelve
	// un array asociativo, usamos el link de ayuda. Tanto para versiones nuevas como antiguas

	// http://librosweb.es/foro/pregunta/257/como-obtener-el-primer-elemento-de-un-array-php-asociativo/
	//  PHP (versión 5.4 o superior)
	return array_values( rb_return_post_array($qa) )[0];

	// PHP Versiones mas antiguas
	//return array_shift(array_values( rb_return_post_array($qa) ));
}
// Suma 1 unidad a cada acceso al post, paginas, etc
function rb_set_read_post($id, $table){
	global $objDataBase;
	$objDataBase->EditarPorCampo_int($table,'lecturas','lecturas+1',$id);
}
// Obtener categoria del post segun id del post
function rb_get_category_by_post_id($post_id){
	global $objDataBase;
	$result = $objDataBase->Ejecutar("SELECT c.* FROM categorias c, articulos_categorias ac, articulos a WHERE c.id=ac.categoria_id AND ac.articulo_id= a.id AND a.id =$post_id LIMIT 1");
	return $result;
}
// obtener info de categoria por id, o nombre_enlace
function rb_get_category_info($category){
	global $objDataBase;
	$qc  = $objDataBase->Ejecutar("SELECT * FROM categorias WHERE nombre_enlace='".$category."'");
	if(!$qc) return false;
	$num_reg = $qc->num_rows;
	if($num_reg==0):
		//Probamos con el Id
		$qc  = $objDataBase->Consultar("SELECT * FROM categorias WHERE id=$category");
		if(!$qc) return false;
	endif;
	$CategoriesArray = array();
	$i=0;
	while($Category = $qc->fetch_assoc()):
			$CategoriesArray['id'] = $Category['id'];
			$CategoriesArray['nombre'] = $Category['nombre'];
			$CategoriesArray['descripcion'] = $Category['descripcion'];
			$CategoriesArray['nombre_enlace'] = $Category['nombre_enlace'];
			$CategoriesArray['url'] = rb_url_link( 'cat' , $Category['id'] );
			$CategoriesArray['photo_id'] = $Category['photo_id'];
		$i++;
	endwhile;
	return $CategoriesArray;
}

// mostrar foto de perfil
function rb_get_img_profile($user_id){
  global $objDataBase;

	$q = $objDataBase->Ejecutar("SELECT photo_id FROM usuarios WHERE id= $user_id");
	$Usuario = $q->fetch_assoc();
	$photos = rb_get_photo_from_id($Usuario['photo_id']);
	if($photos['src']==""):
		return G_SERVER."/rb-admin/img/user-default.png";
	else:
		return G_SERVER."/rb-media/gallery/tn/".$photos['src'];
	endif;
}

/* OBTIENE DATOS FILES IN ARRAY FROM ID*/
function rb_get_photo_from_id($photo_id){ //antes rb_get_data_from_id
	/*require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-fotos.class.php");
	$objFoto = new Fotos;*/
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id=$photo_id");
	$Photos = $q->fetch_assoc();
	return $Photos;
}

/* OBTIENE DATOS FILES FROM ID*/
function rb_get_photo_details_from_id($photo_id){
  global $objDataBase;
	/*require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-fotos.class.php");
	$objFoto = new Fotos;*/
	$q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id=$photo_id");
	$Photo = $q->fetch_assoc();
  $DetailsPhoto = array();
  $DetailsPhoto['file_name'] = $Photo['src'];
  if($Photo['src']==""):
    $DetailsPhoto['file_url'] = G_SERVER."/rb-script/images/gallery-default.jpg";
    $DetailsPhoto['thumb_url'] = G_SERVER."/rb-script/images/gallery-default.jpg";
  else:
    $DetailsPhoto['file_url'] = G_SERVER."/rb-media/gallery/".$Photo['src'];
    $DetailsPhoto['thumb_url'] = G_SERVER."/rb-media/gallery/tn/".$Photo['src'];
  endif;
	return $DetailsPhoto;
}

function rb_photo_login($photo_id){ // logo image login (antes: rb_url_photo_from_id)
  global $objDataBase;
	/*require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-fotos.class.php");
	$objFoto = new Fotos;*/
	$q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id=$photo_id");
	$Photos = $q->fetch_assoc();
	if($Photos['src']==""):
		return G_SERVER."/rb-admin/img/user-default.png";
	else:
		return G_SERVER."/rb-media/gallery/".$Photos['src'];
	endif;
}

function rb_image_exists($name_img){
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$path_img = ABSPATH."rb-media/gallery/".$name_img;
	if(file_exists ($path_img)) return true;
	else return false;
}

/* MUESTRA COMENTARIOS DE ARTICULOS */
function rb_comments_from_post($article_id){
  global $objDataBase;
	/*require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-comentarios.class.php");
	$objComentario = new Comentarios;*/

	$q = $objDataBase->Ejecutar("SELECT *,  DATE_FORMAT(fecha, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(fecha, '%d') as fecha_dia, DATE_FORMAT(fecha, '%M') as fecha_mes_l, DATE_FORMAT(fecha, '%m') as fecha_mes, DATE_FORMAT(fecha, '%Y') as fecha_anio FROM comentarios WHERE articulo_id=$article_id");

	$CommentsArray = array();
	$i=0;
	while($Comments = $q->fetch_assoc()):
		$CommentsArray[$i]['id'] = $Comments['id'];
		$CommentsArray[$i]['nombre'] = $Comments['nombre'];
		$CommentsArray[$i]['contenido'] = $Comments['contenido'];
		$CommentsArray[$i]['fecha'] = $Comments['fecha'];
		$CommentsArray[$i]['email'] = $Comments['mail'];
		$CommentsArray[$i]['fec_dia'] = $Comments['fecha_dia'];
		$CommentsArray[$i]['fec_mes'] = $Comments['fecha_mes'];
		$CommentsArray[$i]['fec_mes_l'] = rb_mes_nombre($Comments['fecha_mes']);
		$CommentsArray[$i]['fec_anio'] = $Comments['fecha_anio'];
		$i++;
	endwhile;
	return $CommentsArray;
}

/* MUESTRA CATEGORIAS DE POST EN PARTICULAR */
function rb_show_category_from_post($article_id){
	/*require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-articulos.class.php");
	$objArticulo = new Articulos;*/
  global $objDataBase;

	$q = $objDataBase->Ejecutar("SELECT c.* FROM categorias c, articulos_categorias ac, articulos a WHERE c.id=ac.categoria_id AND ac.articulo_id= a.id AND a.id =$article_id");

	$CategoriesArray = array();
	$i=0;
	while($Categories = $q->fetch_assoc()):
		$CategoriesArray[$i]['id'] = $Categories['id'];
		$CategoriesArray[$i]['nombre'] = $Categories['nombre'];
		$CategoriesArray[$i]['url'] = rb_url_link( 'cat' , $Categories['id'] );
		$i++;
	endwhile;
	return $CategoriesArray;
}

/* MUESTRA CONTENIDO DE UNA PÁGINA EN PARTICULAR */
function rb_show_specific_page($page_id){
  global $objDataBase;
	/*require_once( dirname( dirname(__FILE__) ) ."/global.php");
	require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-paginas.class.php");*/

	if($page_id=="") return false;
	//$objPagina = new Paginas;

	// Probamos con Nombre_Enlace
	$qp  = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE titulo_enlace='".$page_id."'");
	if(!$qp) return false;
	$num_reg = $qp->num_rows;
	if($num_reg==0):
		//Probamos con el Id
		$qp  = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id=$page_id");
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
/*function rb_datesql_to_ddmmyyyy($fecha, $separate = "/"){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3].$separate.$mifecha[2].$separate.$mifecha[1];
    return $lafecha;
}*/

// Antes rb_fecha_format
function rb_sqldate_to($sqlfecha, $format = 'd-m-Y'){ // Convierte fecha SQl (formato ingles) a fecha unix y luego a formato español.
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

function rb_nums_post_by_category($category_id){
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT c.articulo_id, a.* FROM articulos a, articulos_categorias c WHERE a.id=c.articulo_id AND c.categoria_id=".$category_id." AND activo='A'");
	return $q->num_rows;
}

function rb_get_post_by_category($category_id="*", $starred=false, $show_post=false, $num_posts=10, $regstart=0, $column="id", $ord = "DESC" ){ // Se cambio orden de parametros
	global $objDataBase;
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$rm_url = G_SERVER."/";
	$limit = "";
	if($category_id=="") return false;
	if($show_post==true) $limit = " LIMIT ".$regstart.", ".$num_posts." ";
	if($starred): //destacado
		$starred_query = " AND portada=1 ";
	else:
		$starred_query = "";
	endif;
  // todos los posts
	if($category_id == "*"):
		// Si es "0", seleccionamos todos los posts
		//if($access=="public"):
    if(G_ACCESOUSUARIO==0): // login
      $q_string = "SELECT c.acceso, c.niveles, a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta,
			DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes,
			DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio FROM articulos a, articulos_categorias ac, categorias c
			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND c.acceso = 'public' ".$starred_query."
			ORDER BY $column $ord $limit";
			$qa  = $objDataBase->Ejecutar($q_string);
		//elseif($access=="privat"): //privado
    elseif(G_ACCESOUSUARIO==1): // no login
      $q_string = "SELECT c.acceso, c.niveles, a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta,
			DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes,
			DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio FROM articulos a, articulos_categorias ac, categorias c
			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND (c.acceso = 'public' OR c.acceso = 'privat' AND c.niveles LIKE '%".G_USERNIVELID."%') ".$starred_query."
			ORDER BY $column $ord $limit";
			$qa  = $objDataBase->Ejecutar($q_string);
		endif;
  // post por categoria
	elseif($category_id != "" || $category_id !=0 || $category_id != "*"):
		// Si no es "0" se busca la categoria
		// Probamos con Nombre_Enlace
		$qc  = $objDataBase->Ejecutar("SELECT id FROM categorias WHERE nombre_enlace='".$category_id."'");
		if(!$qc) return false;
		$num_reg = $qc->num_rows;
		if($num_reg==0):
			//Probamos con el Id
			$qc  = $objDataBase->Ejecutar("SELECT id FROM categorias WHERE id=$category_id");
			if(!$qc) return false;
			$num_reg = $qc->num_rows;
		endif;

		// Si Consulta funcion y Num de Regs es mayor a  "0"
		if($qc && $num_reg > 0 ):
			$ra = $qc->fetch_assoc();
			$category_id = $ra['id'];
      if(G_ACCESOUSUARIO==0): // login
        $q_string = "SELECT c.acceso, c.niveles, a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta,
  			DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes,
  			DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio FROM articulos a, articulos_categorias ac, categorias c
  			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND c.id=$category_id AND c.acceso = 'public' ".$starred_query."
  			ORDER BY $column $ord $limit";
  			$qa  = $objDataBase->Ejecutar($q_string);
  		elseif(G_ACCESOUSUARIO==1):// no login
        $q_string = "SELECT c.acceso, c.niveles, a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta,
  			DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes,
  			DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio FROM articulos a, articulos_categorias ac, categorias c
  			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND c.id=$category_id AND (c.acceso = 'public' OR c.acceso = 'privat' AND c.niveles LIKE '%".G_USERNIVELID."%') ".$starred_query."
  			ORDER BY $column $ord $limit";
  			$qa  = $objDataBase->Ejecutar($q_string);
      endif;
		else:
			return;
		endif;
	endif;
	if($show_post==true):
		return rb_return_post_array($qa);
	else:
		return $qa->num_rows;
	endif;
}

// Muestra publicaciones destacadas
function rb_get_post_stars($post_max = 4){
	/*require_once( dirname( dirname(__FILE__) ) ."/global.php");
	require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-articulos.class.php");
	require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-fotos.class.php");

	$objArticulo = new Articulos;*/
	$q = $objDataBase->Ejecutar( "SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(fecha_creacion, '%Y') as fecha_anio FROM articulos WHERE portada=1 LIMIT $post_max" );
	return rb_return_post_array($q);
}

function rb_get_post_more_read($num_posts=10){
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$rm_url = G_SERVER."/";
	$qa  = $objDataBase->Ejecutar("SELECT a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio FROM articulos a WHERE activo='A' ORDER BY a.lecturas DESC LIMIT $num_posts");
	return rb_return_post_array($qa);
}

function rb_get_images_from_gallery($album_id){
  global $objDataBase;
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$rm_url = G_SERVER."/";
	if($album_id=="") return false;
	// Probamos con Nombre_Enlace
	$qg = $objDataBase->Ejecutar("SELECT id FROM albums WHERE nombre_enlace='$album_id'");
	$num_reg = $qg->num_rows;
	if($num_reg==0):
		//Probamos con el Id
		$qg = $objDataBase->Ejecutar("SELECT id FROM albums WHERE id='$album_id'");
		$num_reg = $qg->num_rows;
	endif;

	if($qg && $num_reg > 0 ):
		$rg = $qg->fetch_assoc();
		$album_id = $rg['id'];
		$qp = $objDataBase->Ejecutar("SELECT * FROM photo WHERE album_id=".$album_id." ORDER BY orden");

		$FotosArray = array();
		$i=0;
		while($Fotos = $qp->fetch_assoc()):
			$FotosArray[$i]['id'] = $Fotos['id'];
      $FotosArray[$i]['title'] = $Fotos['title'];
			$FotosArray[$i]['description'] = $Fotos['description'];
			$FotosArray[$i]['tipo'] = $Fotos['tipo'];
			$FotosArray[$i]['url_max'] = $rm_url.'rb-media/gallery/'.$Fotos['src'];
			$FotosArray[$i]['url_min'] = $rm_url.'rb-media/gallery/tn/'.$Fotos['src'];
			$FotosArray[$i]['goto_url'] = rb_url_link( $Fotos['tipo'] , $Fotos['url'] );
			$i++;
		endwhile;
		return $FotosArray;
	else:
		return false;
	endif;
}

function rb_get_num_comments_by_post_id($articulo_id){
  global $objDataBase;
	/*require_once( dirname( dirname(__FILE__) ) ."/rb-script/class/rb-articulos.class.php");
	$objArticulo = new Articulos;*/
	$q = $objDataBase->Ejecutar("SELECT id FROM comentarios WHERE articulo_id=".$articulo_id);
	return $q->num_rows;
}

/* LA FUNCION DEVUELVE LA RUTA COMPLETA DE LA IMAGEN DE PORTADA DE CADA PUBLICACION */
function rb_get_url_image($article_id, $size = "m", $section = "portada", $showImgAlt = false){
	require_once( dirname( dirname(__FILE__) ) ."/global.php");

	$url = G_SERVER."/";
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
			return G_SERVER."/rb-script/images/gallery-default.jpg";
		endif;
	}else{
		return G_SERVER."/rb-script/images/gallery-default.jpg";
	}
}

function rb_select_object_publication($nombre, $articulo_id, $tipo = 'image'){
	global $objDataBase;
	$result = $objDataBase->Ejecutar("SELECT contenido FROM objetos WHERE articulo_id=".$articulo_id." and tipo = '".$tipo."' and nombre = '".$nombre."' LIMIT 1");
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		return $row['contenido'];
	}else{
		return false;
	}
}

/* LA FUNCION GENERA EL LINK DE ACUERDO A LA SECCION
 * Y EL ID (PUEDE SER CATEGORIA, PUBLICACION O PAGINA )*/
function rb_url_link($section, $id, $page=0){
  global $objDataBase;
	require_once( dirname( dirname(__FILE__) ) ."/global.php");
	// obtener variables globales
	$url_web = G_SERVER."/";
	$link_friendly = G_ENL_AMIG;
	switch($section){
		case "cat":
			if($link_friendly){
				$q = $objDataBase->Ejecutar("SELECT id FROM categorias WHERE id='$id'"); //verificar mas adelante 26/08/17 id x nombre_enlace
				if( $q->num_rows==0 ):
					return $url_web;
				endif;
				$r = $q->fetch_assoc();
				$q = $objDataBase->Ejecutar("SELECT nombre_enlace FROM categorias WHERE id=".$r['id']);

				$r = $q->fetch_assoc();
				$name_link = $r['nombre_enlace'];
				if($page==0 || $page==1) return $url_web.G_BASECAT."/".$name_link."/";
				else return $url_web.G_BASECAT."/".$name_link."/".G_BASEPAGE."/".$page."/";
			}else{
				if($page==0 || $page==1) return $url_web."?cat=".$id;
				else return $url_web."?cat=".$id."&page=".$page;
			}
			break;
		case "art":
		case "post":
			if($link_friendly){
				$q = $objDataBase->Ejecutar("SELECT titulo_enlace FROM articulos WHERE id=".$id);
				$r = $q->fetch_assoc();
				$name_link = $r['titulo_enlace'];
				return $url_web.G_BASEPUB."/".$name_link."/";
			}else{
				return $url_web."?art=".$id;
			}
			break;
		case "pag":
			// Consultamos por -titulo-id
			$q  = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE titulo_enlace='".$id."'");
			if(!$q) return false;
			$num_reg = $q->num_rows;
			if($num_reg==0):
				// Consultamos por -id
				$q  = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id=$id");
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
	}
}
function rb_show_half_post($content,$link) { // antes -> more_content
	$contArray=explode('<!--mas-->',$content);
	if(count($contArray)>1){
		$contArray[0] = preg_replace('/^[\s]*(.*)[\s]*$/','\\1',$contArray[0]);
		$enlace="<a href=\"".$link."\">Ver publicación completa</a>";
		return $contArray[0].$enlace;
	}else{
		return $content;
	}
}
/* OBTIENE TITULO SEGUN TIPO DE USUARIO*/
function rb_get_user_type($type){
	switch($type):
		case 1:
			return "Administrador";
		break;
		case 2:
			return "Usuario Avanzado";
		break;
		case 3:
			return "Usuario Final";
		break;
	endswitch;
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
    case 0:
			return "Domingo";
			break;
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

		$height = strval(G_THEIGHT); //"250";
		$width = strval(G_TWIDTH); //"360";

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
		if(substr_count(strtolower($destination_file), ".gif")){
			imagegif($square_image,$destination_file);
		}
		if(substr_count(strtolower($destination_file), ".png")){
			imagepng($square_image,$destination_file,9);
		}

		imagedestroy($original_image);
		imagedestroy($smaller_image);
		imagedestroy($square_image);
}
function rb_BBCodeToGlobalVariable($texto,$id=0){
  global $objDataBase;
	$gallery_html = "";
	if($id>0){
		$qp  = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id=$id");
		$r = $qp->fetch_assoc();
		if($r['galeria_id']>0):
			$gallery_html .= '<ul class="gallery">';
			$Fotos = rb_get_images_from_gallery($r['galeria_id']);
			foreach ($Fotos as $Foto):
				$gallery_html .= '<li>';
			 	$gallery_html .= '<a class="fancy" title="'.$Foto['description'].'" rel="gallery" href="'.$Foto['url_max'].'">';
			 	$gallery_html .= '<img class="img-responsive" src="'.$Foto['url_min'].'" alt="Foto" />';
			 	$gallery_html .= '</a>';
				$gallery_html .= '</li>';
			endforeach;
			$gallery_html .= '</ul>';
		endif;
	}

   	$bbcode = array(
      "/\[RUTA_SITIO]/is",
      "/\[RUTA_TEMA]/is",
      "/\[YOUTUBE=\"(.*?)\"]/is",
      //"/\[MENU id=\"(.*?)\"]/e", /e modifer obsoleto
      "/\[GALERIA]/is",
      "/\[FORMULARIO]/is",
      /*"/\[FORMULARIO_SERVICIO nombre=\"(.*?)\"]/is",*/
      "/\[MAPA coordenadas=\"(.*?)\" altura=\"(.*?)\"]/is",
   	);

   	$html = array(
      G_SERVER.'/',
      G_URLTHEME.'/',
      '<iframe class="img-responsive" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
      //"rb_display_menu('$1')",
      $gallery_html,
      htmlspecialchars_decode(G_FORM),
      /*rb_showform('$1'),*/
      '<iframe frameborder="0" height="$2" src="'.G_SERVER.'/rb-script/map.php?ubicacion='.G_TITULO.'&coordenadas=$1&alto=$2" class="img-responsive"></iframe>'
   	);

   	$texto = preg_replace($bbcode, $html, $texto);
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

function rb_shownivelname($nivel_id){
	global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT nombre FROM usuarios_niveles WHERE id = $nivel_id");
	$r = $q->fetch_assoc();
	return $r['nombre'];
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
		echo '<img class="img-icon-menu" src="'.$item['url_imagen'].'" alt="Inicio">';
		echo '<span class="text">'.$item['nombre'].'</span>';
		echo '</a>';
		if( !is_null($item['item']) ){
			// De momento solo tendra 2 niveles el menu del panel
			echo '<ul class="hidden">';
			foreach ($item['item'] as $item => $subitem) {
				echo '<li>';
				$style_css = "";
				if($subitem['key']==$subitem_selected){
					$style_css = ' class="selected" ';
				}
				echo '<a id="'.$subitem['key'].'" '.$style_css.' title="'.$subitem['nombre'].'" href="'.$subitem['url'].'">';
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
		echo '</li>
		';
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
	array_push($menu_panel[$item_padre]['item'], $data );
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

/* Envia correo usando la libreria nativa del PHP o externa (en este caso SendGrid)
 * Parametros:
 * 		@$recipient: Correo del destinario
 * 		@$subject: Asunto del correo
 * 		@$email_content: Contenido del correo
 * 		@$native: Por defecto true, si usa libreria estandar del PHP
 * */
function rb_mailer($recipient, $subject, $email_content, $native = true, $email_headers_name="", $email_headers_mail=""){ // Verificar funcionamiento
	//global $objDataBase;
	// Info de quien envia
	//require_once( dirname( dirname(__FILE__) ) ."/global.php");
	if($email_headers_name=="") $email_headers_name = rb_get_values_options('name_sender');
	if($email_headers_mail=="") $email_headers_mail = rb_get_values_options('mail_sender');

	if($native==true):
		$email_headers = "From: " .$email_headers_name." <".strip_tags($email_headers_mail) . "> \r\n";
		//$email_headers .= "Reply-To: <". strip_tags(G_MAILSENDER) . ">\r\n";
		//$email_headers .= "CC: ".strip_tags($email)."\r\n"; // con copia al usuario que esta enviando
		$email_headers .= "MIME-Version: 1.0\r\n";
		$email_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		if (mail($recipient, $subject, $email_content, $email_headers)){
			return true;
		}else{
			return false;
		}
	endif;
	if($native==false):
		require_once( dirname( dirname(__FILE__) ) ."/rb-script/modules/sendgrid-php/sendgrid-php.php");

		$apiKey = rb_get_values_options('sendgridapikey');

		$from = new SendGrid\Email($email_headers_name, $email_headers_mail);
		$to = new SendGrid\Email(null, $recipient);
		$content = new SendGrid\Content("text/html", $email_content);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);

		//$apiKey = 'SG.qRNT0E_0SRu4y2S_6SyGcA.mSYSZ4oepiy15THWUKE-nhMjnchn7m_e-UL7EncLS0A';
		$sg = new \SendGrid($apiKey);

		$response = $sg->client->mail()->send()->post($mail);
		$rspta_code = $response->statusCode();

		// Send the email.
		if($rspta_code=="202"){
			return true;
		}else{
			return false;
		}
	endif;
}

/* Informacion de una galeria o album de imagenes */

function rb_get_info_gallery($album_id){
  global $objDataBase;
  $rm_url = G_SERVER."/";
	if($album_id=="") return false;
	$qg = $objDataBase->Ejecutar("SELECT * FROM albums WHERE nombre_enlace='$album_id'");
	$num_reg = $qg->num_rows;
	if($num_reg==0):
		$qg = $objDataBase->Ejecutar("SELECT * FROM albums WHERE id=$album_id");
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
      $photos = rb_get_photo_from_id($Galerias['photo_id']);
    	if($photos['src']==""):
    		$GaleriasArray['url_bgimage'] = G_SERVER."/rb-script/images/gallery-default.jpg";
        $GaleriasArray['url_bgimagetn'] = G_SERVER."/rb-script/images/gallery-default.jpg";
    	else:
    		$GaleriasArray['url_bgimage'] = G_SERVER."/rb-media/gallery/".$photos['src'];
        $GaleriasArray['url_bgimagetn'] = G_SERVER."/rb-media/gallery/tn/".$photos['src'];
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
      $q= $objDataBase->Ejecutar("SELECT * FROM albums ORDER BY nombre_enlace ASC".$add_limit);
  }else{
      $q= $objDataBase->Ejecutar("SELECT * FROM albums WHERE galeria_grupo='$groupname' ORDER BY nombre_enlace ASC".$add_limit);
  }
  $GaleriasArray = Array();
  //$FotosArray = array();
	$i=0;
	while($Galerias = $q->fetch_assoc()):
			$GaleriasArray[$i]['id'] = $Galerias['id'];
			$GaleriasArray[$i]['nombre'] = $Galerias['nombre'];
			$GaleriasArray[$i]['nombre_enlace'] = $Galerias['nombre_enlace'];
			$GaleriasArray[$i]['usuario_id'] = $Galerias['usuario_id'];
			$GaleriasArray[$i]['galeria_grupo'] = $Galerias['galeria_grupo'];
      $photos = rb_get_photo_from_id($Galerias['photo_id']);
    	if($photos['src']==""):
    		$GaleriasArray[$i]['url_bgimage'] = G_SERVER."/rb-script/images/gallery-default.jpg";
        $GaleriasArray[$i]['url_bgimagetn'] = G_SERVER."/rb-script/images/gallery-default.jpg";
    	else:
    		$GaleriasArray[$i]['url_bgimage'] = G_SERVER."/rb-media/gallery/".$photos['src'];
        $GaleriasArray[$i]['url_bgimagetn'] = G_SERVER."/rb-media/gallery/tn/".$photos['src'];
    	endif;
		$i++;
	endwhile;
	return $GaleriasArray;
}

/* Muestra ruta/ubicacion de categorias padres
 * Parametros:
 * 		@$category_id -> id de la categoria que deseamos buscar su ancestros.
 *    @path -> variable interna para almacenar la ruta consultada de momento
 * */

function rb_path_categories($category_id,$path=""){
	global $objDataBase;
  $q = $objDataBase->Ejecutar("SELECT * FROM categorias WHERE id=$category_id");
  $r = $q->fetch_assoc();
  $path = $r['nombre'].'/'.$path;
  if($r['nivel']==0):
    // Alcanza el top, sale
    echo $path;
    return;
  else:
    // caso contrario, imprime nombre de categoria, y busca datos de su padre
    rb_path_categories($r['categoria_id'],$path);
  endif;
}

/* Array de categorias y subcategorias
 * Parametros:
 * 		@$category_id -> id de la categoria que deseamos buscar su ancestros.
 *    @path -> variable interna para almacenar la ruta consultada de momento
 * */
function rb_categories_to_array($category_id, $all=true) {
  //require_once( dirname( dirname(__FILE__) ) ."/global.php");
	/*global $categories;
	global $i;*/
	global $objDataBase;
  $q = "SELECT c.categoria_id, c.nivel, c.id, c.nombre, c.acceso, c.niveles, Items.Count FROM categorias c LEFT OUTER JOIN (SELECT categoria_id, COUNT(*) AS Count FROM categorias GROUP BY categoria_id) Items ON c.id = Items.categoria_id WHERE c.categoria_id=$category_id ORDER BY id";
	//$r = mysql_query($q);
	$r = $objDataBase->Ejecutar( $q );
	while ( $row = $r.fetch_assoc() ):
		$i = $row['id'];
    // Si el acceso es privado, no se mostrara, pero antes
    // se comparara el nivel del usuario con el de la categoria
    if($row['acceso']=="privat"):
      if(G_USERNIVELID>0){
        $pos = strpos($row['niveles'], G_USERNIVELID);
        if($pos === FALSE) continue;
      }else{
        continue;
      }
    endif;
		if ($row['Count'] > 0):
			$categories[$i]['id'] = $row['id'];
			$categories[$i]['categoria_id'] = $row['categoria_id'];
			$categories[$i]['nivel'] = $row['nivel'];
			$categories[$i]['nombre'] = $row['nombre'];
      $categories[$i]['acceso'] = $row['acceso'];
      $categories[$i]['niveles'] = $row['niveles'];
      $categories[$i]['url'] = rb_url_link( 'cat' , $row['id'] );
			$categories[$i]['items'] = rb_categories_to_array($row['id']);
		elseif($row['Count']==0):
			$categories[$i]['id'] = $row['id'];
			$categories[$i]['categoria_id'] = $row['categoria_id'];
			$categories[$i]['nivel'] = $row['nivel'];
			$categories[$i]['nombre'] = $row['nombre'];
      $categories[$i]['acceso'] = $row['acceso'];
      $categories[$i]['niveles'] = $row['niveles'];
      $categories[$i]['url'] = rb_url_link( 'cat' , $row['id'] );
		endif;
	endwhile;

	return $categories;
}

// Lista categorias en el panel administrativo - revisar esta funcion, es obsoleta
function rb_listar_categorias($id_padre){ // antes listar_categorias
	global $objDataBase;
	/*require_once("../rb-script/class/rb-categorias.class.php");
	$objCategoria = new Categorias;*/
	$consultaSecc = $objDataBase->Ejecutar("SELECT * FROM categorias ORDER BY nombre");

	while ( $categoria = $consultaSecc->fetch_assoc() ){
		$categoria_array[$categoria["id"]] = array(
			"id" => $categoria["id"],
			"nombre" => $categoria["nombre"],
			"descripcion" => rb_fragment_text($categoria["descripcion"],30),
			"acceso" => $categoria["acceso"],
			"niveles" => $categoria["niveles"],
			"categoria_id" => $categoria["categoria_id"],
			"nivel" => $categoria["nivel"],
		);
	}

	if(!isset($categoria_array)) return;

	foreach($categoria_array as $key => $value){
		if ($value["categoria_id"] == $id_padre){
			if($id_padre == 0){
				echo "
				 <tr>
      		<td><a title='Agregar una subcategoria' href='../rb-admin/index.php?pag=cat&opc=nvo&catid=".$value['id']."&niv=".($value['nivel']+1)."'><img width=\"16px\" height=\"16px\" style=\"border:0px;\" src=\"img/add-black-16.png\" alt=\"Agregar Sub Categoria\" /></a>  ".$value['nombre']."</td>
					<td>".$value['descripcion']."</td>
					<td>".rb_showvisiblename($value['acceso'])."</td>
					<td>".rb_niveltoname($value['niveles'])."</td>
					<td width='40px;'>
					<span>
					<a title=\"Editar\" href='../rb-admin/index.php?pag=cat&amp;opc=edt&amp;id=".$value['id']."'>
					<img style=\"border:0px;\" src=\"img/edit-black-16.png\" alt=\"Editar\" /></a>
					</span>
					</td>

					<td width='40px;'>
					<span>
					<a href=\"#\" title=\"Eliminar\" class=\"del-item\" data-id=\"".$value['id']."\">
					<img src=\"img/del-black-16.png\" alt=\"Eliminar\" /></a>
					</span>
					</td>\n
    			</tr>";
				rb_listar_categorias($key);
			}else{
				echo "
				 <tr>
      		<td>".str_repeat('- - ', $value['nivel'])."<a title='Agregar una subcategoria' href='../rb-admin/index.php?pag=cat&opc=nvo&catid=".$value['id']."&niv=".($value['nivel']+1)."'><img style=\"border:0px;\" src=\"img/add-black-16.png\" width=\"16px\" height=\"16px\" alt=\"Agregar Sub Categoria\" /></a>  ".$value['nombre']."</td>
					<td>".$value['descripcion']."</td>
					<td>".rb_showvisiblename($value['acceso'])."</td>
					<td>".rb_niveltoname($value['niveles'])."</td>
					<td width='40px;'>
					<span>
					<a title=\"Editar\" href='../rb-admin/index.php?pag=cat&amp;opc=edt&amp;id=".$value['id']."'>
					<img style=\"border:0px;\" src=\"img/edit-black-16.png\" alt=\"Editar\" /></a>
					</span>
					</td>
					<td width='40px;'>
					<span>
					<a href=\"#\" title=\"Eliminar\" class=\"del-item\" data-id=\"".$value['id']."\">
					<img src=\"img/del-black-16.png\" alt=\"Eliminar\" /></a>
					</span>
					</td>\n
    			</tr>";
				rb_listar_categorias($key);
			}
		}
	}
}

function rb_show_bar_admin(){
  require_once( dirname( dirname(__FILE__) ) ."/global.php");
  if(G_ACCESOUSUARIO==1):
    echo '<div class="wrap-content wrap-content-bar-admin"><div class="inner-content inner-content-bar-admin">
      Hola, tienes iniciado el gestor de contenido. <a href="'.G_SERVER.'/rb-admin/">Admistrarlo</a>. <a href="'.G_SERVER.'/login.php?out">Cerrar Session</a>.
    </div></div>';
  endif;
}
/*
* Muestra la cabecera de la plantilla, por defecto el archivo se llama header.php, tambien se puede adicional algunos otros,
* los cuales se incluyen DESPUES de header.php
*/
function rb_header($add_header = array()){
  global $show_header;
  //if(isset($show_header) && $show_header==0) return false;

  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname( dirname(__FILE__) ) . '/');

  require_once ABSPATH."global.php";
  include_once ABSPATH."rb-temas/".G_ESTILO."/header.php";
  foreach ($add_header as $header) {
    include_once ABSPATH."rb-temas/".G_ESTILO."/".$header;
  }
}

/*
* Muestra el pie de la plantilla, por defecto el archivo se llama footer.php, tambien se puede adicional algunos otros,
* los cuales se incluyen ANTES de footer.php
*/
function rb_footer($add_footer = array()){
  global $show_footer;
  //if(isset($show_footer) && $show_footer==0) return false;

  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname( dirname(__FILE__) ) . '/');

  require_once ABSPATH."global.php";
  foreach ($add_footer as $footer) {
    include_once ABSPATH."rb-temas/".G_ESTILO."/".$footer;
  }
  include_once ABSPATH."rb-temas/".G_ESTILO."/footer.php";
}

/*
* Muestra la columna lateral de la plantilla, por defecto el archivo se llama sidebar.php
*/
function rb_sidebar($add_sidebar = array()){
  global $show_sidebar;
  if(isset($show_sidebar) && $show_sidebar==0) return false;

  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname( dirname(__FILE__) ) . '/');

  require_once ABSPATH."global.php";
  /*foreach ($add_sidebar as $block) {
    include_once ABSPATH."rb-temas/".G_ESTILO."/".$block;
  }*/
  include_once ABSPATH."rb-temas/".G_ESTILO."/sidebar.php";
}

function rb_validar_mail($pMail) { // Antes validar_mail, solo usado en registro de usuario
  if (ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@+([_a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]{2,200}\.[a-zA-Z]{2,6}$", $pMail ) ) {
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
?>
