<h2 class="title">Editor Visual de Páginas (v.0.2)</h2>
<?php
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$cons_art = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id=$id");
	$row= $cons_art->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
$show_header = isset($row) ? $row['show_header'] : 0;
$show_footer = isset($row) ? $row['show_footer'] : 0;
?>
<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
<script src="<?= G_SERVER ?>/rb-admin/core/pages3/func.js"></script>
<div id="toolbar">
	<div id="toolbar-buttons">
		<span class="post-submit">
			<input class="submit" name="guardar" type="submit" value="Guardar" id="btnGuardar" />
			<a class="button" href="<?= G_SERVER ?>/rb-admin/?pag=pages">Volver</a>
			<?php
			if(isset($_GET["id"])){
			?>
			<a class="fancybox fancybox.iframe button" href="<?= G_SERVER ?>/?p=<?= $row['id'] ?>" target="_blank">Vista previa</a>
			<?php
			}
			?>
			<a class="button" href="#"id="editCSSFile">Editar CSS adicionales</a>
			<a class="button" href="#"id="showConfigPage">Mas configuraciones</a>
		</span>
	</div>
</div>
<div class="wrap-content-editor"> <!-- antes container-page-edit -->
	<section class="seccion" style="overflow:initial">
		<div class="seccion-body">
			<div class="wrap-input">
				<label>Titulo de la página</label>
				<input placeholder="Escribe el titulo de la página aquí" class="ancho" name="titulo" type="text" id="titulo" required value="<?php if(isset($row)) echo $row['titulo'] ?>" />
				<input type="hidden" name="pagina_id" id="pagina_id" value="<?php if(isset($row)) echo $row['id']; else echo "0" ?>" />
				<input type="hidden" name="mode" id="mode" value="<?= $mode ?>" />
			</div>
			<label style="display:none">Menu asociado a la pagina
				<span class="info">
					Por defecto se establece como menu principal el establecido en las opciones generales. Sin embargo si desea especificar para esta pagina un menu diferente puede cambiarlo desde aqui. Por Ej. para una web que maneje contenido en diferentes idiomas.
				</span>
				<select id="menu_page" name="menu">
					<?php
					$result = $objDataBase->Ejecutar("SELECT * FROM menus");
					$menu_id = isset($row) ? $row['menu_id'] : 0;
					?>
					<option value="0">[Ninguno]</option>
					<?php
					while($menu = $result->fetch_assoc()):
						?>
						<option <?php if($menu['id'] == $menu_id) echo " selected" ?> value="<?= $menu['id'] ?>"><?= $menu['nombre'] ?></option>
						<?php
					endwhile;
					?>
				</select>
			</label>
			<label>Url de la pagina
				<span class="info">Url amigable (generado automaticamente, si se deja en blanco)</span>
				<span style="background:#fffcdf;padding:5px;border: 1px solid #FFEB3B;">
					<?= G_SERVER ?>/<input type="text" style="display:inline-block;width:auto;padding:0;background:none;border:0;border-bottom:1px solid gray;" name="pagina_enlace" id="pagina_enlace" value="<?php if(isset($row)) echo $row['titulo_enlace']; else echo "" ?>"  size="<?php if(isset($row)) echo strlen($row['titulo_enlace']); else echo "" ?>" />/</span>
			</label>
			<label class="editor-main-title"><i class="fa fa-th fa-lg" aria-hidden="true"></i> Estructura</label>
			<div class="estructure">
				<script>
				$(document).ready(function() {
				  $( ".cols-html" ).sortable({
				      placeholder: "placeholder",
				      handle: ".col-head"
				  });
				});
				</script>
				<ul id="boxes">
				<?php if(isset($row)): ?>
					<?php
					$array_content = json_decode($row['contenido'], true);
					// Testing
					/*echo "<pre>";
					print_r($array_content);
					echo "</pre>";*/
					//die();
					foreach ($array_content['boxes'] as $boxes => $box) {
						//echo "Save ID:".$box['box_save_id'];
						if(isset($box['box_save_id'])){
					    $box_save_id = $box['box_save_id'];
					  }else{
					    $box_save_id = 0;
					  }
					  if($box_save_id > 0){
						//if($box['box_save_id']>0){
							//$box_save_id = $box['box_save_id'];
							// Consultar los datos del bloque
							$qb = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE id=$box_save_id");
							$boxsave = $qb->fetch_assoc();
							$box = json_decode($boxsave['contenido'], true);
							$box_saved_css = " saved";
							$box_save_title = '<span class="box-save-title">'.$boxsave['nombre'].'</span>';
							/*echo "<pre>";
							print_r($box);
							echo "</pre>";*/
						}else{
							$box_save_id = 0;
							$box_saved_css = "";
							$box_save_title = '<a href="#" class="SaveBox"><i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar</a><span class="box-save-title"></span>';
							/*print_r($box);*/
						}
						?>
						<li id="<?= $box['box_id'] ?>" class="box <?= $box_saved_css ?>" data-id="<?= $box['box_id'] ?>" data-type="box"
							data-extclass="<?= $box['boxext_class'] ?>" data-extvalues='<?= json_encode ($box['boxext_values']) ?>'
							data-inclass="<?= $box['boxin_class'] ?>" data-invalues='<?= json_encode ($box['boxin_values']) ?>'
							data-saved-id="<?= $box_save_id ?>">
						  <div class="box-header">
						    <strong>Bloque</strong>
								<a href="#" class="showEditBox">
									<i class="fa fa-pencil" aria-hidden="true"></i> Personalizar
								</a>
								<a href="#" class="addNewCol">
						      <i class="fa fa-columns fa-lg" aria-hidden="true"></i> Añadir columna
						    </a>
								<?= $box_save_title ?>
								<!--<a href="#" class="SaveBox">
						      <i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar
						    </a>
								<span class="box-save-title"></span>-->
						    <!--<a class="toggle" href="#">
						      <span class="arrow-up">&#9650;</span>
						      <span class="arrow-down">&#9660;</span>
						    </a>-->
						    <a class="boxdelete" href="#" title="Eliminar">
									<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
								</a>
						  </div>
						  <div class="box-body">
						    <ul class="cols">
									<?php
									/* start columnas */
								  $array_cols =$box['columns'];

									foreach ($array_cols as $col) {
										?>
										<li id="<?= $col['col_id'] ?>" class="col" data-id="<?= $col['col_id'] ?>" data-type="col" data-class="<?= $col['col_class'] ?>" data-values='<?= json_encode ($col['col_values']) ?>'>
										  <div class="col-header">
										    <strong>Columna</strong>
										    <a href="#" class="showEditCol">
										      <i class="fa fa-pencil" aria-hidden="true"></i> Personalizar
										    </a>
										    <a href="#" class="addNewWidget">
										      <i class="fa fa-cube fa-lg" aria-hidden="true"></i> Añadir widget
										    </a>
										    <a class="boxdelete" href="#" title="Eliminar">
										      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
										    </a>
										  </div>
										  <div class="col-body">
										    <ul class="widgets">
													<?php
													/* start widgets */
												  $array_widgets =$col['widgets'];
												  foreach ($array_widgets as $widget) {
														if(isset($widget['widget_save_id']) && $widget['widget_save_id']!="0"){
															$block_id = $widget['widget_save_id'];
															include 'widget-custom.php';
														}else{
												    	switch ($widget['widget_type']) {
													      case 'html':
																	include 'widgets/editor/w.editor.php';
																	break;
																case 'htmlraw':
																	include 'widgets/code/w.code.php';
																	break;
													      case 'slide':
																	include 'widgets/slide/w.slide.php';
													        break;
													      case 'galleries':
																	include 'widgets/gallery/w.gallery.php';
																	break;
																case 'youtube1':
																	include 'widgets/youtube/w.youtube.php';
																	break;
																case 'post1':
																	include 'widgets/pubs/w.pubs.php';
																	break;
												    	}
														}
														unset($data_saved_id);
												  }
													/* end widgets */
													?>
										    </ul>
										  </div>
										</li>
										<?php
									}
									?>
						    </ul>
						  </div>
						</li>
						<?php
					}
					?>
				<?php else: ?>
					<?php include_once 'page-box-new.php' ?>
				<?php endif ?>
				</ul>
				<div class="wrap-boton-new-block">
					<a id="boxNew" href="#" title="Añadir bloque"><img src="<?= G_SERVER ?>/rb-admin/img/more.png" alt="icon" /></a>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- start config page -->
