// Validaciones
var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/plm/';

$(document).ready(function() {

  	// Cargar el formulario
  	$('.frmSapiensShowFisico').click(function(event){
      var product_name = $('.product_name').text();
      var product_price = $('.product_price').text();

      $( "input[name$='total']" ).val(product_price);
      console.log(product_name+product_price);

      $('.frmProductName').text( product_name );
      $('.frmProductPrice').text( product_price );

    	$('.frmSapiensOrdersFisico, .bg').show();
  	});

    $('.frmSapiensShowDigital').click(function(event){
      alert("Muy pronto tendremos habilitada esta opción para ti");
      //$('.frmSapiensOrdersDigital, .bg').show();
    });

  	// Cerrar el formulario
  	$('.frmSapiensClose').click(function(event){
    	event.preventDefault();
    	$('.bg, .frmSapiensOrdersFisico, .frmSapiensOrdersDigital').fadeOut();
	});

	// Boton Guardar frm1
    $('#frmData1').submit(function(event){
      event.preventDefault();
      var book_url = jQuery(location).attr('href');
      var book_title = jQuery(document).attr('title');

      var data = $('#frmData1').serializeArray();
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

  // Boton Guardar frm2:  LIbro Fisico

  $('.frmNextTo2 ').click(function(event){
    event.preventDefault();
    

    name = $( "input[name$='names']" ).val();
    phone = $( "input[name$='phone']" ).val();
    mail = $( "input[name$='email']" ).val();
    delivery = $( "input[name$='delivery']:checked" ).val();
    address = $( "input[name$='address']" ).val();
    price = Number($( ".frmProductPrice" ).text());
    price_delivery = Number($( "input[name$='costo_delivery']:checked" ).val());

    if(name=="") {
      alert('Falta tu nombre');
      return false;
    }
    if(phone=="") {
      alert('Falta tu celular');
      return false;
    }
    if(mail=="") {
      alert('Falta tu correo electronico');
      return false;
    }
    if(delivery==0 && address=="") {
      alert('Falta tu direccion');
      return false;
    }
    $('.frmUserName').text(name);
    console.log(price + price_delivery);
    $('.frmTotal').text(price + price_delivery);

    $('.frmSapiensStep1').hide();
    $('.frmSapiensStep2').show();
  });

  $('#frmData2').submit(function(event){
    event.preventDefault();

    var order_details = $('#order_details').html();

    //var book_url = jQuery(location).attr('href');
    //var book_title = jQuery(document).attr('title');

    var data = $('#frmData2').serializeArray();
    //data.push({name: 'book_url', value: book_url});
    //data.push({name: 'book_title', value: book_title});
    data.push({name: 'order_details', value: order_details});

    //console.log(data);

    $.ajax({
      method: "post",
      url: base_module+"sapiens.orders.save.php",
      data: data
    })
    .done(function( data ) {
      if(data.resultado){
        $('.frmSapiensStep2').hide();
        $('.frmSapiensStep3').show();
        setTimeout(function(){
          window.location.href = base_url;
        }, 2000);
      }else{
        alert(data.contenido);
      }
    });
  });
});  