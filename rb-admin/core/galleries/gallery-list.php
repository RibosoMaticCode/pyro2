<?php
if(G_USERTYPE == "admin"):
  $q = $objDataBase->Ejecutar("SELECT a . * , (
          SELECT COUNT( id )
          FROM photo
          WHERE album_id = a.id
          ) AS nrophotos
          FROM  `albums` a");
else:
  $q = $objDataBase->Ejecutar("SELECT a . * , (
          SELECT COUNT( id )
          FROM photo
          WHERE album_id = a.id
          ) AS nrophotos
          FROM  `albums` a WHERE usuario_id =".G_USERID);
endif;
while ($row = $q->fetch_assoc()):
  $photo = rb_get_photo_details_from_id($row['photo_id']);
?>
<tr>
  <td><input id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" /></td>
  <td><img style="max-width:70px" src="<?= $photo['file_url'] ?>" alt="Imagen portada" /></td>
  <td>
    <h3><?= $row['nombre']?></h3>
    <div class="options">
      <span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=img&amp;album_id=<?= $row['id']?>">Añadir / Ver fotos</a></span>
      <span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=gal&amp;opc=edt&id=<?= $row['id']?>">Editar</a></span>
      <span><a href='#' style="color:red" class="del-item" data-id="<?= $row['id']?>">Eliminar</a></span>
    </div>
  </td>
  <td><?= $row['galeria_grupo']?></td>
  <td><?= $row['fecha']?></td>
  <td><?= $row['nrophotos']?></td>
</tr>
<?php
endwhile;
?>
