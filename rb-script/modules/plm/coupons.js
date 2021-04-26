var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/plm/';

$(document).ready(function() {
	$('#table').DataTable({
            "language": {
              "url": "resource/datatables/Spanish.json"
            }
          });

	// Eliminar item
	$('.del').on("click", function(event){
	  event.preventDefault();
	  var eliminar = confirm("La eliminacion es permanente. ¿Desea continuar?");
	  if ( eliminar ) {
	    var id = $(this).attr('data-item');
	    $.ajax({
	      type: "GET",
	      url: base_module+"coupons.del.php?id="+id
	    })
	    .done(function( data ) {
	      if(data.resultado){
	        notify(data.contenido);
	        setTimeout(function(){
	          window.location.href = base_url+'/rb-admin/module.php?pag=plm_coupons';
	        }, 1000);
	      }else{
	        notify(data.contenido);
	      }
	    });
	  }
	});

	// Boton Guardar
    $('#frmEdit').submit(function(event){
      	event.preventDefault();

      	$.ajax({
        	method: "post",
        	url: base_module+"coupons.save.php",
        	data: $( this ).serialize()
      	})
      	.done(function( data ) {
        	if(data.resultado){
          		$.fancybox.close();
          		notify(data.contenido);
          		setTimeout(function(){
            		window.location.href = base_url+'/rb-admin/module.php?pag=plm_coupons&coupon_id='+data.id;
          		}, 1000);
        	}else{
          		notify(data.contenido);
        	}
      	});
    });
});