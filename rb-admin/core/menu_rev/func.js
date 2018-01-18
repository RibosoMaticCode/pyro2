$(document).ready(function() {
  var uniqueId = function() {
    return Math.random().toString(36).substr(2, 16);
  };

  // Mostrar el editor de Item
  $('#addItem').click(function(){
    $('#items_menu').append('<li>'+uniqueId()+'</li>');

    $('.bg-opacity, #editor-items').show();
  });
});
