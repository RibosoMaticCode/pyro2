<?php
/*
Module Name: Metropolitana
Plugin URI: http://jwmetropolitana.org
Description: Sistema de horarios, turnos y puntos de predicacion para Programa de Predicacion en Áreas Metropolitanas, de los Testigos de Jehová. Incluye mejoras de funcionamiento y visualizaciones.
Author: Jesus Liñan
Version: 1.1
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_module_path = "Predicación";
$rb_module_url_main = G_SERVER."/rb-admin/module.php";
$rb_module_url = G_SERVER."/rb-script/modules/metro/";
$rb_module_url_img = G_SERVER."/rb-script/modules/metro/img/icon_menu.png";

// Ubicacion en el Menu
//rb_add_item_menu(array(
$menu = array(
					'key' => 'predi',
					'nombre' => "Predicacion Metropolitana",
					'url' => "#",
					'url_imagen' => $rb_module_url_img,
					'pos' => 1,
					'show' => true,
					'item' => array(
						array(
							'key' => 'predi_ptos',
							'nombre' => "Puntos Predicacion",
							'url' => "module.php?pag=predi_ptos",
							'url_imagen' => "none",
							'pos' => 1,
							'show' => true
						),
						array(
							'key' => 'predi_alm',
							'nombre' => "Almacenes",
							'url' => "module.php?pag=predi_alm",
							'url_imagen' => "none",
							'pos' => 1,
							'show' => true
						),
						array(
							'key' => 'predi_pub',
							'nombre' => "Publicaciones",
							'url' => "module.php?pag=predi_pub",
							'url_imagen' => "none",
							'pos' => 1,
							'show' => true
						),
						array(
							'key' => 'predi_sal',
							'nombre' => "Salidas",
							'url' => "module.php?pag=predi_sal",
							'url_imagen' => "none",
							'pos' => 1,
							'show' => true
						)
					)
				);

function metro_css(){
	global $rb_module_url;
	$css = '<link rel="stylesheet" href="'.$rb_module_url.'css/metro.css">';
	return $css;
}

// Seccion: Puntos de Predicacion
if(isset($_GET['pag']) && $_GET['pag']=="predi_ptos"):
	$rb_module_title = "Predicación";
	$rb_module_title_section = "Puntos de Predicación";

	function rb_content_main(){
		global $rb_module_url_main;
		global $rb_module_url;
		if(isset($_GET['opc'])):
			$opc=$_GET['opc'];
			include('puntos.edit.php');
		else:
			?>
			<div id="sidebar-left">
				<ul class="buttons-edition">
					<li><a class="btn-primary" href="<?= $rb_module_url_main ?>?pag=predi_ptos&opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
					<li><a class="btn-primary" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Editar</a></li>
					<li><a class="btn-primary" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
				</ul>
			</div>
			<script>
			$(document).ready(function() {
				$('.delete-link').click(function( event ){
					event.preventDefault();
					var id = $(this).attr('id');
					console.log(id);
					var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
					if ( eliminar ) {
						$.ajax({
							url: '<?= $rb_module_url ?>puntos.del.php?pto_id='+id,
							cache: false,
							type: "GET",
							success: function(datos){
								if(datos=="1"){
									console.log("Eliminado correctamente");
									$('#f_'+id).children().addClass('deleteHighlight');
									$('#f_'+id).children().fadeOut(500);

								}else{
									console.log("Error");
								}
							}
						});
					}
				});
			});
			</script>
			<div class="wrap-content-list">
				<section class="seccion">
					<table class="tables">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripción</th>
								<th>Turnos</th>
								<th>Horarios</th>
							</tr>
						</thead>
						<tbody>
							<?php include('puntos.list.php') ?>
						</tbody>
					</table>
				</section>
			</div>
			<?php
		endif;
	}

	add_function('panel_header_css','metro_css');
	add_function('module_content_main','rb_content_main');
endif;

// Seccion: Turnos
if(isset($_GET['pag']) && $_GET['pag']=="predi_tur"):
	$rb_module_title = "Predicación";
	$rb_module_title_section = "Turnos de Predicación";
	if(isset($_GET['opc'])):
		$opc=$_GET['opc'];
		include('turnos.form.php');
	else:
		include('turnos.php');
	endif;
	add_function('panel_header_css','metro_css');
endif;

// Seccion: Horarios
if(isset($_GET['pag']) && $_GET['pag']=="predi_hor"):
	$rb_module_title = "Predicación";
	$rb_module_title_section = "Horarios";
	if(isset($_GET['opc'])):
		$opc=$_GET['opc'];
		include('horarios.form.php');
	else:
		include('horarios.php');
	endif;
	add_function('panel_header_css','metro_css');
endif;

// Seccion: Almacenes
if(isset($_GET['pag']) && $_GET['pag']=="predi_alm"):
	$rb_module_title = "Predicación";
	$rb_module_title_section = "Almacenes";

	if(isset($_GET['opc'])):
		$opc=$_GET['opc'];
	else:
		include_once 'almacen.php';
	endif;
endif;

// Seccion: Salidas
if(isset($_GET['pag']) && $_GET['pag']=="predi_sal"):
	$rb_module_title = "Predicación";
	$rb_module_title_section = "Salidas";

	if(isset($_GET['opc'])):
		$opc=$_GET['opc'];
	else:
		include_once 'salidas.php';
	endif;
endif;

// SECCION PUBLICACIONES :
if(isset($_GET['pag']) && $_GET['pag']=="predi_pub"):
	$rb_module_url = G_SERVER."/rb-script/modules/metro/";
	$rb_module_title = "Predicación";
	$rb_module_title_section = "Publicaciones";

	function rb_content_publicaciones(){
		global $rb_module_url_main;
		$rb_module_url = G_SERVER."/rb-script/modules/metro/";
		$urlreload = G_SERVER."/rb-admin/module.php?pag=predi_pub";
		//$rb_module_path = "Cotizaciones";

		if(isset($_GET['opc'])):
			$opc=$_GET['opc'];
		else:
			?>
			<script>
			$(document).ready(function() {
				$('.del-item').click(function( event ){
					event.preventDefault();
					var id = $(this).attr('data-id');

					var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
					if ( eliminar ) {
						$.ajax({
							url: '<?= $rb_module_url ?>publi.del.php?id='+id,
							cache: false,
							type: "GET",
							success: function(data){
								if(data.resultado=="ok"){
									notify('Eliminado');
						    		$( "#result-block" ).show().delay(5000);
									$( "#result-block" ).html(data.contenido);
									setTimeout(function(){
										window.location.href = '<?= $urlreload ?>';
									}, 1000);
								}

							}
						});
					}
				});
			});
			</script>
			<div class="help" data-name="cot_cli">
	           	<h4>Información</h4>
	           	<p>Esta seccion lista las publicaciones que se usan en la predicacion metropolitana.</p>
				<a id="help-close" class="help-close" href="#">X</a>
			</div>
			<div id="sidebar-left">
				<ul class="buttons-edition">
					<li><a class="fancybox fancybox.ajax btn-primary" href="<?= $rb_module_url ?>publi.frm.php"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
				</ul>
			</div>
			<div class="wrap-content-list">
				<section class="seccion">
					<table class="tables">
						<thead>
							<tr>
								<th>Imagen Portada</th>
								<th>Titulo</th>
								<th>Codigo</th>
							</tr>
						</thead>
						<tbody>
							<?php include('publi.list.php') ?>
						</tbody>
					</table>
				</section>
			</div>
			<?php
		endif;
	}

	add_function('module_content_main','rb_content_publicaciones');
endif;
?>
