<div class="inside_contenedor_frm">
<?php
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$qp = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE id=".$id);
	$Page= $qp->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
$shead = isset($Page) ? $Page['show_header'] : 0;
$sfoot = isset($Page) ? $Page['show_footer'] : 0;
$hcustid = isset($Page) ? $Page['header_custom_id'] : 0;
$fcustid = isset($Page) ? $Page['footer_custom_id'] : 0;
?>
<script src="<?= G_SERVER ?>rb-admin/resource/ui/jquery-ui.js"></script>
<script src="<?= G_SERVER ?>rb-admin/core/pages3/func.js"></script>
<div id="toolbar">
	<div class="inside_toolbar">
		<div class="navigation">
			<a href="<?= G_SERVER ?>rb-admin/?pag=pages">Páginas</a> <i class="fas fa-angle-right"></i>
			<?php if(isset($Page)): ?>
				<span><?= $Page['titulo'] ?></span>
			<?php else: ?>
				<span>Nueva página</span>
			<?php endif ?>
		</div>
			<input class="btn-primary" name="guardar" type="submit" value="Guardar" id="btnGuardar" />
			<a class="button" href="<?= G_SERVER ?>rb-admin/?pag=pages">Cancelar</a>
			<?php
			if(isset($_GET["id"])){
			?>
			<a title="Presionar Control para cargar en una pestaña aparte" class="button" href="<?= G_SERVER ?>?p=<?= $Page['id'] ?>" target="_blank">Vista previa</a>
			<?php
			}
			?>
			<a class="button" href="#" id="editCSSFile">Editar CSS</a>
			<a class="button" href="#" id="showConfigPage">Configuración</a>
			<a class="button" href="#" id="showFilesUpload"><i class="fa fa-upload"></i> Subir archivos</a>
	</div>
