<!-- MODAL WINDOWS HTML EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<?php
$fname = $_SERVER['DOCUMENT_ROOT'].G_DIRECTORY."/rb-temas/".G_ESTILO."/css/styles-add.css";
$myfile = fopen($fname, "r") or die("¡No se puede abrir el archivo!");
$content = fread($myfile,filesize($fname));
fclose($myfile);
?>
<div id="editor-css" class="editor-window">
	<form id="form-editor-css">
		<div class="editor-header">
			<strong>Editor de estilos CSS adicionales</strong>
		</div>
		<div class="editor-body" style="min-height:400px;">
			<input type="hidden" name="file_name" value="<?= $fname ?>"/>
			<textarea name="file_content" rows="8" style="display:none;"></textarea>
			<div id="editor-css-content"><?= $content ?></div>
		</div>
		<div class="editor-footer">
			<button type="submit" class="btn-primary" id="editor-css-btn-accept">Cambiar</button>
			<button type="button" class="button" id="editor-css-btn-cancel">Cancelar</button>
		</div>
	</form>
	<script src="http://ajaxorg.github.io/ace-builds/src/ace.js" charset="utf-8"></script>
	<script>
	    var editor = ace.edit("editor-css-content");
	    //editor.setTheme("ace/theme/monokai");
	    editor.getSession().setMode("ace/mode/css");

			var textarea = $('textarea[name="file_content"]');
			editor.getSession().on("change", function () {
			    textarea.val(editor.getSession().getValue());
			});
	</script>

	<script>
	$(function() {
		// Accept //
	  $('#editor-css-btn-accept').click(function() {
			event.preventDefault();
	  	$.ajax({
		  	method: "POST",
		  	url: "<?= G_SERVER ?>/rb-admin/core/pages2/write-file-css.php",
		  	data: $( "#form-editor-css" ).serialize()
			}).done(function( msg ) {
				console.log(msg);
			});
			$('.bg-opacity, #editor-css').hide();
	  });
		// Cancel //
		$('#editor-css-btn-cancel').click(function() {
			$('.bg-opacity, #editor-css').hide();
	  });
	});
	</script>
</div>
