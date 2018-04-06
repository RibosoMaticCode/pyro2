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
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
	<script>
	$(function() {
		tinymce.init({
			selector: '#ta',
			entity_encoding : "raw",
			menubar: false,
			convert_urls : false,
			language_url : '<?= G_SERVER ?>/rb-admin/tinymce/langs/es_MX.js',
			height: 300,
			forced_root_block : false,
			extended_valid_elements: "i, span",
			plugins: [
				'advlist autolink lists link image charmap print preview anchor textcolor',
    		'searchreplace visualblocks code fullscreen table',
    		'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'insert | table |  formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code',
			content_css: '//www.tinymce.com/css/codepen.min.css',
			file_browser_callback   : function(field_name, url, type, win) {
				if (type == 'file') {
					var cmsURL       = 'gallery.explorer.tinymce.php?type=file';
				} else if (type == 'image') {
					var cmsURL       = 'gallery.explorer.tinymce.php?type=image';
				}

				tinymce.activeEditor.windowManager.open({
					file            : cmsURL,
					title           : 'Selecciona una imagen',
					width           : 860,
					height          : 600,
					resizable       : "yes",
					inline          : "yes",
					close_previous  : "yes"
				}, {
					window  : win,
					input   : field_name
				});
			}
		});

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
