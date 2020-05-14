// Validaciones
var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/plm/';

$(document).ready(function() {

  	// Cargar el formulario
  	$('.frmSapiensShow').click(function(event){
    	$('.frmSapiensOrders, .bg').show();
  	});

  	// Cerrar el formulario
  	$('.frmSapiensClose').click(function(event){
    	event.preventDefault();
    	$('.bg, .frmSapiensOrders').fadeOut();
	});

	// Boton Guardar
    $('#frmData').submit(function(event){
      event.preventDefault();
      var book_url = jQuery(location).attr('href');
      var book_title = jQuery(document).attr('title');

      var data = $('#frmData').serializeArray();
      data.push({name: 'book_url', value: book_url});
      data.push({name: 'book_title', value: book_title});

      console.log(data);

  		$.ajax({
  			method: "post",
  			url: base_module+"sapiens.orders.save.php",
  			data: data
  		})
  		.done(function( data ) {
  			if(data.resultado){
  				//alert(data.contenido);
          $('.frmSapiensStep1').hide();
          $('.frmSapiensStep2').show();
	  	  }else{
	  			alert(data.contenido);
	  	  }
  		});
    });
});  