<div id="page-config" class="editor-window">
	<div class="editor-header">
		<strong>Más configuraciones</strong>
	</div>
	<div class="editor-body">
		<!-- SECCION SUBIR IMAGENES -->
		<section id="post-sub" class="seccion">
			<div class="seccion-header">
				<h3>Subir imagenes</h3>
				<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
			</div>
			<div class="seccion-body">
			<?php
			include_once ABSPATH.'rb-admin/plugin-form-uploader.php';
			?>
			</div>
		</section>
		<!-- SECCION CABECERA FOOTER SHOW -->
		<section id="page-config" class="seccion">
			<div class="seccion-header">
				<h3>Cabecera y pie de página</h3>
				<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
			</div>
			<div class="seccion-body cols-container">
				<div class="cols-6-md">
					<h4>Cabecera</h4>
					<label>
						<input type="radio" name="sheader" value="0"> <span>Ninguna</span>
					</label>
					<label>
						<input type="radio" name="sheader" value="1"> <span>Incluir de la plantilla</span>
					</label>
					<label>
						<input type="radio" name="sheader" value="2"> <span>Personalizada</span>
						<select name="sheader_custom_id">
						<?php
						$qb = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE tipo=1");
				    while($boxsave = $qb->fetch_assoc()):
							?>
							<option value="<?= $boxsave['id'] ?>"><?= $boxsave['nombre'] ?></option>
							<?php
						endwhile;
						?>
						</select>
					</label>
				</div>
				<div class="cols-6-md">
					<h4>Pie de Pagina</h4>
					<label>
						<input type="radio" name="sfooter" value="0"> <span>Ninguna</span>
					</label>
					<label>
						<input type="radio" name="sfooter" value="1"> <span>Incluir de la plantilla</span>
					</label>
					<label>
						<input type="radio" name="sfooter" value="2"> <span>Personalizada</span>
						<select name="sfooter_custom_id">
						<?php
						$qb = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE tipo=2");
				    while($boxsave = $qb->fetch_assoc()):
							?>
							<option value="<?= $boxsave['id'] ?>"><?= $boxsave['nombre'] ?></option>
							<?php
						endwhile;
						?>
						</select>
					</label>
				</div>
				<!--<label>
					<?php
					$checkedh = "";
					if($show_header==1) $checkedh = " checked ";
					?>
					<input type="checkbox" value="1" name="sheader" id="sheader" <?= $checkedh ?>> <span>Incluir Cabecera de la plantilla</span>
				</label>
				<label>
					<?php
					$checkedf = "";
					if($show_footer==1) $checkedf = " checked ";
					?>
					<input type="checkbox" value="1" name="sfooter" id="sfooter" <?= $checkedf ?>> <span>Incluir Pie de página de la plantilla</span>
				</label>-->

			</div>
		</section>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="eb_id" value="" />
		<button class="button" id="page-config-btn-cancel">Cerrar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar el config page
	$('#showConfigPage').click(function(event) {
		$('.bg-opacity, #page-config').show();
	});
	// Cerrar el config page
	$('#page-config-btn-cancel').click(function(event) {
		$('.bg-opacity, #page-config').hide();
	});
});
</script>
<!-- end config page -->
<?php
include_once 'modal-box-config.php';
include_once 'modal-col-config.php';
include_once 'widgets/slide/w.slide.conf.php';
include_once 'widgets/code/w.code.conf.php';
include_once 'widgets/editor/w.editor.conf.php';
include_once 'widgets/gallery/w.gallery.conf.php';
include_once 'widgets/youtube/w.youtube.conf.php';
include_once 'widgets/pubs/w.pubs.conf.php';
include_once 'modal-css-edit.php';
include_once 'modal-save-block.php';//widget
include_once 'modal-save-box.php';
?>
