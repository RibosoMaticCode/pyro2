<?php
header('Content-Type: application/javascript');
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once(__ROOT__.'/rb-script/funciones.php');
require_once(__ROOT__.'/rb-script/class/rb-database.class.php');

$objetos = rb_get_values_options('objetos');
$array = explode(",",$objetos);
$array_count = count($array);

$i=0;
?>
// funciones nuevas con jquery
$(document).ready(function () {
	$( "#btn-menu" ).click(function() {
	  $( ".items" ).toggle( "slow", function() {
	    // Animation complete.
	  });
	});
	var idnext = 0;

	$( "#newexterno" ).click(function() {
		event.preventDefault();
		$('#t_externo tr:last').after('<tr>'+
			'<td>'+
				'<select name="externo['+idnext+'][tipo]">'+
				<?php
				while($i<$array_count):
					echo "'<option value=\"".$i."\">".trim($array[$i])."</option>'+\n";
					$i++;
				endwhile;
				?>
				'</select>'+
			'</td>'+
			'<td><textarea name="externo['+idnext+'][contenido]"></textarea></td>'+
			'<td><a title="Borrar" class="newdelete" href="#"><img src="img/del-red-16.png" alt="delete" /></a></td>'+
			'</tr>');
		idnext++;
	});

	$("#t_externo").on("click", ".newdelete", function (event) {
    	$(this).closest("tr").remove();
    });


    /* imagenes destacadas */
	var control1 = $("#control1");
    $("#img1").on("click", function (event) {
    	control1.replaceWith( control1 = control1.clone( true ) );
    });

    var control2 = $("#control2");
    $("#img2").on("click", function (event) {
    	control2.replaceWith( control2 = control2.clone( true ) );
    });

    var control3 = $("#control2");
    $("#img3").on("click", function (event) {
    	control3.replaceWith( control3 = control3.clone( true ) );
    });

    // borrar valor de input 1
    var filename1 = $("#namefile1");
    var vfilename1;
    $("#cnamefile1").on("click", function (event) {
    	vfilename1 = filename1.val();
    	filename1.val("");
    	$("#wnamefile1").hide();
    	$("#wredo1").show();
    });

    $("#redo1").on("click", function (event) {
    	filename1.val(vfilename1);
    	$("#wnamefile1").show();
    	$("#wredo1").hide();
    });

    // borrar valor de input 2
    var filename2 = $("#namefile2");
    var vfilename2;
    $("#cnamefile2").on("click", function (event) {
    	vfilename2 = filename2.val();
    	filename2.val("");
    	$("#wnamefile2").hide();
    	$("#wredo2").show();
    });

    $("#redo2").on("click", function (event) {
    	filename2.val(vfilename2);
    	$("#wnamefile2").show();
    	$("#wredo2").hide();
    });

    // borrar valor de input 3
    var filename3 = $("#namefile3");
    var vfilename3;
    $("#cnamefile3").on("click", function (event) {
    	vfilename3 = filename2.val();
    	filename3.val("");
    	$("#wnamefile3").hide();
    	$("#wredo3").show();
    });

    $("#redo3").on("click", function (event) {
    	filename3.val(vfilename3);
    	$("#wnamefile3").show();
    	$("#wredo3").hide();
    });

    //hide/show section
    

    /*$( "#section1" ).click(function() {
    	$("#objects-extern").toggle();
    	$(this).find(".arrow-up, .arrow-down").toggle();
    });*/
    $( "#section2" ).click(function() {
    	$("#featured-image").toggle();
    	$(this).find(".arrow-up, .arrow-down").toggle();
    });





	/******* FUNCIONES EXPLORER **********/
	$( '.dialog' ).click(function() {
		var controlHideId = $(this).attr('data-inputhide');
		var controlShowId = $(this).attr('data-inputshow');
		$.post( "files.explorer.php?controlShowId="+controlShowId+"&controlHideId="+controlHideId , function( data ) {
		 	$('.explorer').html(data);
		 	$(".bg-opacity").show();
	   		$(".explorer").fadeIn(500);
		});
	});

	/*$( '.newgallery' ).click(function() {
		var articuloId = $(this).attr('id');
		$.post( "gallery.explorer.php?articulo_id="+articuloId , function( data ) {
		 	$('.explorer').html(data);
		 	$(".bg-opacity").show();
	   		$(".explorer").fadeIn(500);
		});
	});*/


	//$( '.galleries' ).click(function() { // METODO .on => Permite usar elementos del DOM creados en ejecucion


	$( '#alblist' ).on("click", ".viewgallery", function( event ){
		var albumId = $(this).attr('data-id');
		$.post( "explorer.photos.php?album_id="+albumId , function( data ) {
		 	$('.explorer').html(data);
		 	$(".bg-opacity").show();
	   		$(".explorer").fadeIn(500);
		});
	});

	// FUNCIONES DE LOS ICONOS: BORRAR, VER Y MOSTRAR EL FILE-EXPLORER

	$( '#file-delete' ).click(function( event ) {
		$( '#photo' ).val("");
		$( '#photo_id' ).val("0");
	});

	$( '#file-view' ).click(function( event ) {
		var photo = $( '#photo' ).val();
		if(photo!="" || photo==="0"){
			$('.explorer').html('<p style="text-align:center"><img style="max-width:300px;width:100%" src="<?= rb_get_values_options('direccion_url') ?>/rb-media/gallery/'+photo+'" alt="img" /></p>');
		 	$(".bg-opacity").show();
	   		$(".explorer").fadeIn(500);
	   	}
	});

});

