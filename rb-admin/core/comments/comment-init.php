<?php
require_once(ABSPATH."rb-script/class/rb-database.class.php");
?>
<?php if (!in_array("com", $array_help_close)): ?>
<div class="help" data-name="com">
  <h4>Información</h4>
    <p>
            Aquí se listan los <strong>Comentarios</strong> de los usuarios, visitantes en el sitio web. Puedes filtrar por la publicación, para ver sus comentarios.</p>
          <p>
            * Agregar y Ver los comentarios, dependerá de la plantilla instalada en el sistema.</p>
</div>
<?php endif ?>
<div id="sidebar-left">
        <ul class="buttons-edition">
    <?php
    // si variable art esta definida entonces
    if(isset($_GET['art'])) {
      $q = $objDataBase->Ejecutar("SELECT titulo FROM articulos WHERE id=".$_GET['art']);
      $r = $q->fetch_assoc();
      ?>
      <li><a href="<?= G_SERVER ?>/rb-admin/?pag=com&amp;art=<?php echo $_GET['art'] ?>">Comentarios en <em><?php echo $r['titulo'] ?></em></a></li>
    <?php } ?>

    <li><a class="btn-primary" rel="com" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
    <li><a class="btn-primary" rel="com" href="#" id="delete"><img src="img/del-white-16.png" alt="Eliminar" /> Eliminar</a></li>
        </ul>
</div>

<div class="wrap-content-list">
      <section class="seccion">
        <div id="content-list">
              <div id="resultado">
              <table id="t_comentarios" class="tables" border="0" cellpadding="0" cellspacing="0">
              <thead>
                  <tr>
                    <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                      <th style="width:10%"><h3>Autor</h3></th>
                      <th><h3>Comentario</h3></th>
                      <th style="width:30%"><h3>Publicación comentada</h3></th>
                  </tr>
              </thead>
              <tbody id="itemstable">
              <?php
                  include('comment-list.php');
              ?>
              </tbody>
              </table>
              </div>
    </div>
    <div id="pagination">
    <?php if(!isset($_GET['art'])) include('comment-paginate.php') ?>
    </div>
  </section>
</div>
