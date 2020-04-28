<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/modules/plm/funcs.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=plm_config';
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
          Link (Seguir comprando)
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[link_continue_purchase]" value='<?= get_option('link_continue_purchase') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Activar cargo con tarjeta <span class="info">1:Culqi, 2:MercdoPago, 0:Desactivado</span>
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[plm_charge]" value='<?= get_option('plm_charge') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Clave publica
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[key_public]" value='<?= get_option('key_public') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Clave privada
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[key_private]" value='<?= get_option('key_private') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Cantidad productos por categoria
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[products_count_category]" value='<?= get_option('products_count_category') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Estilo visual de mostrar producto
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[frontview_product]" value='<?= get_option('frontview_product') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Pagina proceso satisfactorio
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[page_success]" value='<?= get_option('page_success') ?>' />
        </div>
      </div>
			<div class="cols-container">
        <div class="cols-6-md">
          Pagina proceso error
        </div>
        <div class="cols-6-md">
          <input type="text" name="options[page_error]" value='<?= get_option('page_error') ?>' />
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
    			url: "<?= G_SERVER ?>rb-script/modules/plm/config.save.php",
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
<section class="seccion">
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
		<div class="cols-container">
      <div class="cols-6-md">
        Mostrar cantidad de elementos en carrito de compras
      </div>
      <div class="cols-6-md">
        <code>[PLM_CART_COUNT]</code>
      </div>
    </div>
		<div class="cols-container">
      <div class="cols-6-md">
        Muestra lista de todos los productos
      </div>
      <div class="cols-6-md">
        <code>[PLM_PRODUCTS_INIT]</code>
      </div>
    </div>
		<div class="cols-container">
      <div class="cols-6-md">
        Muestra un formulario de busqueda de productos
      </div>
      <div class="cols-6-md">
        <code>[PLM_FRM_SEARCH]</code>
      </div>
    </div>
		<div class="cols-container">
      <div class="cols-6-md">
        Muestra listado de categorias en formato de menu desplegable horizontal.
      </div>
      <div class="cols-6-md">
        <code>[PLM_LIST_CATEGORIES]</code>
      </div>
    </div>
  </div>
</section>
</div>