$(window).load(function(){
	$(window).resize();
});

$(window).resize(function(){
	/*var mql = window.matchMedia("screen and (max-width: 600px)");

	if (mql.matches){ // if media query matches
		// en caso algunas acciones
	}else{
		var hscr = $(window).height() - $('.items').height() - $('#footer').height() - 55;
		$('#content-list').css("height", hscr);

	}*/

	var box_width = $('.cover-img').width();
	$('.cover-img').css("height", box_width);
	$('.cover-img > a').css("height", box_width);
});
/*-------------------------------*/


function nuevoAjax(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}

	return xmlhttp;
}

function more(html_element){
	htmlE = document.getElementById(html_element);
	if(htmlE.style.display == "none"){
		htmlE.style.display = "block";
	}else{
		htmlE.style.display = "none";
	}
}



function MostrarInactivos(artinact){
	resul = document.getElementById('resultado');

	ajax=nuevoAjax();
	resul.innerHTML = '<span style="width:200px;height:30px;background-color:#FF0000;color:#FFF">Espere ...</span>';
	ajax.open("GET", "ajax_busqueda.php?sec="+artinact,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			resul.innerHTML = ajax.responseText;
		}
	};
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(null);
}

function CambiarFecha(){
	var hora = new Date();
	ano=hora.getFullYear();
	mes=hora.getMonth()+1;
	dia=hora.getDate();
	hor=hora.getHours();
	mim=hora.getMinutes();
	sec=hora.getSeconds();
	fecha=ano+"-"+mes+"-"+dia+" "+hor+":"+mim+":"+sec;
	document.formulario.fecha.value=fecha;
}
function buscarDato(seccion){
	resul = document.getElementById('resultado');

	bus=document.frmBuscar.dato.value;

	ajax=nuevoAjax();
	resul.innerHTML = '<p style="text-align:center;"><img src="../../estilos/pordefecto/esperando.gif" /></p>';
	ajax.open("POST", "ajax_busqueda.php?sec="+seccion,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			resul.innerHTML = ajax.responseText;
		}
	};
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("busqueda="+bus);
}

