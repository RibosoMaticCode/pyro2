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
					echo "</pre>";
					die();*/
					//die($row['contenido']);
					foreach ($array_content['boxes'] as $box) {
						?>
						<li id="<?= $box['box_id'] ?>" class="box" data-id="<?= $box['box_id'] ?>" data-type="box"
							data-extclass="<?= $box['boxext_class'] ?>" data-extvalues='<?= json_encode ($box['boxext_values']) ?>'
							data-inclass="<?= $box['boxin_class'] ?>" data-invalues='<?= json_encode ($box['boxin_values']) ?>'>
						  <div class="box-header">
						    <strong>Bloque</strong>
								<a href="#" class="showEditBox">
									<i class="fa fa-pencil" aria-hidden="true"></i> Personalizar
								</a>
								<a href="#" class="addNewCol">
						      <i class="fa fa-columns fa-lg" aria-hidden="true"></i> Añadir columna
						    </a>
								<a href="#" class="SaveBox">
						      <i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar
						    </a>
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

<div id="sidebar" style="display:none;">
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
	<!-- EDITAR ESTILOS ADICIONALES -->
	<section class="seccion">
		<div class="seccion-header">
			<h3>CSS adicionales</h3>
			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
		</div>
		<div class="seccion-body">
			<a href="#"id="editCSSFile">Editar CSS adicionales</a>
		</div>
	</section>
	<!-- EDITAR header - footer -->
	<section class="seccion">
		<div class="seccion-header">
			<h3>Cabecera y pie de página</h3>
			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
		</div>
		<div class="seccion-body">
			<label>
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
			</label>
		</div>
	</section>
</div>

<?php
include_once 'modal-box-config.php';
include_once 'widgets/slide/w.slide.conf.php';
include_once 'widgets/code/w.code.conf.php';
include_once 'widgets/editor/w.editor.conf.php';
include_once 'widgets/gallery/w.gallery.conf.php';
include_once 'widgets/youtube/w.youtube.conf.php';
include_once 'widgets/pubs/w.pubs.conf.php';
include_once 'modal-css-edit.php';
include_once 'modal-save-block.php';
?>
