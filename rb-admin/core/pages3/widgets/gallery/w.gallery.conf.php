<!-- EDITOR AND CONFIGURATION: GALLERIES -->
<div id="editor-galleries" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración de las Galerías</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="galleries_class" id="galleries_class" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>A mostrar por filas (4 por defecto)</span>
					<input type="text" name="galleries_quantity" id="galleries_quantity" value="4" />
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="galleries_id" value="" /> <!-- ID UNICO DEL BLOQUE -->
		<button class="btn-primary" id="galleries_form-btn-accept">Cambiar</button>
		<button class="button" id="galleries_form-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar el configurador
	$("#boxes").on("click", ".showEditGalleries", function (event) {
    // --- Capturando valores del bloque
    var galleries_id = $(this).closest(".widget").attr('data-id');
    var galleries_class = $(this).closest(".widget").attr('data-class');
    var galleries_values_string = $(this).closest(".widget").attr('data-values');

    var pva = JSON.parse(galleries_values_string);
    $('#galleries_id').val(galleries_id);
    console.log(pva.quantity);

    $('#galleries_quantity').val(pva.quantity);
    $('#galleries_class').val(galleries_class);

    $(".bg-opacity").show();
    $("#editor-galleries").show();
    event.preventDefault();
  });
	// Aceptando cambios
	$('#galleries_form-btn-accept').click(function() {
		// Capturamos ID UNICO del bloque
		var galleries_id = $('#galleries_id').val();

		//Asignamos valores del configurador al bloque
		// -- La clase CSS
		$('#'+ galleries_id).attr('data-class', $('#galleries_class').val());
		// -- Creamos cadena con valores en formato JSON y asingamos
		var galleries_values_string = '{"quantity":'+ $('#galleries_quantity').val() +'}';
		$('#'+ galleries_id).attr('data-values', galleries_values_string );

		$('.bg-opacity, #editor-galleries').hide();
	});
	// Cancelando cambios
	$('#galleries_form-btn-cancel').click(function() {
		$('.bg-opacity, #editor-galleries').hide();
	});
});
</script>
