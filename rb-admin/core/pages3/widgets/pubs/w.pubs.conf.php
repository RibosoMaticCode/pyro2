<!-- EDITOR AND CONFIGURATION: PUBS -->
<div id="editor-post1" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración del bloque de publicaciones</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Titulo del bloque</span>
					<input type="text" name="post1_title" id="post1_title" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Categoria</span>
					<select name="post1_category" id="post1_category">
						<option value="0">Todos</option>
						<?php
						$q = $objDataBase->Ejecutar("SELECT * FROM categorias");
						while($Categoria = $q->fetch_assoc()):
							?>
							<option value="<?= $Categoria['id']?>"><?= $Categoria['nombre']?></option>
							<?php
						endwhile;
						?>
					</select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Cantidad</span>
					<input type="text" name="post1_count" id="post1_count" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Orden:</span>
					<select name="post1_order" id="post1_order" >
						<option value="DESC">Mas recientes</option>
						<option value="ASC">Desde inicio</option>
					</select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="post1_class" id="post1_class" />
				</label>
			</div>
		</div>
		<label>
			<span>Diseño:</span>
		</label>
		<div class="cols-container">
			<div class="cols-3-md">
				<label>
					<input type="radio" name="post1_type" id="radio1" value="0" /> Horizontal
				</label>
			</div>
			<div class="cols-3-md">
				<label>
					<input type="radio" name="post1_type" id="radio2" value="1" /> Vertical
				</label>
			</div>
			<div class="cols-3-md">
				<label>
					<input type="radio" name="post1_type" id="radio3" value="2" /> Destacado izquierda
				</label>
			</div>
			<div class="cols-3-md">
				<label>
					<input type="radio" name="post1_type" id="radio4" value="3" /> Destacado derecha
				</label>
			</div>
		</div>
		<!--<div class="cols-container">
			<div class="cols-12-md">
				<label>
					<input type="checkbox" name="post1_showimg" id="post1_showimg" /> Mostrar imagen
				</label>
				<label>
					<input type="checkbox" name="post1_showtitle" id="post1_showtitle" /> Mostrar titulo
				</label>
				<label>
					<input type="checkbox" name="post1_showsocial" id="post1_showsocial" /> Mostrar social
				</label>
				<label>
					<input type="checkbox" name="post1_datetime" id="post1_datetime" /> Mostrar fecha y hora
				</label>
			</div>
		</div>-->
	</div>
	<div class="editor-footer">
		<input type="hidden" id="post1_id" value="" />
		<button class="btn-primary" id="post1_form-btn-accept">Cambiar</button>
		<button class="button" id="post1_form-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar Editor de Post1
	$("#boxes").on("click", ".showEditPost1", function (event) {
    var post1_id = $(this).closest(".widget").attr('data-id');
    var post1_class = $(this).closest(".widget").attr('data-class');
    var post1_values_string = $(this).closest(".widget").attr('data-values');
    var pva = JSON.parse(post1_values_string);
    $('#post1_id').val(post1_id);
    $('#post1_title').val(pva.tit);
    $('#post1_category').val(pva.cat);
    $('#post1_count').val(pva.count);
    $('#post1_order').val(pva.ord);
    $("input[name='post1_type'][value='"+pva.typ+"']").prop('checked', true);
    $('#post1_class').val(post1_class);
    $(".bg-opacity").show();
    $("#editor-post1").show();
    event.preventDefault();
  });
	// Aceptando cambios
	$('#post1_form-btn-accept').click(function() {
		var post1_id = $('#post1_id').val();
		$('#'+ post1_id).attr('data-class', $('#post1_class').val());
		//captura de valores
		var post1_title = $('#post1_title').val();
		if (post1_title=="") post1_title = "";
		var post1_category = $('#post1_category').val();
		if (post1_category=="") post1_category = 0;
		var post1_count = $('#post1_count').val();
		if (post1_count=="") post1_count = 3;
		var post1_order = $('#post1_order').val();
		if (post1_order=="") post1_count = "DESC";
		var post1_type = $('input[name=post1_type]:checked').val();
		if (post1_type=="") post1_type = 0;

		var post1_values_string = '{"cat":'+post1_category+',"count":'+post1_count+',"ord":"'+post1_order+'","tit":"'+post1_title+'","typ":'+post1_type+'}';
		console.log(post1_values_string);
		$('#'+ post1_id).attr('data-values', post1_values_string );
		/*if ($('#$post1_showimg').is(':checked')) {
			var post1_showimg = 1;
		}else{
			var post1_showimg = 0;
		}*/
		$('.bg-opacity, #editor-post1').hide();
	});
	// Cancelando cambios
	$('#post1_form-btn-cancel').click(function() {
		$('.bg-opacity, #editor-post1').hide();
	});
});
</script>
