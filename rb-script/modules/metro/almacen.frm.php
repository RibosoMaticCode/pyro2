<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$rb_module_url = G_SERVER."/rb-script/modules/metro/";

$urlreload=G_SERVER.'/rb-admin/module.php?pag=predi_alm';

if(isset($_GET['id'])):
	$q = $objDataBase->Consultar("SELECT * FROM metro_almacen WHERE id=".$_GET['id']);
	$row = mysql_fetch_array($q);
endif;
?>
<script>
	$(document).ready(function() {
		$('#frmClientes').submit(function (){
			event.preventDefault();
			$.ajax({
				method: "post",
				url: "<?= $rb_module_url ?>almacen.save.php",
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.resultado=="ok"){
		    		$('#frmClientes').hide();
		    		$( "#result" ).show().delay(5000);
					$( "#result" ).html(data.contenido);
					setTimeout(function(){
						window.location.href = '<?= $urlreload ?>';
					}, 500);
		  		}else{
		  			$( "#result" ).show();
		  			$( "#result" ).html(data.contenido);
		  			$( "#result" ).delay(4000).fadeOut(1000);
		  		}
			});
		});

		$(".pub_img").filexplorer({
			inputHideValue : "<?= isset($row) ? $row['foto_id'] : "0" ?>"
		});
	})
</script>
<section class="seccion">
	<div class="seccion-body">
		<div id="result" style="text-align: center;"></div>
		<form id="frmClientes">
			<input type="hidden" name="alm_id" value="<?= isset($row) ? $row['id'] : '0' ?>" />
			<label>Nombre Almacen:
				<input type="text" name="nombre" required value="<?= isset($row) ? $row['nombre_almacen'] : '' ?>" />
			</label>
			<label>Detalles:
				<textarea name="detalles"><?= isset($row) ? $row['detalles'] : '' ?></textarea>
			</label>
			<label>Coordenadas:
				<input type="text" name="coordenadas" required value="<?= isset($row) ? $row['coordenadas'] : '' ?>" />
			</label>
			<label>Imagen:
				<input type="text" name="image" value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['foto_id']); echo $photos['src']; endif ?>" class="pub_img" />
			</label>
			<div class="text-center">
				<button class="btn-primary">Guardar datos</button>
			</div>
		</form>
	</div>
</section>
