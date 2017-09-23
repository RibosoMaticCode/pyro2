<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$rb_module_url = G_SERVER."/rb-script/modules/info/";

$urlreload=G_SERVER.'/rb-admin/module.php?pag=info_pub';

// Data user
$qu = $objDataBase->Consultar("SELECT id, apellidos, nombres FROM usuarios WHERE id=".$_GET['id']); 
$row_user = mysql_fetch_array($qu);

if(isset($_GET['id'])):
	$q = $objDataBase->Consultar("SELECT * FROM informes_publicador WHERE user_id=".$_GET['id']); 
	$row = mysql_fetch_array($q);
endif;
?>
<script>	
$(document).ready(function() {		
	$('#frmPub').submit(function (event){
		event.preventDefault();
		$.ajax({
			method: "post",
			url: "<?= $rb_module_url ?>pubs.save.php",
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
})
</script>
<section class="seccion">
	<div class="seccion-body">
		<div id="result" style="text-align: center;"></div>
		<h2 style="text-align: center"><?= $row_user['apellidos'] ?>, <?= $row_user['nombres'] ?></h2>
		<form id="frmPub">
			<input type="hidden" name="user_id" value="<?= $row_user['id'] ?>" />
				
			<label>Fecha de Nacimiento:
				<input type="date" name="fec_nac" value="<?= isset($row) ? $row['fecha_nacimiento'] : '' ?>" />
			</label>
					
			<label>Fecha de Bautismo:
				<input type="date" name="fec_bau" value="<?= isset($row) ? $row['fecha_bautismo'] : '' ?>" />
			</label>
					
			<label>Puesto de responsabilidad:</label>
			<label>
				<input type="radio" name="responsabilidad" value="anc" <?php if(isset($row) && $row['puesto_responsabilidad'] == "anc") echo " checked "  ?> /> Anciano
			</label>
			<label>
				<input type="radio" name="responsabilidad" value="sm" <?php if(isset($row) && $row['puesto_responsabilidad'] == "sm") echo " checked "  ?> /> Siervo Ministerial
			</label>
			<label>
				<input type="radio" name="responsabilidad" value="" <?php if(isset($row) && $row['puesto_responsabilidad'] == "") echo " checked "  ?> /> Ninguno
			</label>
					
			<label>Puesto de servicio:</label>
			
			<label>
				<input type="radio" name="servicio" value="pub" <?php if(isset($row) && $row['puesto_servicio'] == "pub") echo " checked "  ?> /> Publicador
			</label>
			<label>
				<input type="radio" name="servicio" value="pa" <?php if(isset($row) && $row['puesto_servicio'] == "pa") echo " checked "  ?> /> Precursor Auxiliar
			</label>
			<label>
				<input type="radio" name="servicio" value="pr" <?php if(isset($row) && $row['puesto_servicio'] == "pr") echo " checked "  ?> /> Precursor Regular
			</label>
					
			<label>Observaciones:
				<textarea rows="4" name="observa"><?= isset($row) ? $row['observaciones'] : '' ?></textarea>
			</label>
			<div class="text-center">
				<button class="btn-primary">Guardar cambios</button>
			</div>
		</form>
	</div>
</section>