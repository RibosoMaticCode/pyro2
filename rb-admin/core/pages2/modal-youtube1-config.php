<!-- MODAL WINDOWS BOX EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-youtube1" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración de video de Youtube</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="youtube1_class" id="youtube1_class" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>A mostrar por filas (3 por defecto)</span>
					<input type="text" name="youtube1_quantity" id="youtube1_quantity" value="3" />
				</label>
			</div>
		</div>
		<div>
			<label>
				<span>Pegue aqui los codigos de los videos de youtube, separados por coma</span>
				<textarea name="youtube1_videos" id="youtube1_videos" rows="3"></textarea>
			</label>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="youtube1_id" value="" /> <!-- ID UNICO DEL BLOQUE -->
		<button class="btn-primary" id="youtube1_form-btn-accept">Cambiar</button>
		<button class="button" id="youtube1_form-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Aceptando cambios
	$('#youtube1_form-btn-accept').click(function() {
		// Capturamos ID UNICO del bloque
		var youtube1_id = $('#youtube1_id').val();
		//Asignamos valores del configurador al bloque
		// -- La clase CSS
		$('#'+ youtube1_id).attr('data-class', $('#youtube1_class').val());
		// -- Creamos cadena con valores en formato JSON y asingamos
		var youtube1_values_string = '{"quantity":'+ $('#youtube1_quantity').val() +',"videos":"'+ $('#youtube1_videos').val() +'"}';
		$('#'+ youtube1_id).attr('data-values', youtube1_values_string );

		$('.bg-opacity, #editor-youtube1').hide();
	});
	// Cancelando cambios
	$('#youtube1_form-btn-cancel').click(function() {
		$('.bg-opacity, #editor-youtube1').hide();
	});
});
</script>
