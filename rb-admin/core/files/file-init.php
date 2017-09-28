<?php if (!in_array("files", $array_help_close)): ?>
<div class="help" data-name="files">
  <h4>Información</h4>
  <p>Puedes subir tus archivos necesarios para asociarlos con los contenidos que generes en el sitio.</p>
  <p>Para <strong>imágenes de productos</strong>, recomendamos una dimensión mínima de <strong>400x400</strong> píxeles.</p>
</div>
<?php endif ?>
<div id="sidebar-left">
        <ul class="buttons-edition">
        <li><a class="btn-primary" href="../rb-admin/?pag=files&amp;opc=nvo"><img src="img/add-white-16.png" alt="Cargar" /> Cargar Archivo</a></li>
  <li><a class="btn-primary" rel="file_edit" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
  <li><a class="btn-primary" rel="files" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
        </ul>
</div>
<div class="content">
      <div id="content-list">
            <div id="resultado"> <!-- ajax asyncron here -->
                <ul id="grid" class="wrap-grid">
                <?php include('file-list.php') ?>
                </ul>
            </div>
        </div>
</div>
