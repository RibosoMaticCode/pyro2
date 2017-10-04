<?php if (!in_array("cat", $array_help_close)): ?>
<div class="help" data-name="cat">
  <h4>Información</h4>
  <p>Una <strong>Categoria</strong> permite agrupar las publicaciones.</p><p>Es importante que por lo menos haya una, pues no se podrá guardar una publicación sino hay una Categoría.</p>
</div>
<?php endif ?>
<div id="sidebar-left">
        <ul class="buttons-edition">
  <li><a class="btn-primary" href="../rb-admin/?pag=cat&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nueva Categoria</a></li>
        </ul>
</div>
<div class="wrap-content-list">
  <section class="seccion">
      <div id="content-list">
            <div id="resultado">
            <table id="t_categorias" class="tables" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th><h3>Nombre</h3></th>
                <th><h3>Descripcion</h3></th>
                <th><h3>Acceso</h3></th>
                <th><h3>Niveles</h3></th>
                <th colspan="2"><h3>Acciones</h3></th>
              </tr>
             </thead>
            <tbody id="itemstable">
                <?php include('category-list.php') ?>
            </tbody>
            </table>
            </div>
        </div>
        </section>
</div>
