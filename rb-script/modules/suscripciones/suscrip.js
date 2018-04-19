$(document).ready(function() {
  $(".form-login").submit(function( event ){
    event.preventDefault();

    $.ajax({
      method: "post",
      url: "../rb-script/modules/suscripciones/save.suscriptor.php",
      data: $( this ).serialize()
    })
    .done(function( data ) {
      if(data.resultado){
        $.fancybox.close();
        alert(data.contenido);
      }else{
        alert(data.contenido);
      }
    });
  });
});
