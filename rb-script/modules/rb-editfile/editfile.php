<?php
$dir_style = $_SERVER['DOCUMENT_ROOT'].G_DIRECTORY."/rb-temas/".G_ESTILO."/";
$path_module = G_SERVER."/rb-script/modules/rb-editfile/";
?>
<style>
	.file_selected{
		background-color:yellow;
	}
	ul.file_item{
		padding:0 5px;
	}
	ul.file_item li{
		border: 1px solid #eaeaea;
		padding: 5px;
		background-color: #fbfbfb;
	}
	ul.file_item li .info{
		font-style:italic;
	}
</style>


<h2 class="title">Editar archivos de la plantilla</h2>
<div class="page-bar">Inicio > Apariencia > Editar Plantilla</div>

<?php if (!in_array("editpla", $array_help_close)): ?>
	<div class="help" data-name="editpla">
		<h4>Información</h4>
		<p>Puedes editar el código fuente de la plantilla diseñada. Un cambio incorrecto puede perjudicar todo el sitio web.</p>
	</div>
<?php endif ?>

<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-body">
			<div class="cols-container">
				<div class="cols-4-md">
					<ul class="file_item">
					<?php
					require('list.files.php');
					?>
					</ul>
				</div>
				<div class="cols-8-md">
					<form id="file_form" action="<?= G_SERVER ?>/rb-admin/modules/editfile/save.change.php" method="post">
					<div style="position:relative; min-height:500px">
						<textarea id="textarea" name="file_content" rows="30"></textarea>
						<div id="editor-css-content"></div>
					</div>
					<input type="text" id="file_name" name="file_name" readonly />
					<button class="btn-primary" type="submit">Guardar cambios</button>
					</form>
					<div id="file-result">
					</div>
				</div>
			</div>
			<p style="font-size:.9em;">Modulo: Editor de plantilla ver. 0.3 (beta)<br />
				0.3<br />
				- Codigo resaltado y lineas numeradas para mejor edicion.<br />
				0.2<br />
				- Permite ingresar a directorios si los tuviera la plantilla.<br />
				0.1<br />
				- Listado de archivo y edicion basica.<br />
			</p>
		</div>
	</section>
</div>
<script src="http://ajaxorg.github.io/ace-builds/src/ace.js" charset="utf-8"></script>
<script>
$(document).ready(function() {
	var editor = ace.edit("editor-css-content");
	editor.getSession().setMode("ace/mode/php");

	var textarea = $('textarea[name="file_content"]');
	editor.getSession().on("change", function () {
			textarea.val(editor.getSession().getValue());
	});
	/*
	 * Si es archivo, se muestra contenido ó
	 * Si es directorio, se muestra lista de archivos
	 */
	$(".file_item").on("click" , "li a.filename", function (event){
		$(".filename").removeClass('file_selected');

		$(this).addClass('file_selected');
		event.preventDefault();
		var tipo = $(this).attr("data-type");
		if(tipo=="file"){
			var fn = $(this).attr("href");
			$('#file_name').val(fn);
			console.log(fn);
			$.ajax({
			  	method: "GET",
			  	url: "<?= $path_module ?>readfile.php?filename="+fn
			}).done(function( msg ) {
			    //$('#textarea').val( msg );
					//$('#editor-css-content').html( msg );
					editor.setValue(msg);
			});
		}else if(tipo=="dir"){
			var fn = $(this).attr("href");
			$('#file_name').val(fn);
			console.log(fn);
			$.ajax({
			  	method: "GET",
			  	url: "<?= $path_module ?>list.files.php?dir="+fn
			}).done(function( msg ) {
			    $('.file_item').html(msg);
			});
		}

	});
	/*
	 * Si se pulsa sobre Guardar Cambios.
	 */
	$( "#file_form" ).submit(function( event ) {
	  	event.preventDefault();
	  	$.ajax({
		  	method: "POST",
		  	url: "<?= $path_module ?>save.change.php",
		  	data: $( "#file_form" ).serialize()
		}).done(function( msg ) {
			notify(msg);
		   // $('#file-result').html( msg );
		});
	});
});
</script>
