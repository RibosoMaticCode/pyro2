<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/funciones.php";

/* usuarios que sera notificado */
$user_superadmin_string = "";
if( isset($_POST['user_superadmin']) ){
  $user_superadmin = $_POST['user_superadmin'];
  $user_superadmin_string = '{"admin":"'.implode(',', $user_superadmin).'"}';
}else {
	$user_superadmin_string = '{"admin":"1"}';
}

/* ==== RESTRICCION DE ENVIO DE MENSAJES INTERNOS ==== */
$user_send_string = "0";
if( isset($_POST['user_send']) ){
  $user_send = $_POST['user_send'];
  $user_send_string = implode(',', $user_send);
}
$user_receive_string = "0";
if( isset($_POST['user_receive']) ){
  $user_receive = $_POST['user_receive'];
  $user_receive_string = implode(',', $user_receive);
}
$user_admin_string = "0";
if( isset($_POST['user_admin']) ){
  $user_admin = $_POST['user_admin'];
  $user_admin_string = implode(',', $user_admin);
}
$send_copy = 0;
if( isset($_POST['sendcopy']) ){
  $send_copy = 1; // $_POST['sendcopy'];
}

$string_json_restric = '{"send_users":"'.$user_send_string.'", "receive_users": "'.$user_receive_string.'", "admin_users":"'.$user_admin_string.'", "notify": '.$send_copy.'}';
/* ==== RESTRICCION DE ENVIO DE MENSAJES INTERNOS ==== */

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
$mail_sender = $_POST['mailsender'];
$name_sender = $_POST['namesender'];
$mails = $_POST['mails'];
$inicial = $_POST['inicial'];
$post_by_category = $_POST['post_by_category'];
$linkregister = $_POST['linkregister'];
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
rb_set_values_options('mail_destination',$mails);
rb_set_values_options('name_sender',$name_sender);
rb_set_values_options('mail_sender',$mail_sender);
rb_set_values_options('initial',$inicial);
rb_set_values_options('post_by_category',$post_by_category);
rb_set_values_options('linkregister',$linkregister);
rb_set_values_options('t_width',$t_width);
rb_set_values_options('t_height',$t_height);
rb_set_values_options('favicon', $_POST['favicon_id']);
rb_set_values_options('logo', $_POST['logo_id']);
rb_set_values_options('background-image', $_POST['bgimage_id']);
rb_set_values_options('terms_url', $_POST['terms_url']);
rb_set_values_options('index_custom', $_POST['index_custom']);
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

rb_set_values_options('message_config_restrict', $string_json_restric);
rb_set_values_options('user_superadmin', $user_superadmin_string);

rb_set_values_options('block_header_ids', $_POST['block_header_id']);
rb_set_values_options('block_footer_ids', $_POST['block_footer_id']);

rb_set_values_options('show_terms_register', $_POST['show_terms_register']);
rb_set_values_options('pass_security', $_POST['pass_security']);
rb_set_values_options('more_fields_register', $_POST['more_fields_register']);
rb_set_values_options('after_login_url', trim($_POST['after_login_url']));

$urlreload=G_SERVER."/rb-admin/index.php?pag=opc&m=ok";
header('Location: '.$urlreload);
?>
