<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/modules/hotel/funcs.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=hotel_config';
?>
<div class="inside_contenedor_frm">
<section class="seccion">
  <div class="seccion-header">
    <h2>Configuracion</h2>
  </div>
  <div class="seccion-body">
    <form id="form_config" class="form">
      <div class="cols-container">
        <div class="cols-6-md">
          Hora llegada (check in)
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[hora_llegada]" value='<?= get_option('hora_llegada') ?>' />
        </div>
      </div>
      <div class="cols-container">
        <div class="cols-6-md">
          Hora salida (check out)
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[hora_salida]" value='<?= get_option('hora_salida') ?>' />
        </div>
      </div>
      <!--<div class="cols-container">
        <div class="cols-6-md">
          Servicios disponibles
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[servicios_list]" value='<?= get_option('servicios_list') ?>' />
        </div>
      </div>-->
      <button class="button btn-primary" type="submit">Guardar configuracion</button>
    </form>
    <script>
    $(document).ready(function() {
      // Boton Guardar
      $('#form_config').submit(function(event){
        event.preventDefault();
    		$.ajax({
    			method: "post",
    			url: "<?= G_SERVER ?>rb-script/modules/hotel/config.save.php",
    			data: $( this ).serialize()
    		})
    		.done(function( data ) {
    			if(data.resultado){
    				notify(data.contenido);
    	  	}else{
    				notify(data.contenido);
    	  	}
    		});
      });
    });
    </script>
  </div>
</section>
</div>