</div>
	<section class="seccion" style="overflow:initial">
		<div class="seccion-header">
			<h3>Datos iniciales</h3>
			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
		</div>
		<div class="seccion-body">
			<div class="form">
				<label>Titulo de la página</label>
				<input placeholder="Escribe el titulo de la página aquí" class="ancho" name="titulo" type="text" id="titulo" required value="<?php if(isset($Page)) echo $Page['titulo'] ?>" />
				<input type="hidden" name="pagina_id" id="pagina_id" value="<?php if(isset($Page)) echo $Page['id']; else echo "0" ?>" />
				<input type="hidden" name="mode" id="mode" value="<?= $mode ?>" />
			</div>
			<p style="text-align:right"><a href="#" id="link-data-config">Mas opciones</a></p>
		</div>
	</section>
	<section class="seccion" >
		<div class="seccion-header">
			<h3>Estructura</h3>
			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
		</div>
		<div class="seccion-body">
			<!--<label class="editor-main-title"><i class="fa fa-th fa-lg" aria-hidden="true"></i> Estructura</label>-->
			<div class="estructure">
				<script>
				/*$(document).ready(function() {
				  $( ".cols-html" ).sortable({
				      placeholder: "placeholder",
				      handle: ".col-head"
				  });
				});*/
				</script>
				<ul id="boxes">
				<?php if(isset($Page)): ?>
					<?php
					$array_content = json_decode($Page['contenido'], true);
					foreach ($array_content['boxes'] as $boxes => $box) {
						if(isset($box['box_save_id'])){
					    $box_save_id = $box['box_save_id'];
					  }else{
					    $box_save_id = 0;
					  }
					  if($box_save_id > 0){
							$qb = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages_blocks WHERE id=".$box_save_id);
							$boxsave = $qb->fetch_assoc();
							$box = json_decode($boxsave['contenido'], true);
							$box_saved_css = " saved";
							$box_save_title = '<span class="box-save-title">'.$boxsave['nombre'].'</span>';
						}else{
							$box_save_id = 0;
							$box_saved_css = "";
							$box_save_title = '<a href="#" class="SaveBox"><i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar</a><span class="box-save-title"></span>';
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
										      <i class="fa fa-cube fa-lg" aria-hidden="true"></i> Añadir componente
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
												    	/*switch ($widget['widget_type']) {
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
																case 'sidebar':
																	include 'widgets/sidebar/w.sidebar.php';
																	break;
												    	}*/
															//print_r($widgets);
															// $widgets = array global que contiene widgets del sistema y personalizados
															$widget_type = $widget['widget_type'];

															// Recorreremos para ver si hay coincidencias
															// forma 1:
															foreach ($widgets as $widget_save => $info) {
																if($widget_type == $info['type']){
																	if( isset($info['custom']) ){
																		$dir_module = ABSPATH.'rb-script/modules/';
																		include $dir_module.$info['dir'].'/'.$info['file'];
																	}else{
																		include 'widgets/'.$info['dir'].'/'.$info['file'];
																	}
																}
															}
															// forma 2: se encuentra en el archivo funciones.php -> f: rb_show_block
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
					<a id="boxNew" href="#" title="Añadir bloque"><img src="<?= G_SERVER ?>rb-admin/img/more.png" alt="icon" /></a>
				</div>
			</div>
		</div>
	</section>

<!-- DATOS PAGINAS MAS -->
<div id="data-config" class="editor-window">
	<div class="editor-header">
		<strong>Otros datos</strong>
	</div>
	<div class="editor-body">
		<div class="form">
		<label>Url de la pagina
			<span class="info">Url amigable (generado automaticamente, si se deja en blanco)</span>
			<span style="background:#fffcdf;padding:5px;border: 1px solid #FFEB3B;">
				<?= G_SERVER ?><input type="text" style="display:inline-block;width:auto;padding:0;background:none;border:0;border-bottom:1px solid gray;" name="pagina_enlace" id="pagina_enlace" value="<?php if(isset($Page)) echo $Page['titulo_enlace']; else echo "" ?>"  size="<?php if(isset($Page)) echo strlen($Page['titulo_enlace']); else echo "" ?>" />/</span>
		</label>
		<label>Descripción<br />
			<textarea rows="2" name="description" id="pagina_desc"><?php if(isset($Page)) echo $Page['description']; else echo "" ?></textarea>
		</label>
		<label>Tags<br />
			<input type="text" name="tags" id="pagina_tags" value="<?php if(isset($Page)) echo $Page['tags']; else echo "" ?>" />
		</label>
		<label>Tipo de página</label>
		<div class="cols-container">
			<div class="cols-3-md">
				<label>
					<input type="radio" value="0" name="type" <?php if( isset($Page) && $Page['type']==0) echo "checked" ?> /> Normal
				</label>
			</div>
			<div class="cols-3-md">
				<label>
					<input type="radio" value="1" name="type" <?php if( isset($Page) && $Page['type']==1) echo "checked" ?> /> Cabecera
				</label>
			</div>
			<div class="cols-3-md">
				<label>
					<input type="radio" value="2" name="type" <?php if( isset($Page) && $Page['type']==2) echo "checked" ?> /> Pie de página
				</label>
			</div>
			<div class="cols-3-md">
				<label>
					<input type="radio" value="3" name="type" <?php if( isset($Page) && $Page['type']==3) echo "checked" ?> /> Barra lateral
				</label>
			</div>
		</div>
		</div>
	</div>
	<div class="editor-footer">
		<button class="button" id="data-config-btn-cancel">Cerrar</button>
	</div>
</div>
<!-- start config page -->
<div id="filesupload-config" class="editor-window">
	<div class="editor-header">
		<strong>Subir archivos</strong>
	</div>
	<div class="editor-body">
		<?php
		include_once ABSPATH.'rb-admin/plugin-form-uploader.php';
		?>
	</div>
	<div class="editor-footer">
		<button class="button" id="filesupload-config-btn-cancel">Cerrar</button>
	</div>
</div>
<!-- start config page -->
<div id="page-config" class="editor-window">
	<div class="editor-header">
		<strong>Más configuraciones</strong>
	</div>
	<div class="editor-body form">
		<div class="seccion-body cols-container">
			<div class="cols-6-md">
				<h4>Cabecera</h4>
				<label>
					<input type="radio" name="sheader" value="0" <?php if($shead==0) echo "checked" ?>> <span>Ninguna</span>
				</label>
				<label>
					<input type="radio" name="sheader" value="1" <?php if($shead==1) echo "checked" ?>> <span>Incluir de la plantilla</span>
				</label>
				<label>
					<input type="radio" name="sheader" value="2" <?php if($shead==2) echo "checked" ?>> <span>Personalizada</span>
					<!--<input name="sheader_custom_id" type="text" value="<?= $hcustid  ?>" />-->
					<?php
					if(isset($Page)){
						$id = $Page['id'];
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=1 AND id<>".$id);
					}else{
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=1");
					}
					?>
					<select name="sheader_custom_id">
						<option value="0">Ninguno</option>
						<?php while($header = $q->fetch_assoc()): ?>
						<option value="<?= $header['id'] ?>" <?php if($header['id']==$hcustid) echo "selected" ?>><?= $header['titulo'] ?></option>
						<?php endwhile ?>
					</select>
				</label>
			</div>
			<div class="cols-6-md">
				<h4>Pie de Pagina</h4>
				<label>
					<input type="radio" name="sfooter" value="0" <?php if($sfoot==0) echo "checked" ?>> <span>Ninguna</span>
				</label>
				<label>
					<input type="radio" name="sfooter" value="1" <?php if($sfoot==1) echo "checked" ?>> <span>Incluir de la plantilla</span>
				</label>
				<label>
					<input type="radio" name="sfooter" value="2" <?php if($sfoot==2) echo "checked" ?>> <span>Personalizada</span>
					<!--<input name="sfooter_custom_id" type="text" value="<?= $fcustid  ?>" />-->
					<?php
					if(isset($Page)){
						$id = $Page['id'];
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=2 AND id<>".$id);
					}else{
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=2");
					}
					?>
					<select name="sfooter_custom_id">
						<option value="0">Ninguno</option>
						<?php while($footer = $q->fetch_assoc()): ?>
						<option value="<?= $footer['id'] ?>" <?php if($footer['id']==$fcustid) echo "selected" ?>><?= $footer['titulo'] ?></option>
						<?php endwhile ?>
					</select>
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="eb_id" value="" />
		<button class="button" id="page-config-btn-cancel">Cerrar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar el config filesupload
	$('#showFilesUpload').click(function(event) {
		event.preventDefault()
		$('.bg-opacity, #filesupload-config').show();
	});
	// Cerrar el config data
	$('#filesupload-config-btn-cancel').click(function(event) {
		event.preventDefault()
		$('.bg-opacity, #filesupload-config').hide();
	});

	// Mostrar el config data
	$('#link-data-config').click(function(event) {
		event.preventDefault()
		$('.bg-opacity, #data-config').show();
	});
	// Cerrar el config data
	$('#data-config-btn-cancel').click(function(event) {
		event.preventDefault()
		$('.bg-opacity, #data-config').hide();
	});

	// Mostrar el config page
	$('#showConfigPage').click(function(event) {
		event.preventDefault()
		$('.bg-opacity, #page-config').show();
	});
	// Cerrar el config page
	$('#page-config-btn-cancel').click(function(event) {
		event.preventDefault()
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
include_once 'widgets/image/w.image.conf.php';
include_once 'widgets/sidebar/w.sidebar.conf.php';
include_once 'modal-css-edit.php';
include_once 'modal-save-block.php';//widget
include_once 'modal-save-box.php';
do_action('modals-config');
?>
</div>
