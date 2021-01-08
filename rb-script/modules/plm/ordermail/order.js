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
      url: base_module+"ordermail/order.send.php",
      data: data
    })
    .done(function( data ) {
      if(data.resultado){
        $('.frmSapiensStep1').hide();
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