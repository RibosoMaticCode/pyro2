<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once "funcs.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_blog_config';
?>
<div class="inside_contenedor_frm">
<section class="seccion">
  <div class="seccion-header">
    <h2>Configuracion</h2>
  </div>
  <div class="seccion-body">
    <form id="form_plm_config" class="form">
      <div class="cols-container">
        <div class="cols-6-md">
					Numero de Publicaciones por Página:
					<span class="info">Cantidad de publicaciones a mostrar en el index (por defecto) y por categoria.</span>
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[num_pubs_by_pages]" value='<?= blog_get_option('num_pubs_by_pages') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
					Campos adicionales en el editor
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[objetos]" value='<?= blog_get_option('objetos') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
					URL base para publicaciones
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[base_publication]" value='<?= blog_get_option('base_publication') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
					URL base para categorias
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[base_category]" value='<?= blog_get_option('base_category') ?>' />
        </div>
      </div>
      <div class="cols-container">
        <div class="cols-6-md">
          Plantilla listado de categorias
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[design_categories_list]" value='<?= blog_get_option('design_categories_list') ?>' />
        </div>
      </div>
      <div class="cols-container">
        <div class="cols-6-md">
          Plantilla publicacion
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[design_post]" value='<?= blog_get_option('design_post') ?>' />
        </div>
      </div>
      <button class="button btn-primary" type="submit">Guardar configuracion</button>
    </form>
    <script>
    $(document).ready(function() {
      // Boton Guardar
      $('#form_plm_config').submit(function(event){
        event.preventDefault();
    		$.ajax({
    			method: "post",
    			url: "<?= G_SERVER ?>rb-script/modules/rb_blog/config.save.php",
    			data: $( this ).serialize()
    		})
    		.done(function( data ) {
    			if(data.resultado){
    				notify(data.contenido);
  					/*setTimeout(function(){
  	          window.location.href = '<?= $urlreload ?>';
  	        }, 1000);*/
    	  	}else{
    				notify(data.contenido);
    	  	}
    		});
      });
    });
    </script>
  </div>
</section>
<!--<section class="seccion">
  <div class="seccion-header">
    <h2>Shortcodes</h2>
  </div>
  <div class="seccion-body">
    <div class="cols-container">
      <div class="cols-6-md">
        Mostrar link con contador a carrito de compras
      </div>
      <div class="cols-6-md">
        <code>[PLM_LINK_CART]</code>
      </div>
    </div>
  </div>
</section>-->
</div>
