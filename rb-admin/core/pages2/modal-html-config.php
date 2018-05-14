<!-- MODAL WINDOWS HTML EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-html" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del contenido</strong>
	</div>
	<div class="editor-body">
			<div class="cols-container">
				<div class="cols-6-md spacing-right">
					<label>Class CSS
						<input type="text" name="class_css" id="class_css" />
					</label>
				</div>
				<div class="cols-6-md spacing-left">
					<!--<label>ID CSS
						<input type="text" name="id_css" id="id_css" />
					</label>-->
				</div>
			</div>
			<div id="ta">
			  <p>Editor de html</p>
			</div>
	</div>
	<div class="editor-footer">
		<button class="btn-primary" id="btn1">Cambiar</button>
		<button class="button" id="btn2">Cancelar</button>
		<!-- nombres de los controles -->
		<input type="hidden" id="control_id" value="" />
		<input type="hidden" id="control_edit_id" value="" />
	</div>
	<?php
	include_once("../rb-admin/tinymce/tinymce.config.php");
	?>
	<script>
	$(function() {
	  $('#btn1').click(function() {
			// Enviando los valores
			// - Contenido
			var control_id = $('#control_id').val();
			$('#'+ control_id).attr('data-class', $('#class_css').val());
			var control_edit_id = $('#control_edit_id').val();
			$('#'+control_edit_id).html(tinymce.activeEditor.getContent());
			// - Nombre de la clase
			//var css_box_id = $('#css_box_id').val();
			//$('#'+css_box_id).val($('#class_css').val());
			$('.bg-opacity, #editor-html').hide();
	  });
		
		$('#btn2').click(function() {
			$('.bg-opacity, #editor-html').hide();
	  });
	});
	</script>
</div>
