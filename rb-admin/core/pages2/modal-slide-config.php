<!-- MODAL WINDOWS BOX EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-slide" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración del slide</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Galeria:</span>
					<?php
					$q = $objDataBase->Ejecutar("SELECT * FROM albums");
					?>
					<select id="slide_gallery" name="slide_gallery">
				    <option value="0">Seleccionar</option>
				    <?php
				    while($r = $q->fetch_assoc()):
				    ?>
				    <option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
				    <?php
				    endwhile;
				    ?>
				  </select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="slide_class" id="slide_class" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<input type="checkbox" name="slide_showtitle" id="slide_showtitle" /> <span>Mostrar titulo de la imagen</span>
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="slide_id" value="" />
		<button class="btn-primary" id="slide_form-btn-accept">Cambiar</button>
		<button class="button" id="slide_form-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Aceptando cambios
	$('#slide_form-btn-accept').click(function() {
		var slide_id = $('#slide_id').val();
		$('#'+ slide_id).attr('data-class', $('#slide_class').val());
		var slide_gallery = $('#slide_gallery').val();
		if (slide_gallery=="") slide_gallery = 0;

		if ($('#slide_showtitle').is(':checked')) {
			slide_showtitle = 1;
		}else{
			slide_showtitle = 0;
		}

		var slide_values_string = '{"gallery_id":'+slide_gallery+',"show_title":'+slide_showtitle+'}';
		console.log(slide_values_string);
		$('#'+ slide_id).attr('data-values', slide_values_string );

		$('.bg-opacity, #editor-slide').hide();
	});
	// Cancelando cambios
	$('#slide_form-btn-cancel').click(function() {
		$('.bg-opacity, #editor-slide').hide();
	});
});
</script>
