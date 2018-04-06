<!-- MODAL WINDOWS HTML EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-html-raw" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del contenido</strong>
	</div>
	<div class="editor-body">
			<div class="cols-container">
				<div class="cols-6-md spacing-right">
					<label>Class CSS
						<input type="text" name="htmlraw_css" id="htmlraw_css" />
					</label>
				</div>
				<div class="cols-6-md spacing-left">
				</div>
			</div>
			<div>
			  <textarea id="htmlraw_text_hidden" name="htmlraw_text_hidden" rows="5"></textarea>
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
	<script src="http://ajaxorg.github.io/ace-builds/src/ace.js" charset="utf-8"></script>
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
