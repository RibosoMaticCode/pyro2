<?php
/*
Module Name: Popup (flotantes)
Plugin URI: http://emocion.pe
Description: Muestra una imagen flotante al cargar una pagina especifica
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
PageConfig: popup_config
*/

// Valores iniciales
$rb_modure_dir = "popup";
$rb_module_url = G_SERVER."rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."rb-script/modules/$rb_modure_dir/crm.png";

// ------ POPUP FLOTANTES -------- //
function popup_show(){
  $url_img = rb_get_values_options('popup_url_img');
  $img = rb_get_photo_details_from_id($url_img);
  $url_destination = rb_get_values_options('popup_url_destination');
	$frm_customer = '
  <img style="display:none" src="'.$img['file_url'].'" alt="preload-promo" />
  <a id="popup" class="fancy" style="display: none" href="'.$img['file_url'].'" data-fancybox-group="gal">Popup</a>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#popup").fancybox({
        padding: 0,
        afterShow: function () {
          $(".fancybox-image").wrap($("<a />", {
            href: "'.$url_destination.'"
          }));
				}
			}).trigger("click");
	  });
  </script>';
	return $frm_customer;
}

add_shortcode('POPUP','popup_show');


// --------------- CONFIGURADOR ------------------- //
if(isset($_GET['pag']) && $_GET['pag']=="popup_config"):
  function popup_title(){
		return "Configuracion de Popup";
	}

	function popup_main_content(){
		include_once 'popup.config.php';
	}
	add_function('module_title_page','popup_title');
	add_function('module_content_main','popup_main_content');
endif;
