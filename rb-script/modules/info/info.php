<?php
/*
Module Name: Informes Publicadores
Plugin URI: http://yupe.pe/info
Description: Permite llevar el control de los informes de servicio del campo mensual.
Author: Jesus Liñan
Version: 1.0
Author URI: http://yupy.pe
*/

// Valores iniciales
$rb_module_title = "Informes";
$rb_module_title_section = "Informes";
$rb_module_path = "Inicio > Informes";
$rb_module_url_main = G_SERVER."/rb-admin/module.php";
$rb_module_url = G_SERVER."/rb-script/modules/info/";
$rb_module_url_img = G_SERVER."/rb-script/modules/info/img/icon-info.png";

// Ubicacion en el Menu
//rb_add_item_menu(array(
$menu = array(
					'key' => 'info',
					'nombre' => "Informes",
					'url' => "#",
					'url_imagen' => $rb_module_url_img,
					'pos' => 1,
					'show' => true,
					'item' => array(
						array(
							'key' => 'info',
							'nombre' => "Informes",
							'url' => "module.php?pag=info",
							'url_imagen' => "none",
							'pos' => 1,
							'show' => true
						),
						array(
							'key' => 'info_pub',
							'nombre' => "Publicadores",
							'url' => "module.php?pag=info_pub",
							'url_imagen' => "none",
							'pos' => 2,
							'show' => true
						),
						array(
							'key' => 'info_congre',
							'nombre' => "Congregacion",
							'url' => "module.php?pag=info_congre",
							'url_imagen' => "none",
							'pos' => 2,
							'show' => true
						)
					)
				);//);

// INFORMES
if(isset($_GET['pag']) && $_GET['pag']=="info"):
	function cotizador_css(){
		global $rb_module_url;
		$css = '<link rel="stylesheet" href="'.$rb_module_url.'info.css">';
		return $css;
	}
	function content_html(){
		$urlreload = G_SERVER."/rb-admin/module.php?pag=info";
		$rb_module_url = G_SERVER."/rb-script/modules/info/";

		if(isset($_GET['opc'])):
			switch($_GET['opc']):
				case 'summary':
					include('info.summary.php');
				break;
				case 'details':
					include('info.list.php');
				break;
				case 'final':
					include('infofinal.summary.php');
				break;
				default:
					include('info.edit.php');
			endswitch;
		else:
		?>

		<div id="sidebar-left">
			<ul class="buttons-edition">
				<li><a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
				<li><a class="btn-primary" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Editar</a></li>
				<li><a class="btn-primary" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
			</ul>
		</div>
		<div class="wrap-content-list">
			<section class="seccion">
				<table class="tables" border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
							<th>Mes</th>
							<th>Año</th>
							<th>Informes</th>
							<th>Consolidado</th>
						</tr>
					</thead>
					<tbody>
						<?php include('info.list.period.php') ?>
					</tbody>
				</table>
			</section>
		</div>
	<?php
		endif;
	}
	add_function('panel_header_css','cotizador_css');
	add_function('module_content_main','content_html');
endif;

