<?php
/*
Module Name: Emocion Apps
Plugin URI: http://emocion.pe
Description: Aplicaciones desarrolladas para Branding Emocion
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$dir_name_mod = "mod_emocion";
$rb_module_title = "Aplicaciones Emocion";
$rb_module_title_section = "Aplicaciones Emocion";
$rb_module_url = G_SERVER."/rb-script/modules/".$dir_name_mod."/";
$rb_module_url_main = G_SERVER."/rb-admin/module.php";
$rb_module_url_img = G_SERVER."/rb-script/modules/".$dir_name_mod."/img/icon_menu.png";

// Ubicacion en el Menu
$menu = [
					'key' => 'emocion',
					'nombre' => "Branding Emocion",
					'url' => "#",
					'url_imagen' => $rb_module_url_img,
					'pos' => 1,
					'show' => true,
					'item' => [[
							'key' => 'emo_sendmailfile',
							'nombre' => "Enviar archivos",
							'url' => "module.php?pag=emo_sendmailfile",
							'url_imagen' => "none",
							'pos' => 1,
							'show' => true
						],[
							'key' => 'emo_clientes',
							'nombre' => "Clientes",
							'url' => "module.php?pag=emo_clientes",
							'url_imagen' => "none",
							'pos' => 2,
							'show' => true
						]]
				];
function rb_emocion_css(){
	global $rb_module_url;
	$css = '<link rel="stylesheet" href="'.$rb_module_url.'css/emocion.css">';
	return $css;
}
// SECCION LISTADO DE ARCHIVOS ENVIADOS
if(isset($_GET['pag']) && $_GET['pag']=="emo_sendmailfile"):
	$rb_module_title = "Adjuntar archivos";
	$rb_module_title_section = "Envio de archivos adjuntos";

	function rb_emocion_main(){
		global $rb_module_url_main;
		global $rb_module_url;
		if(isset($_GET['opc'])):
			$opc=$_GET['opc'];
			//include('puntos.edit.php');
		else:
			?>
			<script>
			$(document).ready(function() {
				$(".winfloat").fancybox({
					helpers : {
		  			overlay : {closeClick: false}
					}
				});
			});
			</script>
			<div id="sidebar-left">
				<ul class="buttons-edition">
					<li><a class="btn-primary winfloat fancybox.ajax" href="<?= $rb_module_url ?>sendfile_new.php" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Enviar archivos</a></li>
					<li><a class="btn-primary winfloat fancybox.ajax" href="<?= $rb_module_url ?>sendlink_new.php" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Enviar vínculos</a></li>
				</ul>
			</div>
			<script>
			$(document).ready(function() {
				$('.del-sendfile').click(function( event ){
					event.preventDefault();
					var id = $(this).attr('data-id');
					console.log(id);
					var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
					if ( eliminar ) {
						$.ajax({
							url: '<?= $rb_module_url ?>sendfile_del.php?id='+id,
							cache: false,
							type: "GET",
							success: function(data){
								if(data.resultado=="ok"){
									notify('Eliminado');
									$('#f_'+id).children().addClass('deleteHighlight');
									$('#f_'+id).children().fadeOut(500);
								}else{
									console.log("Error: Recargue página");
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
								<th>Vinculo</th>
								<th>Emisor</th>
								<th>Destinatario(s)</th>
								<th>Archivos / Vinculos</th>
								<th>Fecha envio</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php include('sendfile_list.php') ?>
						</tbody>
					</table>
				</section>
			</div>
			<?php
		endif;
	}

	add_function('panel_header_css','rb_emocion_css');
	add_function('module_content_main','rb_emocion_main');
endif;
//
if(isset($_GET['pag']) && $_GET['pag']=="emo_clientes"):
	require_once 'customers/customers.list.php';
endif;
?>
