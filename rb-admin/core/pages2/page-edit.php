<?php
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$cons_art = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id=$id");
	$row=mysql_fetch_array($cons_art);
	$mode = "update";
}else{
	$mode = "new";
}
include_once("tinymce.module.php");
?>
<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
<script>
	$(document).ready(function() {
		// jquery ui elementos que se pueden arrastrar y soltar
		$( "#boxes" ).sortable({
	    placeholder: "placeholder",
	    handle: ".box-header"
	  });
	  var i=0;

	  // click al llamar cada elemento para estructura de la web
		$('#boxSlide').click( function( event ){
			i++;
			$.ajax({
			  	url: "core/pages2/mod.design.blocks.php?t=slide&temp_id="+i
			})
			.done(function( data ) {
			   $('#boxes').append( data );
			});
		});
		$('#boxGallery').click( function( event ){
			i++;
			$.ajax({
			  	url: "core/pages2/mod.design.blocks.php?t=gallery&temp_id="+i
			})
			.done(function( data ) {
			   $('#boxes').append( data );
			});
		});
		$('#boxHtml').click( function( event ){
			i++;
			$.ajax({
			  	url: "core/pages2/mod.design.blocks.php?t=html&temp_id="+i
			})
			.done(function( data ) {
			   $('#boxes').append( data );
			});
		});
		$('#boxPosts').click( function( event ){
			i++;
			$.ajax({
			  	url: "core/pages2/mod.design.blocks.php?t=posts&temp_id="+i
			})
			.done(function( data ) {
			   $('#boxes').append( data );
			});
		});

		// Nuevo bloque
		$('#boxNew').click( function( event ){
			i++;
			$.ajax({
			  	url: "core/pages2/page-box-new.php"
			})
			.done(function( data ) {
			   $('#boxes').append( data );
			});
		});

	  // borrar cada bloque
	  $("#boxes").on("click", ".boxdelete", function (event) {
	    	var msg = confirm("¿Desea quitar?");
	    	if(msg){
	    		$(this).closest("li").remove();
	    	}
		});

		// agregar columna PROTOTIPO INICIAL
		$("#boxes").on("click", ".add-column", function (event) {
			var item = '<li class="col">'+
				'<span class="col-head">'+
          '<a class="close-column" href="#">X</a>'+
        '</span>'+
        '<div class="col-box-edit">'+
					'<div class="box-edit-options">'+
          	'<a class="optSlide" href="#">Slides</a>'+
          	'<a class="optHTML" href="#">HTML</a>'+
					'</div>'+
					'<div class="box-edit">'+
					'</div>'+
        '</div>'+
      '</li>';
			$(this).closest("li").find(".cols-html").append(item);
		});

		// Añadir Slide
		$("#boxes").on("click", ".addSlide", function (event) {
			var box_edit = $(this).closest(".item").find(".cols-html");

			$.ajax({
	        url: "core/pages2/box-slide.php"
	    })
	    .done(function( data ) {
	      box_edit.append(data);
	    });
		});

		// Añadir HTML
		$("#boxes").on("click", ".addHtml", function (event) {
			var box_edit = $(this).closest(".item").find(".cols-html");

			$.ajax({
	        url: "core/pages2/box-html.php"
	    })
	    .done(function( data ) {
	      box_edit.append(data);
	    });
		});

		// Click en Option Slide
		$("#boxes").on("click", ".optSlide", function (event) {
	    var box_edit_options = $(this).closest(".col-box-edit").find(".box-edit-options");
	    var box_edit = $(this).closest(".col-box-edit").find(".box-edit");
	    console.log('test');
	    $.ajax({
	        url: "core/pages2/box-slide.php"
	    })
	    .done(function( data ) {
	      box_edit_options.slideUp();
	      box_edit.append( data );
	    });
	  });

		// Click en Option Slide
		$("#boxes").on("click", ".optHTML", function (event) {
	    var box_edit_options = $(this).closest(".col-box-edit").find(".box-edit-options");
	    var box_edit = $(this).closest(".col-box-edit").find(".box-edit");
	    console.log('test');
	    $.ajax({
	        url: "core/pages2/box-html.php"
	    })
	    .done(function( data ) {
	      box_edit_options.slideUp();
	      box_edit.append( data );
	    });
	  });

		// Remover columnas
		$("#boxes").on("click", ".close-column", function (event) {
			var msg = confirm("¿Desea quitar?");
	    	if(msg){
	    		$(this).closest("li").remove();
	    	}
		});

		// button hide/show
		$( ".arrow-up" ).hide();

		$("#boxes").on("click", ".toggle", function (event) {
			$(this).closest("li").find(".box-body").toggle();
			$(this).closest("li").find(".arrow-up, .arrow-down").toggle();
		});

	    // Guardar cambios en diseñador
	    $( "#btnGuardar" ).click(function() {
	    	var pagina_id = $('#pagina_id').val();
	    	var pagina_title = $('#titulo').val();

	    	console.log( "Pagina Id:"+pagina_id );

	    	// si pagina_id = 0, entonces grabar nueva pagina
	    	$.ajax({
	    		url: "page.save.php?pid="+pagina_id+"&title="+pagina_title
	    	})
			.done(function( data ) {
				if(data=="0"){
					console.log("Error al guardar la página");
					return;
				}else{
					var pagina_id = data;

					$('#boxes .item').each(function(indice, elemento) {
					  	console.log('Elemento: Position:'+indice+',Codigo:'+$(elemento).attr('id')+',Tipo:'+$(elemento).attr('data-type'));

					  	var string_data;

					  	var type = $(elemento).attr('data-type');
						switch(type){
							case 'slide':
								var gallery_id = $(elemento).find('.slide_name').val();
								string_data = "{'gallery_id':'"+gallery_id+"'}";

								$.ajax({
								  	url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
								})
								.done(function( data ) {
									console.log( data );
								});
							break;
							case 'gallery':
								var gallery_id = $(elemento).find('.gallery_name').val();
								var gallery_show = $(elemento).find('.gallery_show').val();
								var gallery_byrow = $(elemento).find('.gallery_byrow').val();

								string_data = "{'gallery_id':'"+gallery_id+"', 'gallery_show' : '"+gallery_show+"', 'gallery_byrow' : '"+gallery_byrow+"'}";

								$.ajax({
								  	url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
								})
								.done(function( data ) {
									console.log( data );
								});
							break;
							case 'html':
								var html_string_start = " {'columns': [ ";
								var html_string_end = " ] ";
								var html_string_content = "";
								var coma = "";
								var j=0;

								$('.cols-html li').each(function(indice, elemento) {
									console.log( 'Columna: Position:'+indice+',Contenido:'+$(elemento).find('.col-content').val() );
									htmlt_content_col = $(elemento).find('.col-content').val();

									html_string_content += coma + "{'html_id' : '"+indice+"' , 'html_content' : '"+htmlt_content_col+"'}";
									coma = ",";
									j++;
								});
								html_num_cols = ", 'num_cols' : '"+ j +"' }";

								string_data = html_string_start + html_string_content + html_string_end + html_num_cols;

								$.ajax({
								  	url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
								})
								.done(function( data ) {
									console.log( data );
								});
								//console.log( html_string_all );
							break;
							case 'posts':
								var category_id = $(elemento).find('.category_name').val();
								var category_show = $(elemento).find('.category_show').val();
								var category_byrow = $(elemento).find('.category_byrow').val();

								if( $(elemento).find('.category_list').is( ":checked" ) ){
									var category_style = "list";
								}
								if( $(elemento).find('.category_grid').is( ":checked" ) ){
									var category_style = "grid";
								}

								string_data = "{'category_id':'"+category_id+"', 'category_show' : '"+category_show+"', 'category_byrow' : '"+category_byrow+"', 'category_style' : '"+category_style+"'}";

								$.ajax({
								  	url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
								})
								.done(function( data ) {
									console.log( data );
								});
							break;
					  	}
					});
				}
			});
	  });
	});
