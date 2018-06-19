<!-- MODAL WINDOWS BLOCK EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-block" class="editor-window">
	<form id="frm-block">
		<div class="editor-header">
			<strong>Guardar bloque</strong>
		</div>
		<input type="hidden" name="block_id" id="block_id" value="0" />
		<div class="editor-body">
			<label>Nombre del bloque
				<input type="text" name="block_name" id="block_name" required />
			</label>
			<textarea name="block_content" id="block_content" style="display:none"></textarea>
		</div>
		<div class="editor-footer">
			<button type="submit" class="btn-primary" id="block-btn-accept">Guardar</button>
			<button class="button" id="block-btn-cancel">Cancelar</button>
			<!-- ITEM id -->
			<input type="hidden" name="block_item_id" id="block_item_id" value="" />
		</div>
	</form>
	<script>
	$(function() {
		// Aceptar cambios
	  $('#frm-block').submit(function(event) {
			event.preventDefault();
			// Item Block Id
			var blo_id = $("#block_item_id").val();
			$.ajax({
		  	method: "POST",
		  	url: "<?= G_SERVER ?>/rb-admin/core/pages3/save.block.php",
		  	data: $( "#frm-block" ).serialize()
			}).done(function( msg ) {
				console.log(msg.id);
				// Cambiar nombre a la etiqueta Guardar
				$("#"+blo_id).find('.showEditBlock').hide();
				$("#"+blo_id).find('.col-save-title').html( $("#block_name").val() );
				$("#"+blo_id).attr('data-saved-id',msg.id);
				$("#"+blo_id).addClass('saved');
			});
			$('.bg-opacity, #editor-block').hide();
	  });
		// Cancelar
		$('#block-btn-cancel').click(function() {
			event.preventDefault();
			$('.bg-opacity, #editor-block').hide();
	  });
	});
	</script>
</div>
