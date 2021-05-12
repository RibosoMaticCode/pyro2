var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/plm/';

$(document).ready(function() {
	/* Cupones */
	$('#coupon_apply').prop('disabled',true);

	$('#coupon_code').keyup(function(event) {
	    if( $('#coupon_code').val().length > 0 ){
	    	$('#coupon_apply').prop('disabled',false);
	    }else{
	    	$('#coupon_apply').prop('disabled',true);
	    }
	});

	/* Aplicar cupon */
	$('#coupon_apply').click(function(event){
		event.preventDefault();
		var code = $('#coupon_code').val();
		if(code=="") {
			alert("Ingrese un codigo de descuento");
			return false;
		}
      	$.ajax({
        	method: "get",
        	url: base_module+"coupons.validate.php?code="+code,
      	})
      	.done(function( data ) {
      		console.log( data );
        	if(!data.result){
        		alert(data.message);
        		return false;
        	}
        	window.location.href = base_url + 'shopping-cart/';
        	/*$('#coupon_detail').html(data.coupon.description);
        	$('#tot_discount').html( data.coin +' ' + data.tot_discount_text );
        	$('#total').html( data.tot_update );*/
      	});
	});

	/* Retirar cupon */
	$('#coupon_retire').click(function(event){
		event.preventDefault();
      	$.ajax({
        	method: "get",
        	url: base_module+"coupons.retire.php",
      	})
      	.done(function( data ) {
        	window.location.href = base_url + 'shopping-cart/';
      	});
	});

	/* Realizar solo pedido sin logueo */

	/* Mostra el formulario para cliente complete sus datos */
	$('#btnShowClientForm').click(function(event){
		event.preventDefault();
      	$('.bg, .frmOrder').show();
	});

	$('#btnCloseClientForm').click(function(event){
		event.preventDefault();
		$('.bg, .frmOrder').hide();
	});

	/* Realizar el pedido */
	$('#orderFormClient').submit(function(event){
		event.preventDefault();
		var data_client_inputs = $("#orderFormClient").serializeArray();
		var data_client = {};
		$(data_client_inputs).each(function(index, obj){
			data_client[obj.name] = obj.value;
		});
		console.log(data_client);		
		$.ajax({
			method: "get",
			url: base_module+"payment.success.php?method=order_only&data_client="+JSON.stringify(data_client)
		})
		.done(function( data ) {
			if(data.resultado){
				$('#orderFormClient').remove();
				$('#orderResultMessage').append(data.result_message);
				$('#btnCloseClientForm').hide();
			}else{
				alert(data.contenido);
				console.log(data.contenido);
			}
		});
	});
});