</script>
<div id="toolbar">
	<div id="toolbar-buttons">
		<span class="post-submit">
			<input class="submit" name="guardar" type="submit" value="Guardar" id="btnGuardar" />
			<input class="submit" name="guardar_volver" type="submit" value="Guardar y volver" id="btnGuardarBack"/>
			<a href="../rb-admin/?pag=pages"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver" /></a>
		</span>
	</div>
</div>
<div class="container-page-edit">
	<section class="seccion">
		<div class="seccion-body">
			<div class="wrap-input">
				<input placeholder="Escribe el titulo de la página aquí" class="ancho" name="titulo" type="text" id="titulo" required value="<?php if(isset($row)) echo $row['titulo'] ?>" />
				<!--<input id="pagina_id" value="<?= $pagina_id ?>" type="hidden" />-->
			</div>

			<label>Estructura</label>
			<div class="estructure">
				<ul id="boxes">
					<?php include_once 'page-box-new.php' ?>
				</ul>
				<a id="boxNew" href="#">Añadir nuevo bloque</a>
			</div>
		</div>
	</section>
</div>
<!--<div id="sidebar">
	<section class="seccion">
		<div class="seccion-header">
			<h3>Elementos disponibles</h3>
		</div>
		<div class="seccion-body boxes-options">
		<span class="info">
		Clic en el elemento deseado y aparecerá en la columna izquierda, puede modificar sus opciones antes de Guardar los cambios
		</span>
		<ul>
			<li>
				<a title="Permite elegir una galería que se usará como Slide" id="boxSlide" href="#">Slide</a>
			</li>
			<li>
				<a title="Permite elegir una galería de imagenes, cuantas mostrar y cuantas por fila" id="boxGallery" href="#">Galería de Fotos</a>
			</li>
			<li>
				<a title="Permite personalizar HTML en columnas, con un máximo de 12" id="boxHtml" href="#">Bloque HTML</a>
			</li>
			<li>
				<a title="Permite mostrar un bloque de publicaciones de una categoría en particular o todas" id="boxPosts" href="#">Bloques de Publicaciones</a>
			</li>
		</ul>
		</div>
	</section>
</div>-->
