<?php
//include 'islogged.php';
require_once("../rb-script/class/rb-opciones.class.php");
// DESTRIPAR VALOR JSON DE modules_options
$json_post_options = $objOpcion->obtener_valor(1,'post_options');
$array_post_options = json_decode($json_post_options, true);
?>
<script>
	$( "#close" ).click(function( event ) {
		event.preventDefault();
		$(".bg-opacity").hide();
		$(".explorer").hide();
   		$(".explorer").empty();
	});

	$( "#frm-posts-options" ).submit(function() {
		event.preventDefault();
		$.ajax({
			data: $( "#frm-posts-options" ).serialize(),
  			url: "post.options.save.php",
  		})
  		.done(function( data ) {
  			var msg;
	  		switch(data){
	  			case "0":
	  				msg = "Ocurrio un problema. Vuelta a cargar la pagina e intente nuevamente";
	  			break;
	  			case "1":
	  				msg = "!Cambios guardados! Se cargar la página";
	  				window.location.href = '<?= $objOpcion->obtener_valor(1,'direccion_url') ?>/rb-admin/?pag=art&opc=nvo';
	  			break;
	  		}
    		$( "#frm-posts-options-result" ).html(msg);
  		});
	});
</script>
<div class="explorer-header">
	<h3>Configuración adicional</h3>
	<a id="close" href="#">×</a>
</div>
<div class="explorer-body">
<?php
$seccion = $_GET['s'];
switch($seccion):
	case 'posts':
		?>
		<form id="frm-posts-options" action="post.options.save.php" method="post">
		<ul class="options-list">
			<li>
				<label>
				<input type="checkbox" name="post_options[gal]" value="1" <?php if($array_post_options['gal']==1) echo "checked" ?> /> Galería e imágenes
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[adj]" value="1" <?php if($array_post_options['gal']==1) echo "checked" ?> /> Archivos adjuntos
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[edi]" value="1" <?php if($array_post_options['edi']==1) echo "checked" ?> /> Opciones de edición
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[adi]" value="1" <?php if($array_post_options['adi']==1) echo "checked" ?> /> Campos adicionales
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[enl]" value="1" <?php if($array_post_options['enl']==1) echo "checked" ?> /> Enlazar con publicación
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[vid]" value="1" <?php if($array_post_options['vid']==1) echo "checked" ?> /> Videos de Youtube
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[cal]" value="1" <?php if($array_post_options['cal']==1) echo "checked" ?> /> Calendario
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[otr]" value="1" <?php if($array_post_options['otr']==1) echo "checked" ?> /> Otras opciones
				</label>
			</li>
			<li>
				<label>
				<input type="checkbox" name="post_options[sub]" value="1" <?php if($array_post_options['sub']==1) echo "checked" ?> /> Subir imágenes
				</label>
			</li>
		</ul>
		<button class="btn-submit">Guardar cambios</button>
		</form>
		<div id="frm-posts-options-result"></div>
		<?php
	break;
endswitch;
?>
</div>
