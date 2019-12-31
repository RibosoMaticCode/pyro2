<?php
if(G_USERTYPE == "admin"):
  $q = $objDataBase->Ejecutar("SELECT a . * , (
          SELECT COUNT( id )
          FROM ".G_PREFIX."files
          WHERE album_id = a.id
          ) AS nrophotos
          FROM  ".G_PREFIX."galleries a ORDER BY fecha DESC");
else:
  $q = $objDataBase->Ejecutar("SELECT a . * , (
          SELECT COUNT( id )
          FROM ".G_PREFIX."files
          WHERE album_id = a.id
          ) AS nrophotos
          FROM  ".G_PREFIX."galleries a WHERE usuario_id =".G_USERID. " ORDER BY fecha DESC");
endif;
while ($row = $q->fetch_assoc()):
  $photo = rb_get_photo_details_from_id($row['photo_id']);
  ?>
  <tr>
    <td><input id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" /></td>
    <td>
      <?php
      if($photo['file_name']=="") $photo_url = G_SERVER."rb-script/images/gallery-default.jpg";
      else $photo_url = $photo['file_url'];
      ?>
      <img style="max-width:70px;margin-right: 10px;vertical-align: middle;" src="<?= $photo_url ?>" alt="Imagen portada" />
      <a title="Ver contenido" href="<?= G_SERVER ?>rb-admin/index.php?pag=gal&album_id=<?= $row['id']?>"><?= $row['nombre']?></a><br />
      <span class="info"><?= $row['nrophotos']?> elementos</span>
    </td>
    <td><?= rb_sqldate_to($row['fecha'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['fecha'], 'm'))?>, <?= rb_sqldate_to($row['fecha'], 'Y')?></td>
    <td><?= $row['galeria_grupo']?></td>
    <td class="row-actions">
        <a title="Editar" class="edit" href="<?= G_SERVER ?>rb-admin/index.php?pag=gal&amp;opc=edt&id=<?= $row['id']?>"><i class="fa fa-edit"></i></a>
        <a title="Añadir imagenes" class="edit" href="<?= G_SERVER ?>rb-admin/index.php?pag=gal&amp;album_id=<?= $row['id']?>"><i class="fas fa-plus"></i></a>
        <a title="Visualizar modo usuario final" target="_blank" class="edit" href="<?= G_SERVER ?>?gallery=<?= $row['id']?>"><i class="fa fa-external-link-alt"></i></a>
        <a title="Eliminar" href='#' class="del del-item" data-id="<?= $row['id']?>"><i class="fa fa-times"></i></a>
    </td>
  </tr>
  <?php
endwhile;
?>
