<!-- EDITOR AND CONFIGURATION: SLIDE -->
<div id="editor-image" class="editor-window">
	<!-- ED = Editor Box -->
	<div class="editor-header">
		<strong>Configuración de la imagen</strong>
	</div>
	<div class="editor-body form">
		<div class="cols-container">
			<label>
				<span>Clase CSS</span>
				<input type="text" name="image_class" id="image_class" />
			</label>
		</div>
		<div class="tabs-container">
			<div class="tabs-buttons">
	      <input id="tab1" type="radio" name="tabs" checked>
	      <label for="tab1">Seleccionar archivo</label>

	      <input id="tab2" type="radio" name="tabs">
	      <label for="tab2">Subir archivo</label>

	      <input id="tab3" type="radio" name="tabs">
	      <label for="tab3">Información económica</label>
	    </div>
			<div class="tabs-sections">
        <!-- seleccionar archivos -->
        <section id="tabcontent1">
					<div class="explorer-body" style="max-height:500px">
						<?php $q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files ORDER BY id DESC") ?>
						<ul class="gallery">
							<?php while($file = $q->fetch_assoc()){ ?>
								<li>
									<a class="explorer-file" title="ID: <?= $file['id'] ?>" datafld="<?= $file['src'] ?>" datasrc="<?= $file['id'] ?>" href="#">
										<img class="thumb" width="100" src="<?= G_SERVER ?>rb-media/gallery/tn/<?= $file['src'] ?>">
										<span><?= $file['title'] ?></span>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</section>
				<!-- subir archivos -->
				<section id="tabcontent2" class="tab_padding">
					<div>Subir archivos</div>
				</section>
				<!-- url -->
				<section id="tabcontent3" class="tab_padding">
					<h4>Insertar URL de la image</h4>
					<label>
						<input type="text" name="image_url" placeholder="Pega o escribe la URL" />
						<button class="button btn-primary button-sm">Aceptar</button>
					</label>
				</section>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="slide_id" value="" />
		<button class="button" id="image_form-btn-cancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
	// Mostrar la ventana de configuracion con los datos
	$("#boxes").on("click", ".showEditImage", function (event) {
    $(".bg-opacity").show();
    $("#editor-image").show();
    event.preventDefault();
  });

	// Aceptando cambios
	$('#image_form-btn-accept').click(function() {
		$('.bg-opacity, #editor-image').hide();
	});

	// Cancelando cambios
	$('#image_form-btn-cancel').click(function() {
		$('.bg-opacity, #editor-image').hide();
	});
});
</script>
