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

  // Activar articulo
  $(".active").click(function( event ){
    event.preventDefault();
    var post_id = $(this).attr('data-postid');
    var post_state = $(this).attr('data-state');
    $.ajax({
        method: "POST",
        url: "../rb-admin/core/pubs/pub-active.php?activo="+post_state+"&article_id="+post_id,
    }).done(function( data ) {
      if(data.estado==0){
        notify('Publicacion desactivada');
        console.log(data.estado);
      }
      if(data.estado==1){
        notify('Publicacion desactivada');
        console.log(data.estado);
      }
    });
  });

  // Simple CSS Split-button
  var splitBtn = $('.x-split-button');

  $('button.x-button-drop').on('click', function() {
    if (!splitBtn.hasClass('open'))
        splitBtn.addClass('open');
  });

  $('.x-split-button').click(function(event){
    event.stopPropagation();
  });

  $('html').on('click',function() {
   if (splitBtn.hasClass('open'))
    splitBtn.removeClass('open');
  });

  // Tabs
  $('#tabcontent1').show(); // first tab content hide
  $('.tabs-buttons input').on('click', function(event) {
  //$('.tabs-buttons input').click(function(event){
    $('.tabs-sections section').hide();
    if($('.tabs-buttons input:checked')){
      var tab_id = $(this).attr('id').substr(3,2);
      $('#tabcontent'+tab_id).show();
    }
  });
});

// Notificador principal
var notify = function(text, time = 2000){
  console.log('hi!');
  $("#message").show();
  $("#message").html('<h3>'+text+'</h3>');
  $("#message").animate({ "top": "+=50px", "opacity" : 1 }, "slow" );
  $("#message").delay(time).animate({ "top": "-=50px", "opacity" : 0 }, "slow" );
}