// publicar articulo
function activarArticulo(id){
	event.preventDefault();
	var activar = confirm("Esta seguro de continuar ... ?");
	if (activar) {
		div_art = document.getElementById('boxart_'+id);
		var valores="article_id="+id;
		ajax=nuevoAjax();
		ajax.open("GET","publication.active.php?"+valores);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				var datos=ajax.responseXML.documentElement;
				var item = datos.getElementsByTagName('elemento')[0];
				var state = item.getElementsByTagName('estado')[0].firstChild.data;
				if(state==0){
					alert('Error');
				}else{
					cond = item.getElementsByTagName('condicion')[0].firstChild.data;
					if(cond=='D'){
						div_art.innerHTML="<a href=\"#\" title=\"Activar Articulo\" onclick=\"activarArticulo("+id+")\">Publicar</a>";
					}else{
						div_art.innerHTML="<a href=\"#\" title=\"Desactivar Articulo\" onclick=\"activarArticulo("+id+")\">No Publicar</a>";
					}
				}
			}
		};
		ajax.send(null);
	}
}

// permitir comentarios
function permitirComentario(id){
	var activar = confirm("Esta seguro de continuar ... ?");
	if (activar) {
		div_art = document.getElementById('boxcom_'+id);
		var valores="article_id="+id;
		ajax=nuevoAjax();
		ajax.open("GET","publication.allow.comment.php?"+valores);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				var datos=ajax.responseXML.documentElement;
				var item = datos.getElementsByTagName('elemento')[0];
				var state = item.getElementsByTagName('estado')[0].firstChild.data;
				if(state==0){
					alert('Error');
				}else{
					cond = item.getElementsByTagName('condicion')[0].firstChild.data;
					//alert(cond);
					if(cond=='D'){
						div_art.innerHTML="<a title=\"Permitir comentarios\" onclick=\"permitirComentario("+id+")\"><img src=\"img/cancel.png\" alt=\"Activo\" /></a>";
					}else{
						div_art.innerHTML="<a title=\"No permitir comentarios\" onclick=\"permitirComentario("+id+")\"><img src=\"img/accept.png\" alt=\"Desactivado\"/></a>";
					}
				}
			}
		};
		ajax.send(null);
	}
}
var i=1;

function seleccionar(cat){
	seleccion=document.formulario.cat_select.value;
	//metodo split crea un arreglo
	arreglo=seleccion.split(",");
	//contamos cuantos elementos tiene el arreglo
	elementos=arreglo.length;
	//bucle y comparamos sin existe categoria
	if(elementos.length>1){
		seleccion=seleccion+" "+cat;
	}else{
		for(j=0;j>elementos-1;j++){

			catact=arreglo[j];
			//si categoria actual = a cat evaluada
			if(catact==cat){
				seleccion=seleccion;
			}else{
				if(i>1){
					seleccion=seleccion+", "+cat;
				}else{
					seleccion=seleccion+" "+cat;
				}
			}
		}
	}

	document.formulario.cat_select.value=seleccion;
	i=i+1;
}

function generar_enlace(){
	var titulo = document.getElementById('titulo').value;
	var titulo_enlace = document.getElementById('titulo-enlace');

	ajax=nuevoAjax();
	ajax.open("GET", "ajax_generar_enlace.php?titulo="+titulo);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			titulo_enlace.value = ajax.responseText;
		}
	};
	ajax.send(null);
}


/*** CALENDAR FUNCTIONS ***/
function update_calendar(){
	var month = $('#calendar_mes').val();
	var year = $('#calendar_anio').val();
	var valores='month='+month+'&year='+year;

	$.ajax({
		url: '/rb-admin/resource/cal/setvalue.php',
		type: "GET",
		data: valores,
		success: function(datos){
			$("#calendario_dias").html(datos);
		}
	});
}

function set_date(date){
	//input text donde debe aparecer la fecha
	$('#fecha').attr('value',date);
	show_calendar();
}

function show_calendar(){
	//div donde se mostrará calendario
	$('#calendario').toggle('slow');
}
