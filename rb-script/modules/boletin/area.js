var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/boletin/';
var base_dashboard = base_url+'rb-admin/';

$(document).ready(function() {

    // Guardar
    $(document).on('submit', '#frmarea', function( event ){
      	event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: base_module+"area.save.php",
  			data: $( this ).serialize()
  		})
  		.done(function( data ) {
  			if(data.resultado){
				$.fancybox.close();
  				notify(data.contenido);
				setTimeout(function(){
	          		window.location.href = base_dashboard+'module.php?pag=boletin_areas';
	        	}, 1000);
  	  		}else{
  				notify(data.contenido);
  	  		}
  		});
    });

    // Boton Cancelar
	$(document).on('click','.CancelFancyBox', function(event){
		$.fancybox.close();
	});

    // Eliminar
    $('.del').on("click", function(event){
  		event.preventDefault();
	  	var eliminar = confirm("[?] Esta seguro de eliminar este valor?");
	  	if ( eliminar ) {
		    var id = $(this).attr('data-item');
		    $.ajax({
		      type: "GET",
		      url: base_module+"area.del.php?id="+id
		    })
		    .done(function( data ) {
	      		if(data.resultado){
		        notify(data.contenido);
		        setTimeout(function(){
		          	window.location.href = base_dashboard+'module.php?pag=boletin_areas';
		        }, 1000);
	     	}else{
	        	notify(data.contenido);
	      	}
	    });
	  }
	});

    // Fancybox advanced Form - Oculta boton de cerrar y evitar cerrar al clickear en fondo oscuro
	$('.fancySuscrip').fancybox({
		closeBtn    : false, // hide close button
		closeClick  : false, // prevents closing when clicking INSIDE fancybox
		helpers     : {
			// prevents closing when clicking OUTSIDE fancybox
			overlay : {closeClick: false}
		},
		keys : {
			// prevents closing when press ESC button
			close  : null
		}
	});
 });
