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
?>
<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
<script src="<?= G_SERVER ?>/rb-admin/core/pages2/func.js"></script>
<div id="toolbar">
	<div id="toolbar-buttons">
		<span class="post-submit">
			<input class="submit" name="guardar" type="submit" value="Guardar" id="btnGuardar" />
			<!--<input class="submit" name="guardar_volver" type="submit" value="Guardar y volver" id="btnGuardarBack"/>-->
			<a href="<?= G_SERVER ?>/rb-admin/?pag=pages"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver" /></a>
		</span>
	</div>
</div>
<div class="container-page-edit">
	<section class="seccion">
		<div class="seccion-body">
			<div class="wrap-input">
				<label>Titulo de la página</label>
				<input required placeholder="Escribe el titulo de la página aquí" class="ancho" name="titulo" type="text" id="titulo" required value="<?php if(isset($row)) echo $row['titulo'] ?>" />
				<input type="hidden" name="pagina_id" id="pagina_id" value="<?php if(isset($row)) echo $row['id']; else echo "0" ?>" />
				<input type="hidden" name="mode" id="mode" value="<?= $mode ?>" />
			</div>
			<label style="display:none">Menu asociado a la pagina
				<span class="info">
					Por defecto se establece como menu principal el establecido en las opciones generales. Sin embargo si desea especificar para esta pagina un menu diferente puede cambiarlo desde aqui. Por Ej. para una web que maneje contenido en diferentes idiomas.
				</span>
				<select id="menu" name="menu">
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
						    <ul class="box-options">
						      <li>
						        <a href="#">
											<i class="fa fa-columns fa-lg" aria-hidden="true"></i> Añadir columna
										</a>
						        <ul class="box-options-list">
						          <li>
						            <a class="addSlide" href="#">Slide</a>
						          </li>
						          <li>
						            <a class="addHtml" href="#">HTML</a>
						          </li>
											<li>
						            <a class="addHtml" href="#">Publicaciones (horizontal)</a>
						          </li>
						        </ul>
						      </li>
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
										?>
										<li id="<?= $col['col_id'] ?>" class="col" data-id="<?= $col['col_id'] ?>" data-type="<?= $col['col_type'] ?>" data-values='<?= json_encode ($col['col_values']) ?>' data-class="<?= $col['col_css'] ?>">
										<?php
								    switch ($col['col_type']) {
								      case 'html':
											?>
											<span class="col-head">
												<strong>HTML</strong>
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
								      case 'slide':
											?>
											<span class="col-head">
												<strong>Slide</strong>
												<a class="close-column" href="#" title="Eliminar">
													<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
												</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit">
													<label>
													  <span>Seleccionar galería</span>
													  <select class="slide_name" name="slides">
													    <option value="0">Seleccionar</option>
													    <?php
															$q = $objDataBase->Ejecutar("SELECT * FROM albums");
													    while($r = $q->fetch_assoc()):
													    ?>
													    <option <?php if($col['col_content']==$r['id']) echo " selected" ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
													    <?php
													    endwhile;
													    ?>
													  </select>
													</label>
													<label> Class CSS:
														<input type="text" id="class_<?= $col['col_id'] ?>" value="<?= $col['col_css'] ?>" />
													</label>
												</div>
											</div>
											<?php
								        break;
											case 'post1':
											?>
											<span class="col-head">
												<strong>Publicaciones</strong>
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
<?php
include_once 'modal-box-config.php';
include_once 'modal-html-config.php';
include_once 'modal-post1-config.php';
?>
