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
			<a href="../rb-admin/?pag=pages"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver" /></a>
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
			<label>Estructura</label>
			<div class="estructure">
				<ul id="boxes">
				<?php if(isset($row)): ?>
					<?php
					//echo $row['contenido']."<br />";

					$array_content = json_decode($row['contenido'], true);
					//print_r($array_content);
					foreach ($array_content['boxes'] as $box) {
						?>
						<!--<script>
						$(document).ready(function() {
						  $( ".cols-html" ).sortable({
						      placeholder: "placeholder",
						      handle: ".col-head"
						  });
						});
						</script>-->
						<?php
						/*if(!isset($_GET['temp_id'])) $temp_id = 1;
						else $temp_id = $_GET['temp_id'];*/
						?>
						<li class="item" data-id="<?= $box['box_id'] ?>" data-type="box">
						  <div class="box-header">
						    <strong>Bloque</strong>
						    <ul class="box-options">
						      <li>
						        <a href="#">Añadir columna</a>
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
						    <a class="boxdelete" href="#">X</a>
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
												<strong>HTML</strong><a class="close-column" href="#">X</a>
											</span>
											<div class="col-box-edit">
												<div class="box-edit">
													<label>
														<div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>"><?= html_entity_decode($col['col_content']) ?></div>
													</label>
													<label> Class CSS:
														<input type="text" id="class_<?= $col['col_id'] ?>" value="<?= $col['col_css'] ?>" />
													</label>
												</div>
												<a href="#" class="showEditHtml">Editar</a>
											</div>
											<?php
								        break;
								      case 'slide':
											?>
											<span class="col-head">
												<strong>Slide</strong><a class="close-column" href="#">X</a>
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
				<a id="boxNew" href="#">Añadir nuevo bloque</a>
			</div>
		</div>
	</section>
</div>
<!-- editor -->
<div class="editor-html" style="padding-bottom:100px">
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.4.1/tinymce.min.js"></script>
	<div id="ta">
	  <p>Editor de html</p>
	</div>
	<button id="btn1">Get content with tinymce</button>
	<input type="hidden" id="control_id" value="" />
	<script>
	$(function() {
		tinymce.init({
			selector: '#ta',
			entity_encoding : "raw",
			convert_urls : false,
			language_url : '<?= G_SERVER ?>/rb-admin/tinymce/langs/es_MX.js',
				height: 500,
				plugins: [
					'advlist autolink lists link image charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime media table contextmenu paste code'
				],
				toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
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
	        //console.log(tinymce.activeEditor.getContent());
					var control_id = $('#control_id').val();
					 $('#'+control_id).html(tinymce.activeEditor.getContent());
	    });
	});
	</script>
</div>
