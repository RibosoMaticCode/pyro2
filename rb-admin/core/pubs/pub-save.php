<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$volver = "false";
if (isset($_POST['guardar_volver'])) {
  $volver = "true";
}

$mode=$_POST['mode'];

// portada
if(isset($_POST['featured'])) $port = "1";
else $port = "0";

// Categoria
if(!isset($_REQUEST['categoria'])) {
	print "[!] Debe seleccionar una categoria ... !!!";
	die();
}

$array_categorias = $_REQUEST['categoria'];
// Albums
$albums = 1;
if(!isset($_REQUEST['albums'])) {
	$albums = 0; // ningun album seleccionado
}else{
	$array_albums = $_REQUEST['albums'];
}

// Titulo del articulo
$tit=addslashes(htmlspecialchars($_POST['titulo'])); // addslashes->Escapa comillas de las expresiones
if(empty($tit)) {print "[-] Debe proporcionar un titulo al post ... !!!"; die ();}

// Enlace
$tit_id=$_POST['titulo_enlace'];
if(empty($tit_id)){
	//strip_tags — Retira las etiquetas HTML y PHP de un string
	$tit_id = rb_cambiar_nombre(strip_tags(utf8_encode($_POST['titulo'])));
}

// Palabras claves
$cla=$_POST['claves'];

// Contenido del artculo
$cont= addslashes($_POST['contenido']);  // addslashes->Escapa comillas de las expresiones  //no aplicar  => stripslashes y htmlspecialchars, tiny_mce... se encarga de enviarlo en formato html
if(empty($cont)) {
	print "[-] Debe proporcionar contenido al post ... !!!";
	die ();
}

// Valores por defecto
$aut=$_POST['userid']; // falta colocar ide del usuario

// activity
if(!empty($_POST['calendar']) || !$_POST['calendar']==""){
  $fecha = rb_a_yyyymmdd($_POST['calendar']);
  $actividad = 1;
}else{
	$fecha = "0000-00-00";
	$actividad = 0;
}

// video
$video = 0;
$video_embed = "";
$video_embed = trim($_POST['video_embed']);
$galeria = 0;
$src = "";
$externo = 1;
if(!isset($_REQUEST['externo'])) {
	$externo = 0; // ningun album seleccionado
}else{
	$array_externo = $_REQUEST['externo'];
}

$atributo = 1;
if(!isset($_REQUEST['atributo'])) {
	$atributo = 0;
}else{
	$array_atributo = $_REQUEST['atributo'];
}

$campos = [
	"titulo" => $tit,
	"titulo_enlace" => $tit_id,
	"autor_id" => $aut,
	"tags" => $cla,
	"contenido" => $cont,
	"img_back" => $_POST['img_back_id'],
	"img_profile" => $_POST['img_profile_id'],
	// obsoletos
	"actividad" => $actividad,
	"fecha_actividad" => $fecha,
	"video" => $video,
	"video_embed" => $video_embed,
	"portada" => $port
];

// tipo de accion
if($mode=="new"){
	$campos["fecha_creacion"] = date('Y-m-d G:i:s'); // añadiendo un campo-valor mas
	// Si grabar ok...
	$result = $objDataBase->Insert('articulos', $campos);
    //$result =  $objDataBase->Insertar( $q );
	if($result['result']){
		$ultimo_id = $result['insert_id'];
		// Grabamos categorias asociadas
		foreach($array_categorias as $categoria){
			$objDataBase->Ejecutar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($ultimo_id,$categoria)");
		}
		// Grabamos galerias asociadas
		if($albums>0){
			foreach($array_albums as $album){
				$objDataBase->Ejecutar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($ultimo_id,$album)");
			}
		}
		// Guardamos elementos externos
		if($externo>0){
			foreach($array_externo as $externo){
				$nombre_ext = $externo['tipo'];
				$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$ultimo_id)");
			}
		}
		// Grabamos articulos relacionados
		if($atributo>0){
			foreach($array_atributo as $atributo){
				$nombre_atributo = $atributo['nombre'];
				$articulo_id_padre = $atributo['id'];
				$objDataBase->Ejecutar("INSERT INTO articulos_articulos (nombre_atributo, articulo_id_padre, articulo_id_hijo) VALUES ('".$nombre_atributo."',".$ultimo_id.",".$articulo_id_padre.")");
			}
		}
			if($volver=="true"){
			$urlreload=G_SERVER.'/rb-admin/index.php?pag=art';
		}else{
			$urlreload=G_SERVER.'/rb-admin/index.php?pag=art&opc=edt&id='.$ultimo_id."&m=ok";
		}
		header('Location: '.$urlreload);
	}else{
	 	die("Ocurrio un error");
	}
}elseif($mode=="update"){
	$id = $_POST['id'];
	$fecmod = $_POST['fechamod'];
		$result = $objDataBase->Update('articulos', $campos, ["id" => $id]);
		// Limpiamos antes
	$objDataBase->Ejecutar("DELETE FROM articulos_categorias WHERE articulo_id=$id");
	$objDataBase->Ejecutar("DELETE FROM objetos WHERE articulo_id=$id");
	$objDataBase->Ejecutar("DELETE FROM articulos_albums WHERE articulo_id=$id");
	$objDataBase->Ejecutar("DELETE FROM articulos_articulos WHERE articulo_id_padre=$id");
		// Grabando las categorias relacionadas
	foreach($array_categorias as $categoria){
		$objDataBase->Ejecutar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($id,$categoria)");
	}
		// Grabamos galerias relacionadas
	if($albums>0){
		foreach($array_albums as $album){
			$objDataBase->Ejecutar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($id,$album)");
		}
	}
	// Grabamos nuevos elementos externos
	if($externo>0){
		foreach($array_externo as $externo){
			$nombre_ext = $externo['tipo'];
			$r = $objDataBase->Ejecutar( "UPDATE objetos SET contenido = '".$externo['contenido']."' WHERE articulo_id = $id AND tipo = 'objeto' AND nombre = '$nombre_ext'" );
				if( $r->affected_rows == 0 )
				$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$id)");
		}
	}
	// Grabamos articulos relacionados
	if($atributo>0){
		foreach($array_atributo as $atributo){
			$nombre_atributo = $atributo['nombre'];
			$articulo_id_padre = $atributo['id'];
			$objDataBase->Ejecutar("INSERT INTO articulos_articulos (nombre_atributo, articulo_id_padre, articulo_id_hijo) VALUES ('".$nombre_atributo."',".$id.",".$articulo_id_padre.")");
		}
	}
		//redireccionar a la pagina de edicion
	if($volver=="true"){
		$urlreload=G_SERVER.'/rb-admin/index.php?pag=art';
	}else{
		$urlreload=G_SERVER.'/rb-admin/index.php?pag=art&opc=edt&id='.$id."&m=ok";
	}
	header('Location: '.$urlreload);
}
?>
