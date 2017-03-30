/*!
 * jQuery lightweight plugin boilerplate
 * Original author: @ajpiano
 * Further changes, comments: @addyosmani
 * Licensed under the MIT license
 */


// the semi-colon before the function invocation is a safety 
// net against concatenated scripts and/or other plugins 
// that are not closed properly.
;(function ( $, window, document, undefined ) {
    
    // undefined is used here as the undefined global 
    // variable in ECMAScript 3 and is mutable (i.e. it can 
    // be changed by someone else). undefined isn't really 
    // being passed in so we can ensure that its value is 
    // truly undefined. In ES5, undefined can no longer be 
    // modified.
    
    // window and document are passed through as local 
    // variables rather than as globals, because this (slightly) 
    // quickens the resolution process and can be more 
    // efficiently minified (especially when both are 
    // regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = 'filexplorer',
        defaults = {
            propertyName: "value"
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        // jQuery has an extend method that merges the 
        // contents of two or more objects, storing the 
        // result in the first object. The first object 
        // is generally empty because we don't want to alter 
        // the default options for future instances of the plugin
        this.options = $.extend( {
        	inputHideValue : "0"
        }, defaults, options) ;
        
        this._defaults = defaults;
        this._name = pluginName;
        
        this.init();
    }

    Plugin.prototype.init = function () {
        // Place initialization logic here
        // You already have access to the DOM element and
        // the options via the instance, e.g. this.element 
        // and this.options
        
    };

    // A really lightweight plugin wrapper around the constructor, 
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
            	// Obtener valor de la opciones = el valor por defecto del campo oculto
            	var hideValue = options.inputHideValue;
            	
            	// Obtener nombre del control, que pide instancia
            	var name_control = $(this).attr('name');
            	console.log(name_control);
            	
            	// Estableciendo ID al control visible de acuerdo al nombre
            	$(this).attr( "id" , name_control );
            	
            	// Creando la envoltura para losbotones
            	var element_new = $(this).wrapAll('<div class="cover-input-dialog">');
            	
            	// Creando input hidden y sus atributos
            	var $inputHide = $("<input>", {type: 'hidden', id: name_control+'_id', name: name_control+'_id', value: hideValue} );
            	$( element_new ).after($inputHide); 
            	
            	// Creando cover btns para buscar, ver y eliminar
            	var $coverBtns = $("<span>", {class: "icons"});
            	$( element_new ).after($coverBtns); 
            	
            	// Creando botones = BUSCAR
            	var $btnSearch = $("<a>", {href: "#"});
            	$( $coverBtns ).append($btnSearch);
            	
            	// Añadimos imagen a boton = BUSCAR
            	var $imgSearch = $("<img>", {src: "img/search-gray-16.png", alt: "img", class: "icon-search" });
            	$( $btnSearch ).append($imgSearch);
            	
            	// Creando botones = VER
            	var $btnView = $("<a>", {href: "#"});
            	$( $coverBtns ).append($btnView);
            	
            	// Añadimos imagen a boton = VER
            	var $imgView = $("<img>", {src: "img/view-gray-16.png", alt: "img", class: "icon-view" });
            	$( $btnView ).append($imgView);
            	
            	// Creando botones = ELIMINAR
            	var $btnDelete = $("<a>", {href: "#"});
            	$( $coverBtns ).append($btnDelete);
            	
            	// Añadimos imagen a boton = ELIMINAR
            	var $imgDelete = $("<img>", {src: "img/del-gray-16.png", alt: "img", class: "icon-delete" });
            	$( $btnDelete ).append($imgDelete);
            	
            	// **** EVENTOS ******
            	
            	// Funcion para mostrar la ventana explorador de imagenes
			    showNextImage = function(event){
			    	event.preventDefault();
			    	var controlHideId = name_control+"_id";
					var controlShowId = name_control;
			    	$.post( "../rb-script/modules/rb-explorer/files.explorer.php?controlShowId="+controlShowId+"&controlHideId="+controlHideId , function( data ) {
					 	$('.explorer').html(data);
						$(".bg-opacity").show();
						$(".explorer").fadeIn(500);
					});
			    };
			    // Evento click en el boton busqueda
			    $btnSearch.on( "click", showNextImage );
			    
			    // Funcion para ver imagen
			    viewImage = function(event){
			    	event.preventDefault();
			    	var controlShowId = name_control;
			    	var photo = $( '#'+controlShowId ).val();
					if(photo!="" || photo==="0"){
						$('.explorer').html('<div class="explorer-header"><h3>Explorar archivos</h3><a id="close" href="#">×</a></div><p style="text-align:center"><img style="max-width:300px;width:100%" src="../rb-media/gallery/'+photo+'" alt="img" /></p>');
					 	$(".bg-opacity").show();
						$(".explorer").fadeIn(500);
					}
			    };
			    // Evento click en el boton borrar
			    $btnView.on( "click", viewImage );
			    
			    // Funcion borrar elementos elegido
			    deleteImage = function(event){
			    	event.preventDefault();
			    	var controlHideId = name_control+"_id";
					var controlShowId = name_control;
			    	$( '#'+controlHideId ).val("0");
			    	$( '#'+controlShowId ).val("");
			    };
			    // Evento click en el boton borrar
			    $btnDelete.on( "click", deleteImage );
			    
			    /*function viewImage( event ){
			    	var controlShowId = name_control;
			    	var photo = $( '#'+controlShowId ).val();
					if(photo!="" || photo==="0"){
						$('.explorer').html('<p style="text-align:center"><img style="max-width:300px;width:100%" src="../rb-media/gallery/'+photo+'" alt="img" /></p>');
					 	$(".bg-opacity").show();
						$(".explorer").fadeIn(500);
					}
			    }*/
			    
			    // Evitar repeticion de instancias
                $.data(this, 'plugin_' + pluginName, 
                new Plugin( this, options ));
            }
            
        });
    };

})( jQuery, window, document );