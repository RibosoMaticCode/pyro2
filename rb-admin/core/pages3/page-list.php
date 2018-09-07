<?php
// determinando consulta con nro de paginas y registro a empezar
$regMostrar = $_COOKIE['page_show_items'];
// si pagina esta definido y es mayor que 0
if(isset($_GET['page']) && ($_GET['page']>0)){
    $RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
}else{
    $RegistrosAEmpezar = 0;
}

if(isset($_GET['term'])){
  // busqueda inicial sin paginado
  //echo "<p>Buscando: <strong>".$_GET['term']."</strong></p>";
  //$consulta = $objDataBase->Search($_GET['term'], true, $RegistrosAEmpezar, $regMostrar);
}else{
  // consulta por defecto
  $consulta = $objDataBase->Ejecutar("SELECT * FROM paginas ORDER BY id DESC LIMIT $RegistrosAEmpezar, $regMostrar");
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
      <h3><?= $row['titulo'] ?></h3>
      <div class="options">
        <span>
          <a title="Editar" href="<?= G_SERVER ?>/rb-admin/index.php?pag=pages&opc=edt&id=<?= $row['id'] ?>">Editar</a>
        </span>
        <span>
          <a href="#" style="color:red" title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>">Eliminar</a></span>
        <span>
          <a href="content.duplicate.php?id=<?= $row['id'] ?>&sec=pages">Duplicar</a></span>
        <span>
            <a class="fancybox fancybox.iframe" href="<?= G_SERVER ?>/?p=<?= $row['id'] ?>" target="_blank" title="Manten presionado F5 y pulsa el link para abrir en nueva pestaña">Vista previa</a>
        </span>
      </div>
    </td>
    <td>
      <?= $row['description'] ?>
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
    <td><?= rb_sqldate_to($row['fecha_creacion']) ?></td>
  </tr>
  <?php
  $i++;
}
?>
