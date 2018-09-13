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

    var uniqueId = function() {
      return Math.random().toString(36).substr(2, 16);
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

              // Identificador unico para control visible e invisible
              var id_control = uniqueId();

              // Estableciendo nombre del control oculto
              name_control_hidden = name_control+'_id';

              // Si es un array de controles, osea "[]"
              var lastChar = name_control.substr(name_control.length - 2); // Verificamos si es array []
              if(lastChar=="[]"){
                name_control = name_control.substring(0, name_control.length - 2); // Le sacamos los []
                name_control_hidden = name_control+'_id[]'; // añadirlos al final del _id
              }

            	console.log(name_control+':'+name_control_hidden);

            	// Estableciendo ID al control visible de acuerdo al nombre
            	$(this).attr( "id" , id_control );

            	// Creando la envoltura para losbotones
            	var element_new = $(this).wrapAll('<div class="cover-input-dialog">');

            	// Creando input hidden y sus atributos, este tiene como ID, el identicador unico + '_id'
            	var $inputHide = $("<input>", {type: 'hidden', id: id_control+'_id', name: name_control_hidden, value: hideValue} ); // antes -> name_control+'_id'
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
            $('#img_loading').show();
            $(".bg-opacity").show();
			    	var controlHideId = id_control+"_id"; // id del control oculto que contendra el ID real de la foto
					  var controlShowId = id_control; // id del Control visible que contendra el Nombre de la foto (archivo)
			    	$.post( "../rb-admin/core/explo-uploader/files.explorer.php?controlShowId="+controlShowId+"&controlHideId="+controlHideId , function( data ) {
  					 	$('.explorer').html(data);
  						$(".explorer").fadeIn(500);
  					});
			    };
			    // Evento click en el boton busqueda
			    $btnSearch.on( "click", showNextImage );

			    // Funcion para ver imagen
			    viewImage = function(event){
			    	event.preventDefault();
			    	var controlShowId = id_control;
			    	var photo = $( '#'+controlShowId+"_id" ).val();
            console.log(photo);
  					if(photo > 0){
              $('#img_loading').show();
              $(".bg-opacity").show();
              $.post( "../rb-admin/core/explo-uploader/files.explorer.view.php?file_id="+photo , function( data ) {
    					 	$('.explorer').html(data);
    						$(".explorer").fadeIn(500);
    					});
  					}
			    };
			    // Evento click en el boton borrar
			    $btnView.on( "click", viewImage );

			    // Funcion borrar elementos elegido
			    deleteImage = function(event){
			    	event.preventDefault();
			    	var controlHideId = id_control+"_id";
					  var controlShowId = id_control;
			    	$( '#'+controlHideId ).val("0");
			    	$( '#'+controlShowId ).val("");
			    };
			    // Evento click en el boton borrar
			    $btnDelete.on( "click", deleteImage );

			    // Evitar repeticion de instancias
          $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
      }
    });
  };
})( jQuery, window, document );
