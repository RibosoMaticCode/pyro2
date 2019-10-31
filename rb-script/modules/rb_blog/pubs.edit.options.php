<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/funcs.php";
require_once "funcs.php";
$json_post_options = blog_get_option('post_options');
$array_post_options = json_decode($json_post_options, true);
?>
<script>
	$( "#close" ).click(function( event ) {
		event.preventDefault();
		$(".bg-opacity").hide();
		$(".explorer").hide();
		$(".explorer").empty();
	});

	$( "#frm-posts-options" ).submit(function(event) {
		event.preventDefault();
		$.ajax({
			data: $( "#frm-posts-options" ).serialize(),
  			url: "<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.edit.options.save.php",
  		})
  		.done(function( data ) {
  			var msg;
				if(data=="0"){
					msg = "Ocurrio un problema. Vuelta a cargar la pagina e intente nuevamente";
				}else{
					$("#frm-posts-options input[type='checkbox']").each(function(){
						var nam = $(this).attr('id');
						var res = nam.substr(-3);
				    if($("#"+nam).is(":checked")){
							$("#post-"+res).show();
				    }else{
							$("#post-"+res).hide();
						}
					});
					console.log(data);
					$( "#close" ).click();
				}
    		$( "#frm-posts-options-result" ).html(msg);
  		});
	});
</script>
<div class="explorer-header">
	<h3>Funciones adicionales</h3>
	<a id="close" href="#">×</a>
</div>
<div class="explorer-body">
<?php
$seccion = $_GET['s'];
switch($seccion):
	case 'posts':
		?>
		<form id="frm-posts-options" class="form" action="post.options.save.php" method="post">
			<div class="cols-container">
				<div class="cols-6-md">
					<label>
					<input id="postcheck-gal" type="checkbox" name="post_options[gal]" value="1" <?php if($array_post_options['gal']==1) echo "checked" ?> /> Galería e imágenes
					<span class="info">
						Permite crear y relacionar una galería de imagenes con la publicación
					</span>
					</label>
				</div>
				<div class="cols-6-md">
					<label>
					<input id="postcheck-adj" type="checkbox" name="post_options[adj]" value="1" <?php if($array_post_options['adj']==1) echo "checked" ?> /> Adjuntar imagenes destacadas
					<span class="info">
						Habilita la opción para adjuntar imagen de portada y perfil
					</span>
					</label>
				</div>
			</div>
			<div class="cols-container">
				<div class="cols-6-md">
					<label>
					<input id="postcheck-edi" type="checkbox" name="post_options[edi]" value="1" <?php if($array_post_options['edi']==1) echo "checked" ?> /> Opciones de edición
					<span class="info">
						Permite añadir otras opciones para la publicación.
					</span>
					</label>
				</div>
				<div class="cols-6-md">
					<label>
					<input id="postcheck-adi" type="checkbox" name="post_options[adi]" value="1" <?php if($array_post_options['adi']==1) echo "checked" ?> /> Campos adicionales
					<span class="info">
						Permite especificar valores adicionales a los campos personalizados. Ir a Configuracion para establecer los campos adicionales.
					</span>
					</label>
				</div>
			</div>
			<div class="cols-container">
				<div class="cols-6-md">
					<label>
					<input id="postcheck-enl" type="checkbox" name="post_options[enl]" value="1" <?php if($array_post_options['enl']==1) echo "checked" ?> /> Enlazar con publicación
					<span class="info">
						Permite enlazar la publicación con otra.
					</span>
					</label>
				</div>
				<div class="cols-6-md">
					<label>
					<input id="postcheck-sub" type="checkbox" name="post_options[sub]" value="1" <?php if($array_post_options['sub']==1) echo "checked" ?> /> Subir imágenes
					<span class="info">
						Habilita la opción de subir imágenes y otros archivos permitidos.
					</span>
					</label>
				</div>
			</div>
			<div class="cols-container">
				<!--<div class="cols-6-md">
					<label>
					<input id="postcheck-cal" type="checkbox" name="post_options[cal]" value="1" <?php if($array_post_options['cal']==1) echo "checked" ?> /> Calendario
					<span class="info">
						Habilita un calendario, para seleccionar una fecha especifica.
					</span>
					</label>
				</div>-->
				<div class="cols-6-md">
					<label>
					<input id="postcheck-otr" type="checkbox" name="post_options[otr]" value="1" <?php if($array_post_options['otr']==1) echo "checked" ?> /> Otras opciones
					<span class="info">
						Otras opciones para la publicación
					</span>
					</label>
				</div>
			</div>
		<ul class="options-list">

		</ul>
		<button id="btnSaveOpc" class="button btn-primary">Guardar cambios</button>
		</form>
		<div id="frm-posts-options-result"></div>
		<?php
	break;
endswitch;
?>
</div>
