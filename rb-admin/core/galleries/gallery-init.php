<?php if (!in_array("gal", $array_help_close)): ?>
<div class="help" data-name="gal">
        <h4>Información</h4>
  <p>Las <strong>Galerías</strong> permiten agrupar u organizar solo imágenes. Se puede asociar con alguna Publicacion ó Pagina.</p>
</div>
<?php endif ?>
<div id="sidebar-left">
        <ul class="buttons-edition">
  <li><a class="btn-primary" href="../rb-admin/index.php?pag=gal&amp;opc=nvo"><img src="img/add-white-16.png" alt="Editar" /> Nuevo</a></li>
  <li><a class="btn-primary" rel="gal" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
  <li><a class="btn-primary" rel="gal" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
        </ul>
</div>
<div class="content">
      <!--<div id="content-list">-->
      <div class="wrap-content-list">
        <section class="seccion">
            <div id="resultado"> <!-- ajax asyncron here -->
            <table id="t_articulos" class="tables" border="0" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                      <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                      <th width="250px;"><h3>Nombre</h3></th>
                      <th><h3>Descripción</h3></th>
                        <th width="250px;"><h3>Fecha</h3></th>
                        <th width="30px;"><h3>Imagenes</h3></th>
                    </tr>
                </thead>
                <tbody id="itemstable">
                <?php include('gallery-list.php') ?>
                </tbody>
            </table>
            </div>
            </section>
        </div>
</div>
