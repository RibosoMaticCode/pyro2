var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/plm/';

$(document).ready(function() {
	// Tabla
	if ( $( "#table" ).length > 0) {
	    var table = $('#table').DataTable({
	      "language": {
	        "url": "resource/datatables/Spanish.json"
	      }
	    });

	    table
	    	.order( [ 0, 'desc' ] )
    		.draw();
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
			          window.location.href = base_url+'rb-admin/module.php?pag=plm_orders_simple';
			        }, 1000);
		      	}else{
		        	notify(data.contenido);
		      	}
		    });
	  	}
	});

	// Boton Cancelar
	$(document).on('click','.CancelFancyBox', function(event){
		$.fancybox.close();
	});

    // Boton Guardar
    $(document).on('submit', '#frmData', function( event ){
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
		          	window.location.href = base_url+'rb-admin/module.php?pag=plm_orders_simple';
		        }, 1000);
	  	  	}else{
	  			notify(data.contenido);
	  	  	}
  		});
    });
});