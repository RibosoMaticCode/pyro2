// FUNCIONES GENERAL CON JQUERY
$(document).ready(function() {
  // Estableciendo valor de cuanto mostrar por lista, segun seccion:art, pages, com, etc
  $('#nums_items_show').on('change' , function(){
  	var nums_items_show = $('#nums_items_show').val();
  	var section = $('#nums_items_show').attr("name");
    console.log(nums_items_show+'-'+section);
  	$(location).attr('href','ajaxoptions.php?value='+nums_items_show+'&sec='+section);
  });
  // Cerrar sesion sistema - pregunta
  $( '#out' ).click(function() {
    var msg = confirm("¿Seguro de cerrar sesión?");
    if(!msg){
      return false;
    }
  });
  // Ocultar/mostrar bloque
  $( ".arrow-up" ).hide();
  $( ".more" ).click(function( event ) {
    event.preventDefault();
    $(this).closest(".seccion").find(".seccion-body").slideToggle();
  });
});