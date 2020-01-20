$(document).ready(function() {
  // Cargamos editor de codigo
	var editor = ace.edit("editor-css-content");
	editor.getSession().setMode("ace/mode/php");

	var textarea = $('textarea[name="file_content"]');
	editor.getSession().on("change", function () {
			textarea.val(editor.getSession().getValue());
	});

	/*
	 * Si es archivo, se muestra contenido ó
	 * Si es directorio, se muestra lista de archivos
	 */
	$(".file_item").on("click" , "li a.filename", function (event){
		$(".filename").closest('li').removeClass('file_selected');

		$(this).closest('li').addClass('file_selected');
		event.preventDefault();
		var tipo = $(this).attr("data-type");
		if(tipo=="file"){
			var fn = $(this).attr("href");
			$('#file_name').val(fn);
			//console.log(fn);
			$.ajax({
			  	method: "GET",
			  	url: "../rb-admin/core/editfile/readfile.php?filename="+fn
			}).done(function( msg ) {
					editor.setValue(msg);
			});
		}else if(tipo=="dir"){
			var fn = $(this).attr("href");
			$('#file_name').val(fn);
			console.log(fn);
			$.ajax({
			  	method: "GET",
			  	url: "../rb-admin/core/editfile/list.files.php?dir="+fn
			}).done(function( msg ) {
			    $('.file_item').html(msg);
			});
		}

	});
	/*
	 * Si se pulsa sobre Guardar Cambios.
	 */
	$( "#file_form" ).submit(function( event ) {
		event.preventDefault();
		var question = confirm("¿Guardar los cambios?");
		if( question ){
	  	$.ajax({
		  	method: "POST",
		  	url: "../rb-admin/core/editfile/save.change.php",
		  	data: $( "#file_form" ).serialize()
			}).done(function( msg ) {
				notify(msg);
			});
		}
	});
});
