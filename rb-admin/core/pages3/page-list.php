<?php
//require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
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
    echo "
    <tr>
        <td><input id=\"art-".$row['id']."\" type=\"checkbox\" value=\"".$row['id']."\" name=\"items\" /></td>
        <td>
          <h3>".$row['titulo']."</h3>";

?>
<div class="options">
  <span>
    <?php
    if($row['bloques']==1):
    ?>
    <a title="Editar" href="../rb-admin/index.php?pag=design&amp;page_id=<?= $row['id'] ?>">Editar</a></span>
    <?php
    else:
    ?>
    <a title="Editar" href="../rb-admin/index.php?pag=pages&amp;opc=edt&amp;id=<?= $row['id'] ?>">Editar</a></span>
    <?php
    endif;
    ?>
  <span>
    <a href="#" style="color:red" title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>">Eliminar</a></span>
  <span>
    <a href="content.duplicate.php?id=<?= $row['id'] ?>&sec=pages">Duplicar</a></span>
  <span>
      <a class="fancybox fancybox.iframe" href="<?= G_SERVER ?>/?p=<?= $row['id'] ?>" target="_blank">Vista previa</a>
  </span>
</div>
</td>
<td>
  <span><?php if($row['bloques']==1) echo "Estructural"; else echo "Estándar"; ?></span>
</td>
<?php
      echo "<td>".rb_sqldate_to($row['fecha_creacion'])."</td>";
    $i++;
}
 ?>
