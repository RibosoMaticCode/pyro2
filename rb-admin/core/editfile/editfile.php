<?php
$dir_style = $_SERVER['DOCUMENT_ROOT'].G_DIRECTORY."/rb-themes/".G_ESTILO."/";
$path_module = G_SERVER."rb-admin/core/editfile/";
?>
<h2 class="title">Editar archivos de la plantilla</h2>
<?php if (!in_array("editpla", $array_help_close)): ?>
	<div class="help" data-name="editpla">
		<h4>Información</h4>
		<p>Puedes editar el código fuente de la plantilla diseñada. Un cambio incorrecto puede perjudicar todo el sitio web.</p>
	</div>
<?php endif ?>
<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-body">
			<div class="cols-container">
				<div class="cols-4-md">
					<ul class="file_item">
					<?php
					require('list.files.php');
					?>
					</ul>
				</div>
				<div class="cols-8-md form">
					<form id="file_form" action="<?= G_SERVER ?>rb-admin/modules/editfile/save.change.php" method="post">
						<div style="position:relative; min-height:500px">
							<textarea id="textarea" name="file_content" rows="30"></textarea>
							<div id="editor-css-content"></div>
						</div>
						<!--<label>Ubicacion del archivo
							<input type="text" id="file_name" name="file_name" readonly />
						</label>-->
						<button class="button btn-primary" type="submit">Guardar cambios</button>
					</form>
					<div id="file-result"></div>
				</div>
			</div>
		</div>
	</section>
</div>
<script src="https://ajaxorg.github.io/ace-builds/src/ace.js" charset="utf-8"></script>
<script src="<?= G_SERVER ?>rb-admin/core/editfile/funcs.js"></script>
