<?php
// ESTE ARCHIVO CONTIENE DATOS QUE SON USADOS EN LA MAYORIA DE LAS PAGINAS DEL APP

//definicion de variables globales que se usaran en todo el gestor
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

//llamar a clase con las opciones basica del sitio
require(ABSPATH."rb-script/class/rb-opciones.class.php");

// verifica datos en tabla, sino inicial el instalador
$q = $objOpcion->Consultar("SELECT * FROM opciones");
if(mysql_num_rows($q)==0){
	header('Location: ../rb-install/index.php');
}

//enlaces amigables
define('G_ENL_AMIG', $objOpcion->obtener_valor(1,'enlaceamigable'));

//nombre del servidor http
define('G_SERVER', $objOpcion->obtener_valor(1,'direccion_url'));

//si el sitio esta en un directorio
define('G_DIRECTORY', $objOpcion->obtener_valor(1,'directorio_url'));

// nombre pagina con extension. Ej. De "http://emocion.pe" a "emocion.pe"
$s = parse_url(G_SERVER);
define('G_HOSTNAME', $s['host']);

//numero registros
define('G_NUMREGS', $objOpcion->obtener_valor(1,'num_registers'));

//tema usado o guardado en cookies
define('G_CSS', $objOpcion->obtener_valor(1,'css_style'));
if(isset($_COOKIE['_ribosoma_style'])){
	define('G_ESTILO', $_COOKIE['_ribosoma_style']);
}else{
	define('G_ESTILO', $objOpcion->obtener_valor(1,'tema'));
}
//valores titulo y descripcion
define('G_TITULO', $objOpcion->obtener_valor(1,'nombresitio'));
define('G_SUBTITULO', $objOpcion->obtener_valor(1,'descripcion'));

//informacion sobre meta tags
define('G_METAKEYWORDS', $objOpcion->obtener_valor(1,'meta_keywords'));
define('G_METADESCRIPTION', $objOpcion->obtener_valor(1,'meta_description'));
define('G_METAAUTHOR', $objOpcion->obtener_valor(1,'meta_author'));

// mails destination
define('G_MAILS', $objOpcion->obtener_valor(1,'mail_destination'));

// mail sender
define('G_MAILSENDER', $objOpcion->obtener_valor(1,'mail_sender'));

//cuando mostrar en categoria, index, u otras listas
define('G_POSTPAGE', $objOpcion->obtener_valor(1,'post_by_category'));

//define directorio del la url del tema
define('G_URLTHEME',$objOpcion->obtener_valor(1,'direccion_url')."/rb-temas/".$objOpcion->obtener_valor(1,'tema'));

// codigo pagina inicial
define('G_INITIAL', $objOpcion->obtener_valor(1,'initial'));

// muestra o no, link para registro de usuario
define('G_LINKREGISTER', $objOpcion->obtener_valor(1,'linkregister'));

// formulario de contacto
define('G_FORM', $objOpcion->obtener_valor(1,'form_code'));

// ancho y alto thumbnails por defecto
define('G_TWIDTH', $objOpcion->obtener_valor(1,'t_width'));
define('G_THEIGHT', $objOpcion->obtener_valor(1,'t_height'));

// menu principal a mostrar
define('G_MAINMENU', $objOpcion->obtener_valor(1,'mainmenu_id'));

// moneda
define('G_COIN', $objOpcion->obtener_valor(1,'moneda'));

// slide principal
define('G_SLIDEMAIN', $objOpcion->obtener_valor(1,'slide_main'));

// logo
define('G_LOGO', $objOpcion->obtener_valor(1,'logo'));

// mail libreria externa
define('G_LIBMAILNATIVE', $objOpcion->obtener_valor(1,'lib_mail_native'));

// base url links amigables
define('G_BASEPUB', $objOpcion->obtener_valor(1,'base_publication'));
define('G_BASECAT', $objOpcion->obtener_valor(1,'base_category'));
define('G_BASEUSER', $objOpcion->obtener_valor(1,'base_user'));
define('G_BASESEAR', $objOpcion->obtener_valor(1,'base_search'));
define('G_BASEPAGE', $objOpcion->obtener_valor(1,'base_page'));

define('G_USERACTIVE', $objOpcion->obtener_valor(1,'user_active_admin'));
define('G_ALCANCE', $objOpcion->obtener_valor(1,'alcance'));

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
