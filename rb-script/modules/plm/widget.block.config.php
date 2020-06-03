<!-- FORMULARIO DE CONFIGURACION DEL WIDGET -->
<?php
$widget_id = "addPlmBlock";
$type = "plm_block";
$action = "showConfigPlmBlock";
$frm_config_id = "plm_widget_block";
$btnAccept = $type."_accept";
$btnCancel = $type."_cancel";
?>
<div id="<?= $frm_config_id ?>" class="editor-window">
	<div class="editor-header">
		<strong>Configuración PLM block</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container form">
			<div class="cols-6-md spacing-right">
				<label>Class CSS
					<input type="text" id="<?= $type ?>_class_css" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
			</div>
		</div>
		<div class="cols-container form">
			<div class="cols-6-md spacing-right">
				<label>Estilo visual
					<select name="<?= $type ?>_estilo" id="<?= $type ?>_estilo">
						<option value="0">Ninguno</option>
						<option value="1">Estilo 1</option>
						<option value="2">Estilo 2</option>
						<option value="3">Estilo 3</option>
					</select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>Tipo
					<select name="<?= $type ?>_tipo" id="<?= $type ?>_tipo">
						<option value="1">Mas vendidos</option>
						<option value="2">Mejores ofertas</option>
						<option value="3">Nuevos</option>
						<option value="4">Antiguos</option>
					</select>
				</label>
			</div>
		</div>
		<div class="cols-container form">
			<div class="cols-6-md spacing-right">
				<label>Maximo a mostrar
					<input type="text" id="<?= $type ?>_limite" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>Categoria
					<select id="<?= $type ?>_categoria">
						<option value="0">Todos</option>
						<?php
						global $objDataBase;
						$q = $objDataBase->Ejecutar("SELECT * FROM plm_category");
						while($categoria = $q->fetch_assoc()):?>
							<option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
						<?php endwhile ?>
					</select>
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="<?= $type ?>_id" value="" />
		<button class="button btn-primary" id="<?= $btnAccept ?>">Cambiar</button>
		<button class="button" id="<?= $btnCancel ?>">Cancelar</button>
	</div>
	<script>
	$(function() {
	    // Mostrar el Widget
	    $("html").on("click", ".<?= $widget_id ?>", function (event) {
	      event.preventDefault();
	      var widgets = $(this).closest(".widgets");
	      var widget_id = "widget"+uniqueId();
	      $.ajax({
	          url: "<?= G_SERVER ?>rb-script/modules/plm/widget.block.php?temp_id="+widget_id
	      })
	      .done(function( data ) {
	        notify("Elemento añadido");
	        widgets.append(data);
	      });
	    });

		// Mostrar Configurador de Widget
		$("#boxes").on("click", ".<?= $action ?>", function (event) {
			event.preventDefault();
			// reset campos
			$('#<?= $type ?>_class_css').val("");

			// valores por defecto iniciales
			var widget_id = $(this).closest(".widget").attr('data-id');
		    var widget_class = $(this).closest(".widget").attr('data-class');
		    var widget_values_string = $(this).closest(".widget").attr('data-values');
			var widget_json_values = JSON.parse(widget_values_string);
			$('#<?= $type ?>_id').val(widget_id);

			$('#<?= $type ?>_class_css').val(widget_class);
			$('#<?= $type ?>_estilo').val(widget_json_values.estilo);
			$('#<?= $type ?>_tipo').val(widget_json_values.tipo);
			$('#<?= $type ?>_limite').val(widget_json_values.limite);
			$('#<?= $type ?>_categoria').val(widget_json_values.categoria);

		    $(".bg-opacity").show();
		    $("#<?= $frm_config_id ?>").show();
	  	});

		// Aceptando los cambios
	  	$('#<?= $btnAccept ?>').click(function() {
			event.preventDefault();
			var widget_id = $('#<?= $type ?>_id').val();
			$('#'+ widget_id).attr('data-class', $('#<?= $type ?>_class_css').val());

			var widget_values_string = '{ \
				"estilo":"'+ $('#<?= $type ?>_estilo').val() +'", \
				"tipo":"'+ $('#<?= $type ?>_tipo').val() + '", \
				"limite":"'+ $('#<?= $type ?>_limite').val() + '", \
				"categoria":"'+ $('#<?= $type ?>_categoria').val() + '" \
				}';
			$('#'+ widget_id).attr('data-values', widget_values_string );

			$('.bg-opacity, #<?= $frm_config_id ?>').hide();
	  	});

		// Cancel and close
		$('#<?= $btnCancel ?>').click(function() {
			$('.bg-opacity, #<?= $frm_config_id ?>').hide();
	  	});
	});
	</script>
</div>
