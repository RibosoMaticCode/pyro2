<?php
// ESTE ARCHIVO CONTIENE DATOS QUE SON USADOS EN LA MAYORIA DE LAS PAGINAS DEL APP

//definicion de variables globales que se usaran en todo el gestor
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

//llamar a clase con las opciones basica del sitio
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$objDataBase = new DataBase;
require_once(ABSPATH.'rb-script/funciones.php');

// verifica datos en tabla, sino inicial el instalador
$q = $objDataBase->Ejecutar("SELECT * FROM opciones");
if($q->num_rows==0){
	header('Location: ../rb-install/index.php');
}
//enlaces amigables
define('G_ENL_AMIG', rb_get_values_options('enlaceamigable'));

//nombre del servidor http
define('G_SERVER', rb_get_values_options('direccion_url'));

//si el sitio esta en un directorio
define('G_DIRECTORY', rb_get_values_options('directorio_url'));

// nombre pagina con extension. Ej. De "http://emocion.pe" a "emocion.pe"
$s = parse_url(G_SERVER);
define('G_HOSTNAME', $s['host']);

//numero registros
define('G_NUMREGS', rb_get_values_options('num_registers'));

//tema usado o guardado en cookies
define('G_CSS', rb_get_values_options('css_style'));
if(isset($_COOKIE['_ribosoma_style'])){
	define('G_ESTILO', $_COOKIE['_ribosoma_style']);
}else{
	define('G_ESTILO', rb_get_values_options('tema'));
}
//valores titulo y descripcion
define('G_TITULO', rb_get_values_options('nombresitio'));
define('G_SUBTITULO', rb_get_values_options('descripcion'));

//informacion sobre meta tags
define('G_METAKEYWORDS', rb_get_values_options('meta_keywords'));
define('G_METADESCRIPTION', rb_get_values_options('meta_description'));
define('G_METAAUTHOR', rb_get_values_options('meta_author'));

// mails destination
define('G_MAILS', rb_get_values_options('mail_destination'));

// mail sender
define('G_MAILSENDER', rb_get_values_options('mail_sender'));

//cuando mostrar en categoria, index, u otras listas
define('G_POSTPAGE', rb_get_values_options('post_by_category'));

//define directorio del la url del tema
define('G_URLTHEME',rb_get_values_options('direccion_url')."/rb-temas/".rb_get_values_options('tema'));

// codigo pagina inicial
define('G_INITIAL', rb_get_values_options('initial'));

// muestra o no, link para registro de usuario
define('G_LINKREGISTER', rb_get_values_options('linkregister'));

// formulario de contacto
define('G_FORM', rb_get_values_options('form_code'));

// ancho y alto thumbnails por defecto
define('G_TWIDTH', rb_get_values_options('t_width'));
define('G_THEIGHT', rb_get_values_options('t_height'));

// menu principal a mostrar
define('G_MAINMENU', rb_get_values_options('mainmenu_id'));

// moneda
define('G_COIN', rb_get_values_options('moneda'));

// slide principal
define('G_SLIDEMAIN', rb_get_values_options('slide_main'));

// logo
define('G_LOGO', rb_get_values_options('logo'));

// mail libreria externa
define('G_LIBMAILNATIVE', rb_get_values_options('lib_mail_native'));

// base url links amigables
define('G_BASEPUB', rb_get_values_options('base_publication'));
define('G_BASECAT', rb_get_values_options('base_category'));
define('G_BASEUSER', rb_get_values_options('base_user'));
define('G_BASESEAR', rb_get_values_options('base_search'));
define('G_BASEPAGE', rb_get_values_options('base_page'));

define('G_USERACTIVE', rb_get_values_options('user_active_admin'));
define('G_ALCANCE', rb_get_values_options('alcance'));

// Zona horaria por defecto
date_default_timezone_set('UTC');

//variable global para sesion activa
session_start();

if(isset($_SESSION['usr']) and isset($_SESSION['pwd'])){
	define('G_ACCESOUSUARIO',1);
	define('G_USERID', $_SESSION['usr_id']);
	define('G_USERTYPE', $_SESSION['type']);
	define('G_USERNIVELID', $_SESSION['nivel_id']);
}else{
	define('G_ACCESOUSUARIO',0);
	define('G_USERID', 0);
	define('G_USERTYPE', 0);
	define('G_USERNIVELID', 0);
}

$carrito = array();
if(!isset($_SESSION['carrito'])){
	$_SESSION['carrito'] = $carrito;
}
?>
