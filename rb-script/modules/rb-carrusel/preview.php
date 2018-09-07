<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

require_once ABSPATH.'rb-admin/hook.php';
$modules_prev = rb_get_values_options('modules_load');
$array_modules = json_decode($modules_prev, true);
require_once ABSPATH.'rb-admin/modules.list.php';

// VARIABLES CON DATOS DE CABECERA GENERALES
define('rm_titlesite', G_TITULO);
define('rm_subtitle', G_SUBTITULO);
define('rm_longtitle' , G_TITULO . ( G_SUBTITULO=="" ? "" :  " - ".G_SUBTITULO ));
define('rm_url', G_SERVER."/" );
define('rm_urltheme', G_URLTHEME."/");
define('rm_datetoday', date("Y-m-d"));
define('rm_mainmenu', G_MAINMENU);

$id = $_GET['id'];

define('rm_title', "Previsualizacion de Carrusel | ".G_TITULO);
define('rm_title_page', "Previsualizacion de Carrusel");
define('rm_metakeywords', "");
define('rm_metadescription', "");
define('rm_metaauthor',G_METAAUTHOR);

rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <div class="wrap-votos clear">
      <?php
      echo rb_shortcode('[carrusel id="'.$id.'"]');
      ?>
    </div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
