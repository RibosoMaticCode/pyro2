<?php
$objDataBase = new DataBase;

function categorias_del_articulo($articulo_id){
  global $objDataBase;
  return $objDataBase->Ejecutar("SELECT c.* FROM blog_categories c, blog_posts_categories a WHERE a.categoria_id=c.id AND a.articulo_id=".$articulo_id);
}

if(G_USERTYPE == "admin"):
  $consulta = $objDataBase->Ejecutar("SELECT a.portada, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.lecturas, a.comentarios, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres FROM blog_posts a, ".G_PREFIX."users u WHERE a.autor_id = u.id ORDER BY id DESC");
else:
  $consulta = $objDataBase->Ejecutar("SELECT a.portada, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.lecturas, a.comentarios, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres FROM blog_posts a, ".G_PREFIX."users u WHERE a.autor_id = u.id AND a.autor_id = ".G_USERID." ORDER BY id DESC");
endif;
$i=1;
// bucle para llenar los datos segun pagina
while ($row = $consulta->fetch_assoc()):
?>
  <tr>
    <td><input id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" /></td>
    <td>
      <?= $row['titulo'] ?>
    </td>
    <td class="col_autor"><?= $row['nombres'] ?></td>
    <td class="col_categoria">
      <?php
      $coma = "";
      $result = categorias_del_articulo($row['id']); // Actualizar funcion
      while($r = $result->fetch_assoc()):
        echo $coma.$r['nombre'];$coma=", ";
      endwhile;
      ?>
    </td>
    <td class="col_vistas"><?= $row['lecturas'] ?></td>
    <td class="col_vistas"><?php if($row['activo']=="A") echo "Publicado"; else echo "Borrador"; ?></td>
    <td class="col_fecha"><?= rb_sqldate_to($row['fecha_creacion'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['fecha_creacion'], 'm'))?>, <?= rb_sqldate_to($row['fecha_creacion'], 'Y')?></td> <!-- actualizar funcion -->
    <td class="row-actions">
      <a title="Duplicar" class="edit" href="<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.duplicate.php?id=<?= $row['id'] ?>">
        <i class="fa fa-clone"></i>
      </a>
      <a title="Previsualizar" class="edit" href="<?= G_SERVER ?>?art=<?= $row['id'] ?>" target="_blank">
        <i class="fa fa-external-link-alt"></i>
      </a>
      <a title="Editar" class="edit" data-item="<?= $row['id'] ?>" href="<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_pubs&pub_id=<?= $row['id'] ?>">
        <i class="fa fa-edit"></i>
      </a>
      <a title="Eliminar" class="del del-item" data-id="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>
    </td>
  </tr>
<?php
$i++;
endwhile;
