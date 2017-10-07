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
        <a title="Elementos" href='../rb-admin/index.php?pag=menu&amp;id=<?= $row['id']?>'>Añadir / Editar elementos</a>
      </span>
      <span>
        <a title="Editar" href='../rb-admin/index.php?pag=menus&amp;opc=edt&amp;id=<?= $row['id']?>'>Cambiar Nombre</a>
      </span>
      <span>
        <a style="color:red" href="#" title="Eliminar" class="del-item" data-id="<?= $row['id']?>">Eliminar</a>
      </span>
    </div>
  </td>
</tr>
<?php
endwhile;
?>