// PUBLICADORES
if(isset($_GET['pag']) && $_GET['pag']=="info_pub"):
	$rb_module_url = G_SERVER."/rb-script/modules/info/";
	$rb_module_title = "Publicadores";
	$rb_module_title_section = "Publicadores";
	$rb_module_path = "Informes";

	function cotizador_css(){
		global $rb_module_url;
		$css = '<link rel="stylesheet" href="'.$rb_module_url.'info.css">';
		return $css;
	}
	function public_html(){
		$urlreload = G_SERVER."/rb-admin/module.php?pag=info_pub";
		$rb_module_url = G_SERVER."/rb-script/modules/info/";

		if(isset($_GET['col'])):
			$column = $_GET['col'];
			$urlreload = $urlreload."&col=".$column;
		else:
			$column = "apellidos";
		endif;

		if(isset($_GET['ord'])):
			$order = $_GET['ord'];
			$urlreload = $urlreload."&ord=".$order;
		else:
			$order = "ASC";
		endif;
		?>
		<script>
		$(document).ready(function() {
			$('#search_input').keyup(function (event){
				var term = $.trim( $(this).val() );
				console.log(term);
				if(term.length == 0){
					window.location.href = '<?= $urlreload ?>';
				}
				event.preventDefault();
				$.ajax({
					method: "get",
					url: "<?= $rb_module_url ?>pubs.result.search.php?term="+term
				})
				.done(function( data ) {
					$('#list-pubs').html(data);
				});
			});
			// ACTIVAR / DESACTIVAR
			$( "#list-pubs" ).on( "click", ".activar", function( event ){
			//$('.activar').click(function (event){
				event.preventDefault();
				var pub_id = $(this).attr("data-pub-id");
				var pub_estado = $(this).attr("data-pub-estado");

				$.ajax({
					method: "get",
					url: "<?= $rb_module_url ?>pubs.active.php?pub_id="+pub_id+"&estado="+pub_estado
				})
				.done(function( data ) {
					if(data.resultado=="ok"){
						$('#active-'+pub_id).html(data.html);
						$('#active-'+pub_id).attr('title' , data.title);
						$('#active-'+pub_id).attr('data-pub-estado' , data.estado);
						if(data.estado==0){
							$('#text-'+pub_id).removeClass('text-red');
						}else{
							$('#text-'+pub_id).addClass('text-red');
						}
					}
				});
			});
		})
		</script>
		<div class="wrap-content-list">
			<section class="seccion">
				<div class="seccion-body">
					<form>
						<label>
							Filtrar:
							<input type="text" id="search_input" name="termino" placeholder="Término a buscar" />
						</label>
					</form>
				</div>
			</section>
			<section class="seccion" id="list-pubs">
				<table class="tables" border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th><a href="#">Apellidos y Nombres</a></th>
							<th><a href="#">Edad</th>
							<th title="Tiempo de Servicio"><a href="#">T.S.</a></th>
							<th><a href="#">Sexo</a></th>
							<th><a href="#">Fec. Nac</a></th>
							<th><a href="#">Fec. Bautismo</a></th>
							<th><a href="#">Tel. Movil</a></th>
							<th><a href="#">Tel. Fijo</a></th>
							<th><a href="#">Puesto Respo.</a></th>
							<th><a href="#">Puesto Servi.</a></th>
							<th><a href="#">Estado</th>
							<th>Datos Adic.</th>
							<th>Tarjeta</th>
						</tr>
					</thead>
					<tbody>
						<?php
						require_once(ABSPATH."rb-script/class/rb-database.class.php");
						$regMostrar = G_POSTPAGE;
						if(isset($_GET['page']) && ($_GET['page']>0)):
							$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
						else:
							$RegistrosAEmpezar = 0;
						endif;
						//SELECT * FROM table1 LEFT JOIN table2 on table1.id = table2.id
						$q = $objDataBase->Consultar("SELECT *, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') as fec_nac, DATE_FORMAT(fecha_bautismo, '%d-%m-%Y') as fec_bau,
						TIMESTAMPDIFF(YEAR, fecha_bautismo, CURDATE()) AS dif_anios, TIMESTAMPDIFF(MONTH, fecha_bautismo, CURDATE()) AS dif_mes,
						TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS dif_nac_anios, TIMESTAMPDIFF(MONTH, fecha_nacimiento, CURDATE()) AS dif_nac_mes
						FROM usuarios LEFT JOIN informes_publicador ON usuarios.id = informes_publicador.user_id WHERE tipo=0 ORDER BY $column $order LIMIT $RegistrosAEmpezar, $regMostrar");
						while ($row = mysql_fetch_array($q)):
						?>
							<tr>
								<td>
									<?php
									$style_active = "";
									if($row['activo']==0) $style_active = ' class="text-red" ';
									?>
									<span id="text-<?= $row['id'] ?>" <?= $style_active ?>>
									<?= $row['apellidos'] ?>, <?= $row['nombres'] ?>
									</span>
								</td>
								<td>
									<?php if($row['fecha_nacimiento'] > 0) : ?>
									<?= $row['dif_nac_anios'] ?>.<?= $row['dif_nac_mes']-($row['dif_nac_anios']*12) ?>
									<?php endif; ?>
								</td>
								<td>
									<?php if($row['fecha_bautismo'] > 0) : ?>
									<?= $row['dif_anios'] ?>.<?= $row['dif_mes']-($row['dif_anios']*12) ?>
									<?php endif; ?>
								</td>
								<td><?php if($row['sexo']=="h"){ echo "Hombre"; }elseif($row['sexo']=="m"){ echo "Mujer"; } ?></td>
								<td><?= $row['fec_nac'] ?></td>
								<td><?= $row['fec_bau'] ?></td>
								<td><?= $row['telefono-movil'] ?></td>
								<td><?= $row['telefono-fijo'] ?></td>
								<td><?= $row['puesto_responsabilidad'] ?></td>
								<td><?= $row['puesto_servicio'] ?></td>
								<td>
									<?php if($row['activo'] == 0): ?>
									<a id="active-<?= $row['id'] ?>" data-pub-id="<?= $row['id'] ?>" data-pub-estado="1" class="activar" title="Click para Activar" href="#">Inactivo</a>
									<?php else: ?>
									<a id="active-<?= $row['id'] ?>" data-pub-id="<?= $row['id'] ?>" data-pub-estado="0" class="activar" title="Click para Desactivar" href="#">Activo</a>
									<?php endif; ?>
								</td>
								<td><a class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>pubs.frm.php?id=<?= $row['id'] ?>">Ver/Editar</a></td>
								<td><a class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>pubs.card.php?id=<?= $row['id'] ?>">Ver</a></td>
							</tr>
						<?php
						endwhile;
						?>
					</tbody>
				</table>
				<?php
				$sec = "";
				$numrows = mysql_num_rows( $objDataBase->Consultar("SELECT * FROM usuarios LEFT JOIN informes_publicador ON usuarios.id = informes_publicador.user_id WHERE tipo=0") );
				$nums_show = G_POSTPAGE;
				$nums_show_list = false;
				$func_to_use = "Consult";
				$link_section = $urlreload; //$_SERVER['REQUEST_URI']
				include('../rb-admin/paginate.php');
				?>
			</section>
		</div>
	<?php

	}
	add_function('panel_header_css','cotizador_css');
	add_function('module_content_main','public_html');

endif;

// DATOS DE LA CONGREGACIÓN
if(isset($_GET['pag']) && $_GET['pag']=="info_congre"):
	$rb_module_url = G_SERVER."/rb-script/modules/info/";
	$rb_module_title = "Datos de Congregación";
	$rb_module_title_section = "Congregación"; //pagina
	$rb_module_path = "Informes";

	function cotizador_css(){
		global $rb_module_url;
		$css = '<link rel="stylesheet" href="'.$rb_module_url.'info.css">';
		return $css;
	}

	function congregacion_initial(){
		global $rb_module_url;
		include_once 'info.congre.php';
	}

	add_function('panel_header_css','cotizador_css');
	add_function('module_content_main','congregacion_initial');
endif;
?>
