<?php if (!in_array("pag", $array_help_close)): ?>
<div class="help" data-name="pag">
<h4>Información</h4>
<p>Las <strong>Páginas</strong> están destinadas a ser estáticas, puedes utilizar una página para publicar una descripción personal, una página con formualrios de contacto, especificar la política de privacidad y avisos legales de tu sitio, etc.</p>
      <p>Las páginas no muestran la hora o fecha en que fueron publicadas.</p>
</div>
<?php endif ?>
  <div id="sidebar-left">
      <ul class="buttons-edition">
      <li><a class="btn-primary" href="../rb-admin/?pag=pages&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
<li><a class="btn-primary" rel="pages" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
<li><a class="btn-primary" rel="pages" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
      </ul>

  </div>

  <div class="wrap-content-list">
  <section class="seccion">
      <div id="content-list">
          <div id="resultado"> <!-- ajax asyncron here -->
          <table id="t_articulos" class="tables" border="0" cellpadding="0" cellspacing="0">
              <thead>
                  <tr>
                    <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                      <th><h3>T&iacute;tulo</h3></th>
                      <th><h3>Tipo</h3></th>
                      <th><h3>Fecha</h3></th>
                  </tr>
              </thead>
              <tbody id="itemstable">
              <?php include('page-list.php') ?>
              </tbody>
          </table>
          </div>
      </div>
      <div id="pagination">
      <?php include('page-paginate.php') ?>
      </div>
  </section>
  </div>
