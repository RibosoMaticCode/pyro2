<?php
$menu_asincrono = true;
?>
<?php if (!in_array("menus", $array_help_close)): ?>
<div class="help" data-name="menus">
  <h4>Información</h4>
  <p>Dependiendo de la plantilla instalada podrás editar los <strong>Menús</strong> y sus elementos.</p>
</div>
<?php endif ?>
<div id="sidebar-left">
        <ul class="buttons-edition">
    <li><a class="btn-primary" href="../rb-admin/?pag=menus&amp;opc=nvo">Menú Nuevo</a></li>
        </ul>
</div>
<div class="wrap-content-list">
      <section class="seccion">
      <div id="content-list">
            <div id="resultado">
            <table id="t_categorias" class="tables" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                <th><h3>Nombre</h3></th>
              </tr>
             </thead>
            <tbody id="itemstable">
                <?php include('menu-list.php') ?>
            </tbody>
            </table>
            </div>
        </div>
        <div id="pagination">
        <?php //include('paginate.php') ?>
        </div>
       </section>
</div>
