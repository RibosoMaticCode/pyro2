<?php
$result = $objDataBase->Ejecutar("SELECT * FROM menus");
while ($row = $result->fetch_assoc()):
?>
<tr>
  <td><input id="art-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
  <td>
    <h3>
      <?= $row['nombre']?>
    </h3>
    <div class='options'>
      <span>
        <a title="Elementos" href='<?= G_SERVER ?>/rb-admin/index.php?pag=menu&amp;id=<?= $row['id']?>'>Añadir / Editar elementos</a>
      </span>
      <span>
        <a title="Editar" href='<?= G_SERVER ?>/rb-admin/index.php?pag=menus&amp;opc=edt&amp;id=<?= $row['id']?>'>Cambiar Nombre</a>
      </span>
      <span>
        <a style="color:red" href="#" title="Eliminar" class="del-item" data-id="<?= $row['id']?>">Eliminar</a>
      </span>
    </div>
  </td>
  <td>
    <p class="info">Aplicarlo en el codigo: <br /><code>&lt;?php rb_display_menu(<?= $row['id']?>) ?&gt;</code></p>
  </td>
</tr>
<?php
endwhile;
?>
