<!-- MODAL WINDOWS BOX EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-box" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración del bloque</strong>
	</div>
	<div class="editor-body form">
		<h3>Bloque Externo</h3>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Imagen de fondo (url completa)  [ <input type="checkbox" name="boxext_parallax" id="boxext_parallax" />  ¿Parallax? ]</span>
					<input type="text" name="boxext_bgimage" id="boxext_bgimage" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Color de fondo (codigo hex, o rgb)</span>
					<input type="text" name="boxext_bgcolor" id="boxext_bgcolor" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-3-md spacing-right">
				<label>
					<span>Espacido Interno (Arriba)</span>
					<input type="text" name="boxext_paddingtop" id="boxext_paddingtop" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Abajo)</span>
					<input type="text" name="boxext_paddingbottom" id="boxext_paddingbottom" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Izquierda)</span>
					<input type="text" name="boxext_paddingleft" id="boxext_paddingleft" />
				</label>
			</div>
			<div class="cols-3-md spacing-left">
				<label>
					<span>Espacido Interno (Derecha)</span>
					<input type="text" name="boxext_paddingright" id="boxext_paddingright" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="boxext_class" id="boxext_class" />
				</label>
			</div>
		</div>
		<h3>Bloque Interno</h3>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Ancho completo (Yes, ó pixeles, ej. 900px)</span>
					<input type="text" name="boxin_width" id="boxin_width" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Imagen de fondo (url completa)</span>
					<input type="text" name="boxin_bgimage" id="boxin_bgimage" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Color de fondo (codigo hex, o rgb)</span>
					<input type="text" name="boxin_bgcolor" id="boxin_bgcolor" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Alto del bloque (en pixeles, ej: 400px)</span>
					<input type="text" name="boxin_height" id="boxin_height" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-3-md spacing-right">
				<label>
					<span>Espacido Interno (Arriba)</span>
					<input type="text" name="eb_bgcolor" id="boxin_paddingtop" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Abajo)</span>
					<input type="text" name="boxin_paddingbottom" id="boxin_paddingbottom" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Izquierda)</span>
					<input type="text" name="boxin_paddingleft" id="boxin_paddingleft" />
				</label>
			</div>
			<div class="cols-3-md spacing-left">
				<label>
					<span>Espacido Interno (Derecha)</span>
					<input type="text" name="boxin_paddingright" id="boxin_paddingright" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="boxin_class" id="boxin_class" />
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="eb_id" value="" />
		<button class="button btn-primary" id="boxform-btn-accept">Cambiar</button>
		<button class="button" id="boxform-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Aceptando cambios
	$('#boxform-btn-accept').click(function(event) {
		// Armar la cadena JSON PARA data-values
		var box_id = $('#eb_id').val();
		var extparallax = 0;
		//Externos
		$('#'+ box_id).attr('data-extclass', $('#boxext_class').val());
		if ($('#boxext_parallax').is(':checked')) {
			extparallax = 1
		}

		var boxext_jsonvals = '{"bgimage":"'+ $('#boxext_bgimage').val().trim() + '", "bgcolor":"'+ $('#boxext_bgcolor').val() + '", "paddingtop":"'+ $('#boxext_paddingtop').val() + '", "paddingright":"'+ $('#boxext_paddingright').val() + '", "paddingbottom":"'+ $('#boxext_paddingbottom').val() + '", "paddingleft":"'+ $('#boxext_paddingleft').val() + '", "extparallax":'+ extparallax + '}';
		$('#'+ box_id).attr('data-extvalues', boxext_jsonvals );

		//Internos
		$('#'+ box_id).attr('data-inclass', $('#boxin_class').val());

		var boxin_jsonvals = '{'+
			'"height":"'+ $('#boxin_height').val() + '",' +
			'"width":"'+ $('#boxin_width').val() + '",' +
			'"bgimage":"'+ $('#boxin_bgimage').val() + '",' +
			'"bgcolor":"'+ $('#boxin_bgcolor').val() + '",' +
			'"paddingtop":"'+ $('#boxin_paddingtop').val() + '",' +
			'"paddingright":"'+ $('#boxin_paddingright').val() + '",' +
			'"paddingbottom":"'+ $('#boxin_paddingbottom').val() + '",' +
			'"paddingleft":"'+ $('#boxin_paddingleft').val() + '"' +
			'}';
		$('#'+ box_id).attr('data-invalues', boxin_jsonvals );

		$('.bg-opacity, #editor-box').hide();
	});
	// Cancelando cambios
	$('#boxform-btn-cancel').click(function(event) {
		$('.bg-opacity, #editor-box').hide();
	});
});
</script>
