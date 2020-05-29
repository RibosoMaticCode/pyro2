// Validaciones
var base_url = window.location.origin+'/';

$(document).ready(function() {
	// Mostras proyectos
  	$('.btnMostrar').click(function(event){
	    event.preventDefault();
	    var univ = $('.univer').val().toLowerCase();
	    var tipo_lib = $('.tipo_lib').val().toLowerCase();
	    var area = $('.area').val().toLowerCase();

	    if(univ==0 || tipo_lib ==0 || area ==0){
	    	alert("Debe seleccionar las alternativas para mostrar");
	    	return false;
	    }
	    
	    window.location.href = base_url+'products-filter/'+univ+'/'+tipo_lib+'/'+area;
  	});
});  