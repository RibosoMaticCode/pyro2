<?php
if (!in_array("usu", $array_help_close)): ?>
<div class="help" data-name="usu">
  <h4>Información</h4>
  <p>Esta sección permite gestionar <strong>Usuarios</strong>. Activar y darle los permisos necesarios para acceso al sistema.</p>
</div>
<?php endif ?>
<div id="sidebar-left">
  <ul class="buttons-edition">
    <li><a class="btn-primary" href="../rb-admin/?pag=usu&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
    <li><a class="btn-primary" rel="usu" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
    <li><a class="btn-primary" rel="usu" href="#" id="delete"><img src="img/del-white-16.png" alt="Eliminar" /> Eliminar</a></li>
  </ul>
</div>
<div class="wrap-content-list">
  <section class="seccion">
    <div id="content-list">
      <div id="resultado">
        <table id="t_usuarios" class="tables" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
              <th><h3>Usuario</h3></th>
              <th><h3>Nombre Completo</h3></th>
              <th><h3>Correo</h3></th>
              <th><h3>Nivel Acceso</h3></th>
              <th><h3>Activo</h3></th>
            </tr>
          </thead>
          <tbody id="itemstable">
          <?php include('user-list.php') ?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="pagination">
    <?php include('user-paginate.php') ?>
    </div>
  </section>
</div>
