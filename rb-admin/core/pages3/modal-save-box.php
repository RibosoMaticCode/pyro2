<!-- EDITOR AND CONFIGURATION: BLOQUE -->
<div id="editorbox" class="editor-window">
	<form id="frmbox">
		<div class="editor-header">
			<strong>Guardar Bloque</strong>
		</div>
		<!--<input type="hidden" name="box_id" id="box_id" value="0" />-->
		<div class="editor-body">
			<label>Nombre del bloque
				<input type="text" name="box_name" id="box_name" required />
			</label>
			<p>Guardar como</p>
			<label>
				<input type="radio" value="0" name="box_type" /><span>Normal</span>
			</label>
			<label>
				<input type="radio" value="1" name="box_type" /><span>Cabecera</span>
			</label>
			<label>
				<input type="radio" value="2" name="box_type" /><span>Pie de pagina</span>
			</label>
			<textarea name="box_content" id="box_content" style="display:none" height="4"></textarea>
		</div>
		<div class="editor-footer">
			<button type="submit" class="btn-primary" id="box-btnaccept">Guardar</button>
			<button class="button" id="box-btncancel">Cancelar</button>
			<!-- ITEM id -->
			<input type="hidden" name="box_itemid" id="box_itemid" value="" />
		</div>
	</form>
	<script>
	$(function() {
		// Aceptar cambios
	  $('#frmbox').submit(function(event) {
			event.preventDefault();
			var box_id = $("#box_itemid").val();
			$.ajax({
		  	method: "POST",
		  	url: "<?= G_SERVER ?>/rb-admin/core/pages3/save.box.php",
		  	data: $( "#frmbox" ).serialize()
			}).done(function( msg ) {
				console.log(msg.id);
				// Cambiar nombre a la etiqueta Guardar
				$("#"+box_id).find('.SaveBox').hide();
				$("#"+box_id).find('.box-save-title').html( $("#box_name").val() );
				$("#"+box_id).attr('data-saved-id',msg.id);
				$("#"+box_id).addClass('saved');
			});
			$('.bg-opacity, #editorbox').hide();
	  });
		// Cancelar
		$('#box-btncancel').click(function() {
			event.preventDefault();
			$('.bg-opacity, #editorbox').hide();
	  });
	});
	</script>
</div>
