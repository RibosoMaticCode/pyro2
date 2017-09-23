<?php if (!in_array("pub", $array_help_close)): ?>
<div class="help" data-name="pub">
        <h4>Información</h4>
        <p>Las <strong>Publicaciones</strong> permiten que el contenido aparezca en orden cronológico inverso en la página principal. Debido a su orden cronológico inverso, las Publicaciones se mostrarán de forma oportuna. Las antiguas serán archivadas conforme al mes y año en que fueron publicadas.</p>
        <p>Para una mejor gestión y administración del contenido, tienes la opción de organizarlas ​​en "categorías".</p>
</div>
<?php endif ?>
<div id="sidebar-left">
      <ul class="buttons-edition">
  <li><a class="btn-primary" href="../rb-admin/?pag=art&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
  <li><a class="btn-primary" rel="art" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
  <li><a class="btn-primary" rel="art" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
        </ul>

</div>

<div class="wrap-content-list">
<section class="seccion">
  <?php
  if(isset($_GET['term'])){
    echo '<div id="message1">';
    echo '<p>Buscando: <strong>'.$_GET['term'].'</strong></p>';
    echo '</div>';
  }
  ?>
      <div id="content-list">
            <div id="resultado"> <!-- ajax asyncron here -->
            <table id="t_articulos" class="tables" border="0" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                      <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                      <th><h3>T&iacute;tulo</h3></th>
                      <th width="90px;"><h3>Destacado</h3></th>
                        <th class="col_autor" width="80px;"><center><h3>Autor</h3></center></th>
                        <th class="col_categoria" width="120px;"><h3>Categor&iacute;as</h3></th>
                        <th class="col_vistas" width="30px;"><h3>Vistas</h3></th>
                        <th class="col_fecha" width="80px;"><h3>Fecha</h3></th>
                    </tr>
                </thead>
                <tbody id="itemstable">
                <?php include('pub-list.php') ?>
                </tbody>
            </table>
            </div>
        </div>
  <div id="pagination">
  <?php include('pub-paginate.php') ?>
  </div>
</div>
</section>
