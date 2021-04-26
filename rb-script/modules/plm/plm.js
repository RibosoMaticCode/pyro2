var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/plm/';

$(document).ready(function() {
	/* VALIDACIONES */
	$('#coupon_apply').prop('disabled',true);

	$('#coupon_code').keyup(function(event) {
	    if( $('#coupon_code').val().length > 0 ){
	    	$('#coupon_apply').prop('disabled',false);
	    }else{
	    	$('#coupon_apply').prop('disabled',true);
	    }
	});

	/* APLICAR */
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
});