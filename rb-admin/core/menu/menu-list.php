<?php
$result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."menus");
while ($row = $result->fetch_assoc()):
?>
<tr>
  <td><input id="art-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
  <td>
    <?= $row['nombre']?>
  </td>
  <td>
    <p class="info">Aplicarlo en el codigo: <br /><code>&lt;?php rb_display_menu(<?= $row['id']?>) ?&gt;</code></p>
  </td>
  <td class="row-actions">
    <a title="Añadir elementos" class="edit" href='<?= G_SERVER ?>rb-admin/index.php?pag=menu&amp;id=<?= $row['id']?>'><i class="fas fa-plus"></i></a>
    <a title="Editar" class="edit" href='<?= G_SERVER ?>rb-admin/index.php?pag=menus&amp;opc=edt&amp;id=<?= $row['id']?>'><i class="fa fa-edit"></i></a>
    <a href="#" title="Eliminar" class="del del-item" data-id="<?= $row['id']?>"><i class="fa fa-times"></i></a>
  </td>
</tr>
<?php
endwhile;
?>
