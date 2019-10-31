<!-- MODAL WINDOWS BOX EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="FrmEditCol" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración de la columna</strong>
	</div>
	<div class="editor-body form">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="col_class" id="col_class" />
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="col_id" value="" />
		<button class="button btn-primary" id="FrmEditCol-BtnAccept">Cambiar</button>
		<button class="button" id="FrmEditCol-BtnCancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Aceptando cambios
	$('#FrmEditCol-BtnAccept').click(function(event) {
		var col_id = $('#col_id').val();
		$('#'+ col_id).attr('data-class', $('#col_class').val());

		var col_values_string = '{}';
		$('#'+ col_id).attr('data-values', col_values_string );

		$('.bg-opacity, #FrmEditCol').hide();
	});
	// Cancelando cambios
	$('#FrmEditCol-BtnCancel').click(function(event) {
		$('.bg-opacity, #FrmEditCol').hide();
	});
});
</script>
