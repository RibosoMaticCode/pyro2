<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';

if ( isset($_GET['plm_product_term']) ):
  if(G_ENL_AMIG) header( 'Location: '.G_SERVER.'/products/search/'.rb_cambiar_nombre(trim($_GET['plm_product_term'])).'/' );
	else header( 'Location: '.G_SERVER.'/?product_search='.rb_cambiar_nombre(trim($_GET['plm_product_term'])) );
  exit();
endif;
?>
