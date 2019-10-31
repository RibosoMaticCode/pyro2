<?php
// determinando consulta con nro de paginas y registro a empezar
/*$regMostrar = $_COOKIE['page_show_items'];
if(isset($_GET['page']) && ($_GET['page']>0)){
    $RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
}else{
    $RegistrosAEmpezar = 0;
}*/

if(isset($_GET['term'])){
  // busqueda inicial sin paginado
  //echo "<p>Buscando: <strong>".$_GET['term']."</strong></p>";
  //$consulta = $objDataBase->Search($_GET['term'], true, $RegistrosAEmpezar, $regMostrar);
}else{
  // consulta por defecto
  $consulta = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages ORDER BY id DESC");
}

$i=1;
// bucle para llenar los datos segun pagina
while ($row = $consulta->fetch_assoc()){
  ?>
  <tr>
    <td>
      <input id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
    </td>
    <td>
      <?= $row['titulo'] ?>
    </td>
    <td>
      <?= rb_fragment_letters($row['description'], 40) ?>
    </td>
    <td>
      <?php
      switch($row['type']){
        case 0:
          echo "Normal";
        break;
        case 1:
          echo "Cabecera";
        break;
        case 2:
          echo "Pie de pagina";
        break;
        case 3:
          echo "Barra lateral";
        break;
      }
      ?>
    </td>
    <td><?= rb_sqldate_to($row['fecha_creacion'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['fecha_creacion'], 'm'))?>, <?= rb_sqldate_to($row['fecha_creacion'], 'Y')?></td>
    <td class="row-actions">
      <a title="Duplicar" class="edit" href="<?= G_SERVER ?>rb-admin/content.duplicate.php?id=<?= $row['id'] ?>&sec=pages">
        <i class="fa fa-clone"></i>
      </a>
      <a title="Previsualizar" class="edit" href="<?= G_SERVER ?>?p=<?= $row['id'] ?>" target="_blank">
        <i class="fa fa-external-link-alt"></i>
      </a>
      <a title="Editar" class="edit" data-item="<?= $row['id'] ?>" href="<?= G_SERVER ?>rb-admin/index.php?pag=pages&opc=edt&id=<?= $row['id'] ?>">
        <i class="fa fa-edit"></i>
      </a>
      <a title="Eliminar" class="del del-item" data-id="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>
    </td>
  </tr>
  <?php
  $i++;
}
?>
