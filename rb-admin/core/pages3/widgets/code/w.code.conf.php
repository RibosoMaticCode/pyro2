<!-- EDITOR AND CONFIGURATION: CODE -->
<div id="editor-html-raw" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del contenido</strong>
	</div>
	<div class="editor-body">
			<div class="cols-container form">
				<div class="cols-6-md spacing-right">
					<label>Class CSS
						<input type="text" name="htmlraw_css" id="htmlraw_css" />
					</label>
				</div>
				<div class="cols-6-md spacing-left">
				</div>
			</div>
			<div>
			  <textarea id="htmlraw_text_hidden" name="htmlraw_text_hidden" rows="5" style="display:none"></textarea>
				<div style="height:400px" id="htmlraw_text"></div>
			</div>
	</div>
	<div class="editor-footer">
		<button class="btn-primary" id="html-raw-btn-accept">Cambiar</button>
		<button class="button" id="html-raw-btn-cancel">Cancelar</button>
		<!-- nombres de los controles -->
		<input type="hidden" id="htmlraw-control_id" value="" />
		<input type="hidden" id="htmlraw-control_edit_id" value="" />
	</div>
	<script src="https://ajaxorg.github.io/ace-builds/src/ace.js" charset="utf-8"></script>
	<script>
	    var editor1 = ace.edit("htmlraw_text");
	    //editor.setTheme("ace/theme/monokai");
	    editor1.getSession().setMode("ace/mode/html");

			var textarea1 = $('textarea[name="htmlraw_text_hidden"]');
			editor1.getSession().on("change", function () {
			    textarea1.val(editor1.getSession().getValue());
			});
	</script>
	<script>
	$(function() {
		// Mostrar la ventana de configuracion
		$("#boxes").on("click", ".showEditHtmlRaw", function (event) {
	    $(".bg-opacity").show();
	    $("#editor-html-raw").show();
	    event.preventDefault();
	    var col_id = $(this).closest(".widget").attr('id');
	    var box_edit_html = $(this).closest(".widget-body").find(".box-edit-html");
	    var content_to_edit = box_edit_html.html();
	    var content_to_edit_id = box_edit_html.attr('id');
	    $('#htmlraw-control_edit_id').val(content_to_edit_id);
	    //console.log(content_to_edit);
	    editor1.setValue(content_to_edit); // Set values to ACE editor
	    $('#htmlraw_text').val(content_to_edit);
	    //tinymce.activeEditor.setContent(content_to_edit);
	    var css_class = $(this).closest(".widget").attr('data-class');
	    $('#htmlraw-control_id').val(col_id);
	    $('#htmlraw_css').val(css_class);
	  });
		//Aceptar cambios
	  $('#html-raw-btn-accept').click(function() {
			var control_id = $('#htmlraw-control_id').val();
			$('#'+ control_id).attr('data-class', $('#htmlraw_css').val());
			var control_edit_id = $('#htmlraw-control_edit_id').val();
			$('#'+control_edit_id).html($('#htmlraw_text_hidden').val());
			$('.bg-opacity, #editor-html-raw').hide();
	  });
		$('#html-raw-btn-cancel').click(function() {
			$('.bg-opacity, #editor-html-raw').hide();
	  });
	});
	</script>
</div>
