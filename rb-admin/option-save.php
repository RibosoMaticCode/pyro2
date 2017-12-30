<?php
require_once("../global.php");
require_once("../rb-script/funciones.php");

$nombresitio = $_POST['nombresitio'];
//quitar "/" final de direccion
function quitar_barra($direccionurl){
  $barra = substr($direccionurl,-1);
  if($barra == "/"):
    $direccionurl = substr($direccionurl,0,-1);
    return quitar_barra($direccionurl);
  else:
    return $direccionurl;
  endif;
}

$direccionurl = quitar_barra($_POST['direccionurl']); // direccion_url sin slash al final
$siteurl = "http://".$_SERVER['SERVER_NAME']; // url_del_sitio
$directoriourl = str_replace($siteurl, "", $direccionurl); // quita http:// y url_del_sitio
$descripcion = $_POST['descripcion'];
$meta_keywords = $_POST['keywords'];
$meta_description = $_POST['description'];
$meta_author = $_POST['author'];
$tema = $_POST['tema'];
$enlaceamigable = $_POST['amigable'];
$objetos = $_POST['objetos'];
$mail_sender = $_POST['mailsender'];
$name_sender = $_POST['namesender'];
$mails = $_POST['mails'];
$inicial = $_POST['inicial'];
$post_by_category = $_POST['post_by_category'];
$linkregister = $_POST['linkregister'];
$mainmenu_id = $_POST['menu'];
$t_width = $_POST['t_width'];
$t_height = $_POST['t_height'];

rb_set_values_options('nombresitio',$nombresitio);
rb_set_values_options('direccion_url',$direccionurl);
rb_set_values_options('directorio_url',$directoriourl);
rb_set_values_options('descripcion',$descripcion);
rb_set_values_options('meta_keywords',$meta_keywords);
rb_set_values_options('meta_description',$meta_description);
rb_set_values_options('meta_author',$meta_author);
rb_set_values_options('tema',$tema);
rb_set_values_options('enlaceamigable',$enlaceamigable);
rb_set_values_options('objetos',$objetos);
rb_set_values_options('mail_destination',$mails);
rb_set_values_options('name_sender',$name_sender);
rb_set_values_options('mail_sender',$mail_sender);
rb_set_values_options('initial',$inicial);
rb_set_values_options('slide_main', $_POST['slide']);
rb_set_values_options('post_by_category',$post_by_category);
rb_set_values_options('linkregister',$linkregister);
rb_set_values_options('mainmenu_id',$mainmenu_id);
rb_set_values_options('t_width',$t_width);
rb_set_values_options('t_height',$t_height);
rb_set_values_options('logo', $_POST['logo_id']);
rb_set_values_options('background-image', $_POST['bgimage_id']);
rb_set_values_options('terms_url', $_POST['terms_url']);
rb_set_values_options('map-x', $_POST['map-x']);
rb_set_values_options('map-y', $_POST['map-y']);
rb_set_values_options('map-zoom', $_POST['map-zoom']);
rb_set_values_options('map-desc', addslashes($_POST['map-desc']));
// redes sociales
rb_set_values_options('fb', $_POST['fb']);
rb_set_values_options('tw', $_POST['tw']);
rb_set_values_options('gplus', $_POST['gplus']);
rb_set_values_options('in', $_POST['in']);
rb_set_values_options('insta', $_POST['insta']);
rb_set_values_options('youtube', $_POST['youtube']);
rb_set_values_options('pin', $_POST['pin']);
rb_set_values_options('whatsapp', $_POST['whatsapp']);
// bases url
rb_set_values_options('base_publication', $_POST['base_pub']);
rb_set_values_options('base_category', $_POST['base_cat']);
rb_set_values_options('base_search', $_POST['base_bus']);
rb_set_values_options('base_user', $_POST['base_usu']);
rb_set_values_options('base_page', $_POST['base_pag']);

rb_set_values_options('user_active_admin', $_POST['user_active_admin']);
rb_set_values_options('nivel_user_register', $_POST['nivel_user_register']);
rb_set_values_options('alcance', $_POST['alcance']);
rb_set_values_options('sidebar', $_POST['sidebar']);
rb_set_values_options('sidebar_pos', $_POST['sidebar_pos']);
$urlreload=G_SERVER."/rb-admin/index.php?pag=opc&m=ok";
header('Location: '.$urlreload);
?>
