<!-- EDITOR AND CONFIGURATION: HTML -->
<div id="editor-html" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del contenido</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container form">
			<div class="cols-6-md spacing-right">
				<label>Class CSS
					<input type="text" name="class_css" id="class_css" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
			</div>
		</div>
		<div id="ta">
		  <p>Editor de html</p>
		</div>
	</div>
	<div class="editor-footer">
		<button class="button btn-primary" id="btn1">Cambiar</button>
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
		// Mostrar editor
		$("#boxes").on("click", ".showEditHtml", function (event) {
	    $(".bg-opacity").show();
	    $("#editor-html").show();
	    event.preventDefault();
	    var col_id = $(this).closest(".widget").attr('id');
	    var box_edit_html = $(this).closest(".widget-body").find(".box-edit-html");
	    var content_to_edit = box_edit_html.html();
	    var content_to_edit_id = box_edit_html.attr('id');
	    $('#control_edit_id').val(content_to_edit_id);
	    tinymce.activeEditor.setContent(content_to_edit);
	    var css_class = $(this).closest(".widget").attr('data-class');
	    $('#control_id').val(col_id);
	    $('#class_css').val(css_class);
	  });

		// Enviando los valores
	  $('#btn1').click(function() {
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
