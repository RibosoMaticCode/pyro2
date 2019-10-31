<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$url_img = rb_get_values_options('popup_url_img');
if(empty($url_img)){
  $url_img = 0;
}
$url_destination = rb_get_values_options('popup_url_destination');
?>
<div class="cols-container">
  <div class="cols-6-md col-padding">
    <section class="seccion">
      <div class="seccion-header">
        <h2>Configuracion</h2>
      </div>
      <div class="seccion-body">
        <form class="form" id="frmConfigPopup">
          <label>
            <script>
            $(document).ready(function() {
              $(".url_img").filexplorer({
                inputHideValue: "<?=  $url_img ?>"
              });
            });
            </script>
            <?php
            $photo = rb_get_photo_details_from_id( $url_img );
            ?>
            Ruta de imagen
            <input class="url_img" type="text" name="popup_url_img" readonly value="<?= $photo['file_url'] ?>" required />
          </label>
          <label>
            Ruta de url destino
            <input type="text" name="popup_url_destination" value="<?= $url_destination ?>" required />
          </label>
          <button type="submit">Guardar</button>
        </form>
      </div>
    </section>
  </div>
  <div class="cols-6-md col-padding">
    <section class="seccion">
      <div class="seccion-header">
        <h2>Uso</h2>
      </div>
      <div class="seccion-body">
        <p>Copia y pegar este codigo, dentro de la pagina(s) donde quieres mostrar el pop-up</p>
        <p><code>[popup]</code></p>
      </div>
    </section>
  </div>
</div>
<script>
$(document).ready(function() {
	$('#frmConfigPopup').submit(function (event){
		event.preventDefault();
		$.ajax({
			method: "post",
			url: "<?= G_SERVER ?>rb-script/modules/popup/popup.saveconfig.php",
			data: $( this ).serialize()
		})
		.done(function( data ) {
			if(data.result){
				notify(data.contenido);
				setTimeout(function(){
					window.location.href = '<?= G_SERVER ?>rb-admin/module.php?pag=popup_config';
				}, 800);
	  	}else{
				notify(data.contenido);
	  	}
		});
	});
})
</script>
