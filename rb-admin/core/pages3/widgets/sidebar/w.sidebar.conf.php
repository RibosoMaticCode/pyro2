<!-- EDITOR AND CONFIGURATION: SIDEBAR -->
<div id="editor-sidebar" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración de la Barra Lateral</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="sidebar_class" id="sidebar_class" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Pagina que fungira de Barra Lateral</span>
					<select name="sidebar_name" id="sidebar_name">
						<option value="0">Seleccionar</option>
						<?php
						$q = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE type=3");
						while($Pagina = $q->fetch_assoc()):
							?>
							<option value="<?= $Pagina['id']?>"><?= $Pagina['titulo']?></option>
							<?php
						endwhile;
						?>
					</select>
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="sidebar_id" value="" /> <!-- ID UNICO DEL BLOQUE -->
		<button class="btn-primary" id="sidebar_form-btn-accept">Cambiar</button>
		<button class="button" id="sidebar_form-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar el configurador
	$("#boxes").on("click", ".showEditSidebar", function (event) {
    // --- Capturando valores del bloque
    var sidebar_id = $(this).closest(".widget").attr('data-id');
    var sidebar_class = $(this).closest(".widget").attr('data-class');
    var sidebar_values_string = $(this).closest(".widget").attr('data-values');

    var pva = JSON.parse(sidebar_values_string);
    $('#sidebar_id').val(sidebar_id);
    $('#sidebar_name').val(pva.name);
    $('#sidebar_class').val(sidebar_class);

    $(".bg-opacity").show();
    $("#editor-sidebar").show();
    event.preventDefault();
  });
	// Aceptando cambios
	$('#sidebar_form-btn-accept').click(function() {
		// Capturamos ID UNICO del bloque
		var sidebar_id = $('#sidebar_id').val();

		//Asignamos valores del configurador al bloque
		// -- La clase CSS
		$('#'+ sidebar_id).attr('data-class', $('#sidebar_class').val());
		// -- Creamos cadena con valores en formato JSON y asingamos
		var sidebar_values_string = '{"name":'+ $('#sidebar_name').val() +'}';
		$('#'+ sidebar_id).attr('data-values', sidebar_values_string );

		$('.bg-opacity, #editor-sidebar').hide();
	});
	// Cancelando cambios
	$('#sidebar_form-btn-cancel').click(function() {
		$('.bg-opacity, #editor-sidebar').hide();
	});
});
</script>
