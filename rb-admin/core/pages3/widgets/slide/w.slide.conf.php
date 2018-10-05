<!-- EDITOR AND CONFIGURATION: SLIDE -->
<div id="editor-slide" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración de la galería</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Galeria a mostrar:</span>
					<?php
					$q = $objDataBase->Ejecutar("SELECT * FROM albums ORDER BY id DESC");
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
					<span>Tipo galeria:</span>
					<select id="slide_type" name="slide_type">
						<option value="1">Solo galería</option>
						<option value="2">Slides / Diapositivas</option>
					</select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Cantidad por fila</span>
					<span class="info">(funciona con tipo "solo galeria", por defecto 4)</span>
					<input type="text" name="slide_quantity" id="slide_quantity" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<input type="checkbox" name="slide_showtitle" id="slide_showtitle" /> <span>Mostrar titulo de la imagen</span>
				</label>
				<label>
					<input type="checkbox" name="slide_activelink" id="slide_activelink" /> <span>Activar el link de la imagen</span>
					<span class="info">Cuando se cliquee en la imagen la llevará al link especificado. No mostrará la foto.</span>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Limitar cantidad a mostrar</span>
					<input type="text" name="slide_limit" id="slide_limit" />
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
	// Mostrar la ventana de configuracion con los datos
	$("#boxes").on("click", ".showEditSlide", function (event) {
    var slide_id = $(this).closest(".widget").attr('data-id');
    var slide_class = $(this).closest(".widget").attr('data-class');
    var slide_values_string = $(this).closest(".widget").attr('data-values');

    var pva = JSON.parse(slide_values_string);
    $('#slide_id').val(slide_id); // Asignar ID UNICO del bloque a input oculto en el editor-configurador
    console.log(pva.gallery_id);
    $('#slide_gallery').val(pva.gallery_id);
		$('#slide_type').val(pva.type);
		$('#slide_quantity').val(pva.quantity);
		$('#slide_limit').val(pva.limit);
    if(pva.show_title==1){
      $('#slide_showtitle').prop('checked', true);
    }else{
      $('#slide_showtitle').prop('checked', false);
    }
		if(pva.activelink==1){
      $('#slide_activelink').prop('checked', true);
    }else{
      $('#slide_activelink').prop('checked', false);
    }
    $('#slide_class').val(slide_class);

    $(".bg-opacity").show();
    $("#editor-slide").show();
    event.preventDefault();
  });
	// Aceptando cambios
	$('#slide_form-btn-accept').click(function() {
		var slide_id = $('#slide_id').val();
		$('#'+ slide_id).attr('data-class', $('#slide_class').val());
		var slide_gallery = $('#slide_gallery').val();
		if (slide_gallery=="") slide_gallery = 0;
		var slide_type = $('#slide_type').val();
		var slide_quantity = $('#slide_quantity').val();
		if (slide_quantity=="") slide_quantity = 0;
		var slide_limit = $('#slide_limit').val();
		if (slide_limit=="") slide_limit = 0;

		if ($('#slide_showtitle').is(':checked')) {
			slide_showtitle = 1;
		}else{
			slide_showtitle = 0;
		}
		if ($('#slide_activelink').is(':checked')) {
			slide_activelink = 1;
		}else{
			slide_activelink = 0;
		}

		var slide_values_string = '{"gallery_id":'+slide_gallery+',"show_title":'+slide_showtitle+', "type":'+slide_type+', "quantity": '+slide_quantity+', "activelink": '+slide_activelink+', "limit": '+slide_limit+'}';
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
