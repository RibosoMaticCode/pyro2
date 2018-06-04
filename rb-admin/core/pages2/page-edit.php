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
<script src="<?= G_SERVER ?>/rb-admin/core/pages2/func.js"></script>
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
		</span>
	</div>
</div>
<div class="content-edit"> <!-- antes container-page-edit -->
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
			<!--<?php $array_content = json_decode($row['contenido'], true);
			echo "<pre>";
			print_r($array_content);
			echo "</pre>"; ?> -->
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
					//print_r($array_content);
					//die($row['contenido']);
					foreach ($array_content['boxes'] as $box) {
						?>
						<li id="<?= $box['box_id'] ?>" class="item" data-id="<?= $box['box_id'] ?>" data-type="box" data-inheight="<?= $box['boxin_height'] ?>" data-inwidth="<?= $box['boxin_width'] ?>"
							data-inbgimage="<?= $box['boxin_bgimage'] ?>" data-inbgcolor="<?= $box['boxin_bgcolor'] ?>" data-inpaddingtop="<?= $box['boxin_paddingtop'] ?>" data-inpaddingright="<?= $box['boxin_paddingright'] ?>" data-inpaddingbottom="<?= $box['boxin_paddingbottom'] ?>" data-inpaddingleft="<?= $box['boxin_paddingleft'] ?>" data-inclass="<?= $box['boxin_class'] ?>"
							data-extbgimage="<?= $box['boxext_bgimage'] ?>" data-extbgcolor="<?= $box['boxext_bgcolor'] ?>" data-extpaddingtop="<?= $box['boxext_paddingtop'] ?>" data-extpaddingright="<?= $box['boxext_paddingright'] ?>" data-extpaddingbottom="<?= $box['boxext_paddingbottom'] ?>"
							data-extpaddingleft="<?= $box['boxext_paddingleft'] ?>" data-extclass="<?= $box['boxext_class'] ?>" data-extparallax="<?= isset($box['boxext_parallax']) ? $box['boxext_parallax'] : 0 ?>">
						  <div class="box-header">
						    <strong>Bloque</strong>
								<a href="#" class="showEditBox">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<a href="#" class="addNewCol">
						      <i class="fa fa-columns fa-lg" aria-hidden="true"></i> Añadir columna
						    </a>
						    <a class="toggle" href="#">
						      <span class="arrow-up">&#9650;</span>
						      <span class="arrow-down">&#9660;</span>
						    </a>
						    <a class="boxdelete" href="#" title="Eliminar">
									<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
								</a>
						  </div>
						  <div class="box-body">
						    <ul class="cols-html">
									<?php
								  $array_cols =$box['columns'];
								  foreach ($array_cols as $col) {
										if(isset($col['col_save_id']) && $col['col_save_id']!="0"){
											$block_id = $col['col_save_id'];
											include 'col-custom.php'; //
										}else{
										?>
										<li id="<?= $col['col_id'] ?>" class="col" data-id="<?= $col['col_id'] ?>" data-type="<?= $col['col_type'] ?>" data-values='<?= json_encode ($col['col_values']) ?>' data-class="<?= $col['col_css'] ?>">
										<?php
								    switch ($col['col_type']) {
								      case 'html':
											?>
											<span class="col-head">
												<strong>HTML - Editor: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
												<a class="close-column" href="#">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit box-edit-html" id="box-edit<?= $col['col_id'] ?>"><?= html_entity_decode($col['col_content']) ?></div>
												<div class="box-edit-tool"><a href="#" class="showEditHtml">Editar</a></div>
												<input type="hidden" class="css_class" id="class_<?= $col['col_id'] ?>" value="<?= $col['col_css'] ?>" />
											</div>
											<?php
												break;
											case 'htmlraw':
											?>
											<span class="col-head">
												<strong>HTML - Código: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
												<a class="close-column" href="#">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit box-edit-html" id="box-edit<?= $col['col_id'] ?>"><?= html_entity_decode($col['col_content']) ?></div>
												<div class="box-edit-tool"><a href="#" class="showEditHtmlRaw">Editar</a></div>
												<input type="hidden" class="css_class" id="class_<?= $col['col_id'] ?>" value="<?= $col['col_css'] ?>" />
											</div>
											<?php
								        break;
								      case 'slide':
											?>
											<span class="col-head">
												<strong>Slide: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
												<a class="close-column" href="#" title="Eliminar">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit">
													<div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>">
														<p style="text-align:center;max-width:100%"><img src="core/pages2/img/slider.png" alt="post" /></p>
													</div>
													<div class="box-edit-tool"><a href="#" class="showEditSlide">Editar</a></div>
												</div>
											</div>
											<?php
								        break;
								      case 'galleries':
											?>
											<span class="col-head">
												<strong>Galerias: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
												<a class="close-column" href="#" title="Eliminar">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit">
													<div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>">
														<p style="text-align:center;max-width:100%"><img src="core/pages2/img/slider.png" alt="post" /></p>
													</div>
													<div class="box-edit-tool"><a href="#" class="showEditGalleries">Editar</a></div>
												</div>
											</div>
											<?php
								        break;
											case 'youtube1':
											?>
											<span class="col-head">
												<strong>Youtube Videos: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
												<a class="close-column" href="#" title="Eliminar">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit">
													<div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>">
														<p style="text-align:center;max-width:100%"><img src="core/pages2/img/slider.png" alt="post" /></p>
													</div>
													<div class="box-edit-tool"><a href="#" class="showEditYoutube1">Editar</a></div>
												</div>
											</div>
											<?php
												break;
											case 'post1':
											?>
											<span class="col-head">
												<strong>Publicaciones: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
												<a class="close-column" href="#" title="Eliminar">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit">
													<div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>">
														<p style="text-align:center;max-width:100%"><img src="core/pages2/img/post1.png" alt="post" /></p>
													</div>
													<div class="box-edit-tool"><a href="#" class="showEditPost1">Editar</a></div>
												</div>
											</div>
											<?php
												break;
								    }
										?>
										</li>
										<?php
										}
								  }?>
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
<div id="sidebar">
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
include_once 'modal-html-config.php';
include_once 'modal-html-raw-config.php';
include_once 'modal-post1-config.php';
include_once 'modal-slide-config.php';
include_once 'modal-galleries-config.php';
include_once 'modal-youtube1-config.php';
include_once 'modal-css-edit.php';
include_once 'modal-save-block.php';
?>
