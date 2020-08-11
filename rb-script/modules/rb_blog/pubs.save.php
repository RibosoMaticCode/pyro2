<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$volver = "false";
if (isset($_POST['guardar_volver'])) {
  $volver = "true";
}

$mode=$_POST['mode'];

// Categoria
if(!isset($_REQUEST['categoria'])) {
	print "[!] Debe seleccionar una categoria ... !!!";
	die();
}

$array_categorias = $_REQUEST['categoria'];

// Galeria adjunta
$albums = $_POST['albums'];

// Titulo del articulo
$tit=addslashes(htmlspecialchars($_POST['titulo'])); // addslashes->Escapa comillas de las expresiones
if(empty($tit)) {print "[-] Debe proporcionar un titulo al post ... !!!"; die ();}

// Generar enlace
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
$aut=$_POST['userid']; // falta colocar id del usuario

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
	"img_profile" => $_POST['img_profile_id'],
	"activo" => $_POST['estado'],
	"gallery_id" => $albums
];

// tipo de accion
if($mode=="new"){
	$campos["fecha_creacion"] = date('Y-m-d G:i:s'); // añadiendo un campo-valor mas
	// Si grabar ok...
	$result = $objDataBase->Insert('blog_posts', $campos);

	if($result['result']){
		$ultimo_id = $result['insert_id'];
		// Grabamos categorias asociadas
		foreach($array_categorias as $categoria){
			$objDataBase->Ejecutar("INSERT INTO blog_posts_categories (articulo_id, categoria_id) VALUES ($ultimo_id,$categoria)");
		}

		// Guardamos elementos externos
		if($externo>0){
			foreach($array_externo as $externo){
				$nombre_ext = $externo['tipo'];
				$objDataBase->Ejecutar("INSERT INTO blog_fields (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$ultimo_id)");
			}
		}

		if($volver=="true"){
			$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_blog_pubs';
		}else{
			$urlreload=G_SERVER."rb-admin/module.php?pag=rb_blog_pubs&pub_id=".$ultimo_id."&m=ok";
		}
		header('Location: '.$urlreload);
	}else{
	 	die("Ocurrio un error: ".$result['error']);
	}
}elseif($mode=="update"){
	$id = $_POST['id'];
	$fecmod = $_POST['fechamod'];
	$result = $objDataBase->Update('blog_posts', $campos, ["id" => $id]);
	
	// Limpiamos antes
	$objDataBase->Ejecutar("DELETE FROM blog_posts_categories WHERE articulo_id=$id");
	$objDataBase->Ejecutar("DELETE FROM blog_fields WHERE articulo_id=$id");
	
	// Grabando las categorias relacionadas
	foreach($array_categorias as $categoria){
		$objDataBase->Ejecutar("INSERT INTO blog_posts_categories (articulo_id, categoria_id) VALUES ($id,$categoria)");
	}

	// Grabamos nuevos elementos externos
	if($externo>0){
		foreach($array_externo as $externo){
			$nombre_ext = $externo['tipo'];
			$r = $objDataBase->Ejecutar( "UPDATE blog_fields SET contenido = '".$externo['contenido']."' WHERE articulo_id = $id AND tipo = 'objeto' AND nombre = '$nombre_ext'" );
				if( $r->affected_rows == 0 )
				$objDataBase->Ejecutar("INSERT INTO blog_fields (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$id)");
		}
	}

	//redireccionar a la pagina de edicion
	if($volver=="true"){
		$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_blog_pubs';
	}else{
		$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_blog_pubs&pub_id='.$id."&m=ok";
	}
	header('Location: '.$urlreload);
}
?>
