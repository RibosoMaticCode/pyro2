<!-- EDITOR AND CONFIGURATION: PUBS -->
<?php
$widget_id = "addPost1";
$type = "post1";
$action = "showConfigPost1";
$frm_config_id = "post1_block";
$btnAccept = $type."_accept";
$btnCancel = $type."_cancel";
global $objDataBase;
?>
<div id="<?= $frm_config_id ?>" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración del bloque de publicaciones</strong>
	</div>
	<div class="editor-body form">
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Titulo del bloque</span>
					<input type="text" name="post1_title" id="post1_title" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="post1_class" id="post1_class" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Categoria</span>
					<select name="post1_category" id="post1_category">
						<option value="0">Todos</option>
						<?php
						$q = $objDataBase->Ejecutar("SELECT * FROM blog_categories");
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
					<span>Cantidad por fila (<em>Solo diseño horizontal, Default: 3</em>)</span>
					<input type="text" name="post1_byrow" id="post1_byrow" />
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
					<span>Maximo a mostrar (<em>Default: 10</em>)</span>
					<input type="text" name="post1_count" id="post1_count" />
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
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Breve descripcion:</span>
					<select name="post1_desc" id="post1_desc" >
						<option value="0">No mostrar</option>
						<option value="1">Mostrar</option>
					</select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Link "ver más":</span>
					<select name="post1_link" id="post1_link" >
						<option value="0">No mostrar</option>
						<option value="1">Mostrar</option>
					</select>
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Imagen destacada:</span>
					<select name="post1_show_img" id="post1_show_img" >
						<option value="0">No mostrar</option>
						<option value="1">Mostrar</option>
					</select>
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Categorias:</span>
					<select name="post1_show_cat" id="post1_show_cat" >
						<option value="0">No mostrar</option>
						<option value="1">Mostrar</option>
					</select>
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="post1_id" value="" />
		<button class="button btn-primary" id="<?= $btnAccept ?>">Cambiar</button>
		<button class="button" id="<?= $btnCancel ?>">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar el Widget
	$("html").on("click", ".<?= $widget_id ?>", function (event) {
		event.preventDefault();
		var widgets = $(this).closest(".widgets");
		var widget_id = "widget"+uniqueId();
		$.ajax({
				url: "<?= G_SERVER ?>rb-script/modules/rb_blog/widget.pubs.php?temp_id="+widget_id
		})
		.done(function( data ) {
			notify("Elemento añadido");
			widgets.append(data);
		});
	});

	// Mostrar Editor de Post1
	$("#boxes").on("click", ".<?= $action ?>", function (event) {
	    var post1_id = $(this).closest(".widget").attr('data-id');
	    var post1_class = $(this).closest(".widget").attr('data-class');
	    var post1_values_string = $(this).closest(".widget").attr('data-values');
	    var pva = JSON.parse(post1_values_string);
	    console.log(pva);
	    $('#post1_id').val(post1_id);
	    $('#post1_title').val(pva.tit);
	    $('#post1_category').val(pva.cat);
	    $('#post1_count').val(pva.count);
	    $('#post1_order').val(pva.ord);
		$('#post1_desc').val(pva.desc);
		$('#post1_link').val(pva.link);
		$('#post1_show_img').val(pva.show_img);
		$('#post1_show_cat').val(pva.show_cat);
		$('#post1_byrow').val(pva.byrow);
	    $("input[name='post1_type'][value='"+pva.typ+"']").prop('checked', true);
	    $('#post1_class').val(post1_class);
	    $(".bg-opacity").show();
	    $("#<?= $frm_config_id ?>").show();
	    event.preventDefault();
	 });

	// Aceptando cambios
	$('#<?= $btnAccept ?>').click(function() {
		var post1_id = $('#post1_id').val();
		$('#'+ post1_id).attr('data-class', $('#post1_class').val());
		
		var post1_title = $('#post1_title').val();
		if (post1_title=="") post1_title = "";
		var post1_category = $('#post1_category').val();
		if (post1_category=="") post1_category = 0;
		var post1_count = $('#post1_count').val();
		if (post1_count=="") post1_count = 10;
		var post1_byrow = $('#post1_byrow').val();
		if (post1_byrow=="") post1_byrow = 3;
		var post1_order = $('#post1_order').val();
		if (post1_order=="") post1_count = "DESC";
		var post1_type = $('input[name=post1_type]:checked').val();
		if (post1_type=="") post1_type = 0;
		var post1_desc = $('#post1_desc').val();
		if (post1_desc== null) post1_desc = 0;
		var post1_link = $('#post1_link').val();
		if (post1_link== null) post1_link = 0;
		var post1_show_img = $('#post1_show_img').val();
		if (post1_show_img== null) post1_show_img = 0;
		var post1_show_cat = $('#post1_show_cat').val();
		if (post1_show_cat== null) post1_show_cat = 0;

		console.log($('#post1_show_cat').val());

		var post1_values_string = '{"cat":'+post1_category+',"count":'+post1_count+',"byrow":'+post1_byrow+',"ord":"'+post1_order+'","tit":"'+post1_title+'","typ":'+post1_type+', "desc": '+post1_desc+', "link": '+post1_link+', "show_img": '+post1_show_img+', "show_cat": '+post1_show_cat+'}';
		console.log(post1_values_string);
		$('#'+ post1_id).attr('data-values', post1_values_string );

		$('.bg-opacity, #<?= $frm_config_id ?>').hide();
	});

	// Cancelando cambios
	$('#<?= $btnCancel ?>').click(function() {
		$('.bg-opacity, #<?= $frm_config_id ?>').hide();
	});
});
</script>
