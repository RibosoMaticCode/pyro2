var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/sapiens/';

$(document).ready(function() {
	// Tabla
	if ( $( "#table" ).length > 0) {
	    console.log("existe");
	    $('#table').DataTable({
	      "language": {
	        "url": "resource/datatables/Spanish.json"
	      }
	    });
	}

    // Eliminar orden
	$('.del').on("click", function(event){
		console.log('del');
	  	event.preventDefault();
	  	var eliminar = confirm("[?] Esta seguro de eliminar este valor?");
	  	if ( eliminar ) {
	    	var id = $(this).attr('data-item');
	    	$.ajax({
		      	type: "GET",
		      	url: base_module+"sapiens.orders.del.php?id="+id
		    	})
		    	.done(function( data ) {
		      	if(data.resultado){
		       		notify(data.contenido);
			        setTimeout(function(){
			          window.location.href = base_url+'rb-admin/module.php?pag=sapiens_orders';
			        }, 1000);
		      	}else{
		        	notify(data.contenido);
		      	}
		    });
	  	}
	});

	// Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
		$.fancybox.close();
	});

    // Boton Guardar
    $('#frmData').submit(function(event){
      	event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: base_module+"sapiens.orders.save.php",
  			data: $( this ).serialize()
  		})
  		.done(function( data ) {
  			if(data.resultado){
				$.fancybox.close();
  				notify(data.contenido);
				setTimeout(function(){
		          	window.location.href = base_url+'rb-admin/module.php?pag=sapiens_orders';
		        }, 1000);
	  	  	}else{
	  			notify(data.contenido);
	  	  	}
  		});
    });
});