var base_url = window.location.origin+'/';
var base_module = base_url+'rb-script/modules/boletin/';
var base_dashboard = base_url+'rb-admin/';

$(document).ready(function() {
   // Boton Cancelar
  $('.CancelFancyBox').on('click',function(event){
  	$.fancybox.close();
  });

  // Boton Guardar
  $('#frmEdit').submit(function(event){
   	event.preventDefault();
  	tinyMCE.triggerSave(); //save first tinymce en textarea
  	
    $.ajax({
  		method: "post",
  		url: base_module+"contenido.save.php",
  		data: $( this ).serialize()
  	})
  	.done(function( data ) {
  		if(data.result){
  		  notify(data.message);
  		  setTimeout(function(){
          window.location.href = base_dashboard+'module.php?pag=boletin_contenidos&id='+data.id;
        }, 1000);
   	  }else{
   			notify(data.message);
   	  }
  	});
  });

  // Eliminar
  $('.del').on("click", function(event){
    event.preventDefault();
    var eliminar = confirm("[?] Esta seguro de eliminar este valor?");  
    if ( eliminar ) {
      var id = $(this).attr('data-item');
      $.ajax({
        type: "GET",
        url: base_module+"contenido.del.php?id="+id
      })
      .done(function( data ) {
        if(data.resultado){
          notify(data.contenido);
          setTimeout(function(){
            window.location.href = base_dashboard+'module.php?pag=boletin_contenidos';
          }, 1000);
        }else{
          notify(data.contenido);
        }
      });
    }
  });
});