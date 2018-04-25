<?php
header('Content-Type: application/javascript');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
?>
$(document).ready(function() {
  $(".form-login").submit(function( event ){
    event.preventDefault();

    $.ajax({
      method: "post",
      url: "<?= G_SERVER ?>/rb-script/modules/suscripciones/save.suscriptor.php",
      data: $( this ).serialize()
    })
    .done(function( data ) {
      if(data.resultado){
        $.fancybox.close();
        alert(data.contenido);
      }else{
        alert(data.contenido);
      }
    });
  });
});
