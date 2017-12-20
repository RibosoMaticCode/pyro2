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
										<li class="col" data-id="<?= $col['col_id'] ?>" data-type="<?= $col['col_type'] ?>">
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
<!-- MODAL WINDOWS BOX EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-box" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración del bloque</strong>
	</div>
	<div class="editor-body">
		<h3>Bloque Externo</h3>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Imagen de fondo (url completa)  [ <input type="checkbox" name="boxext_parallax" id="boxext_parallax" />  ¿Parallax? ]</span>
					<input type="text" name="boxext_bgimage" id="boxext_bgimage" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Color de fondo (codigo hex, o rgb)</span>
					<input type="text" name="boxext_bgcolor" id="boxext_bgcolor" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-3-md spacing-right">
				<label>
					<span>Espacido Interno (Arriba)</span>
					<input type="text" name="boxext_paddingtop" id="boxext_paddingtop" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Abajo)</span>
					<input type="text" name="boxext_paddingbottom" id="boxext_paddingbottom" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Izquierda)</span>
					<input type="text" name="boxext_paddingleft" id="boxext_paddingleft" />
				</label>
			</div>
			<div class="cols-3-md spacing-left">
				<label>
					<span>Espacido Interno (Derecha)</span>
					<input type="text" name="boxext_paddingright" id="boxext_paddingright" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="boxext_class" id="boxext_class" />
				</label>
			</div>
		</div>
		<h3>Bloque Interno</h3>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Ancho completo (Yes, ó pixeles, ej. 900px)</span>
					<input type="text" name="boxin_width" id="boxin_width" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Imagen de fondo (url completa)</span>
					<input type="text" name="boxin_bgimage" id="boxin_bgimage" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Color de fondo (codigo hex, o rgb)</span>
					<input type="text" name="boxin_bgcolor" id="boxin_bgcolor" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
				<label>
					<span>Alto del bloque (en pixeles, ej: 400px)</span>
					<input type="text" name="boxin_height" id="boxin_height" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-3-md spacing-right">
				<label>
					<span>Espacido Interno (Arriba)</span>
					<input type="text" name="eb_bgcolor" id="boxin_paddingtop" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Abajo)</span>
					<input type="text" name="boxin_paddingbottom" id="boxin_paddingbottom" />
				</label>
			</div>
			<div class="cols-3-md spacing-left spacing-right">
				<label>
					<span>Espacido Interno (Izquierda)</span>
					<input type="text" name="boxin_paddingleft" id="boxin_paddingleft" />
				</label>
			</div>
			<div class="cols-3-md spacing-left">
				<label>
					<span>Espacido Interno (Derecha)</span>
					<input type="text" name="boxin_paddingright" id="boxin_paddingright" />
				</label>
			</div>
		</div>
		<div class="cols-container">
			<div class="cols-6-md spacing-right">
				<label>
					<span>Clase CSS</span>
					<input type="text" name="boxin_class" id="boxin_class" />
				</label>
			</div>
		</div>
		<input type="hidden" id="eb_id" value="" />
		<button class="btn-primary" id="boxform-btn-accept">Cambiar</button>
		<button class="button" id="boxform-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Aceptando cambios
	$('#boxform-btn-accept').click(function() {
		var box_id = $('#eb_id').val();
		//Internos
		$('#'+ box_id).attr('data-inheight', $('#boxin_height').val());
		$('#'+ box_id).attr('data-inwidth', $('#boxin_width').val());
		$('#'+ box_id).attr('data-inbgimage', $('#boxin_bgimage').val());
		$('#'+ box_id).attr('data-inbgcolor', $('#boxin_bgcolor').val());
		$('#'+ box_id).attr('data-inpaddingtop', $('#boxin_paddingtop').val());
		$('#'+ box_id).attr('data-inpaddingright', $('#boxin_paddingright').val());
		$('#'+ box_id).attr('data-inpaddingbottom', $('#boxin_paddingbottom').val());
		$('#'+ box_id).attr('data-inpaddingleft', $('#boxin_paddingleft').val());
		$('#'+ box_id).attr('data-inclass', $('#boxin_class').val());
		//Externos
		//$('#'+ box_id).attr('data-extheight', $('#boxext_height').val());
		//$('#'+ box_id).attr('data-extwidth', $('#boxext_width').val());
		$('#'+ box_id).attr('data-extbgimage', $('#boxext_bgimage').val());
		$('#'+ box_id).attr('data-extbgcolor', $('#boxext_bgcolor').val());
		$('#'+ box_id).attr('data-extpaddingtop', $('#boxext_paddingtop').val());
		$('#'+ box_id).attr('data-extpaddingright', $('#boxext_paddingright').val());
		$('#'+ box_id).attr('data-extpaddingbottom', $('#boxext_paddingbottom').val());
		$('#'+ box_id).attr('data-extpaddingleft', $('#boxext_paddingleft').val());
		$('#'+ box_id).attr('data-extclass', $('#boxext_class').val());
		if ($('#boxext_parallax').is(':checked')) {
			$('#'+ box_id).attr('data-extparallax', 1);
		}else{
			$('#'+ box_id).attr('data-extparallax', 0);
		}
		$('.bg-opacity, #editor-box').hide();
	});
	// Cancelando cambios
	$('#boxform-btn-cancel').click(function() {
		$('.bg-opacity, #editor-box').hide();
	});
});
</script>
<!-- MODAL WINDOWS HTML EDITOR AND CONFIGURATION -->
<!-- ========================================== -->
<div id="editor-html" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del contenido</strong>
	</div>
	<div class="editor-body">
		<script type="text/javascript" src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
			<div class="cols-container">
				<div class="cols-6-md spacing-right">
					<label>Class CSS
						<input type="text" name="class_css" id="class_css" />
					</label>
				</div>
				<div class="cols-6-md spacing-left">
					<!--<label>ID CSS
						<input type="text" name="id_css" id="id_css" />
					</label>-->
				</div>
			</div>
			<div id="ta">
			  <p>Editor de html</p>
			</div>
			<button class="btn-primary" id="btn1">Cambiar</button>
			<button class="button" id="btn2">Cancelar</button>
			<!-- nombres de los controles -->
			<input type="hidden" id="control_id" value="" />
			<input type="hidden" id="css_box_id" value="" />
	</div>
	<script>
	$(function() {
		tinymce.init({
			selector: '#ta',
			entity_encoding : "raw",
			menubar: false,
			convert_urls : false,
			language_url : '<?= G_SERVER ?>/rb-admin/tinymce/langs/es_MX.js',
			height: 300,
			//forced_root_block : false,
			plugins: [
				'advlist autolink lists link image charmap print preview anchor textcolor',
    		'searchreplace visualblocks code fullscreen table',
    		'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'insert | table |  formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code',
			content_css: '//www.tinymce.com/css/codepen.min.css',
			file_browser_callback   : function(field_name, url, type, win) {
				if (type == 'file') {
					var cmsURL       = 'gallery.explorer.tinymce.php?type=file';
				} else if (type == 'image') {
					var cmsURL       = 'gallery.explorer.tinymce.php?type=image';
				}

				tinymce.activeEditor.windowManager.open({
					file            : cmsURL,
					title           : 'Selecciona una imagen',
					width           : 860,
					height          : 600,
					resizable       : "yes",
					inline          : "yes",
					close_previous  : "yes"
				}, {
					window  : win,
					input   : field_name
				});
			}
		});

	  $('#btn1').click(function() {
			// Enviando los valores
			// - Contenido
			var control_id = $('#control_id').val();
			$('#'+control_id).html(tinymce.activeEditor.getContent());
			// - Nombre de la clase
			var css_box_id = $('#css_box_id').val();
			$('#'+css_box_id).val($('#class_css').val());

			$('.bg-opacity, #editor-html').hide();
	  });
		$('#btn2').click(function() {
			$('.bg-opacity, #editor-html').hide();
	  });
	});
	</script>
</div>
