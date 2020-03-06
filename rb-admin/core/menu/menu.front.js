$(document).ready(function() {
  // Menu Mostrar/Ocultar
  $('.btnMenuOpen').on("click", function(event){
    event.preventDefault();
    $('.menu_main').animate({
      width: "toggle"
    });
    $('.btnMenuClose').show();
  });
  $('.btnMenuClose').on("click", function(event){
    event.preventDefault();
    $('.menu_main, .btnMenuClose').hide();
  });
});
$(window).resize(function() {
  // Detectar ancho de pantalla
  var $window = $(window);
  function checkWidth() {
    var windowsize = $window.width();
    if (windowsize > 425) {
      $('.menu_main').show();
      $('.btnMenuClose').hide();
    }else{
      $('.menu_main').hide();
    }
  }

  // Execute on load
  checkWidth();
});
