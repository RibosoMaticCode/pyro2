<?php
function categorias_del_articulo($articulo_id){
  global $objDataBase;
  return $objDataBase->Ejecutar("SELECT c.* FROM categorias c, articulos_categorias a WHERE a.categoria_id=c.id AND a.articulo_id=$articulo_id");
}

$regMostrar = $_COOKIE['art_show_items'];

if(isset($_GET['page']) && ($_GET['page']>0)):
  $RegistrosAEmpezar = ($_GET['page']-1) * $regMostrar;
else:
  $RegistrosAEmpezar = 0;
endif;

if(G_USERTYPE == "admin"):
  $consulta = $objDataBase->Ejecutar("SELECT a.portada, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.lecturas, a.comentarios, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres FROM articulos a, usuarios u WHERE a.autor_id = u.id ORDER BY id DESC LIMIT $RegistrosAEmpezar, $regMostrar");
else:
  $consulta = $objDataBase->Ejecutar("SELECT a.portada, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.lecturas, a.comentarios, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres FROM articulos a, usuarios u WHERE a.autor_id = u.id AND a.autor_id = ".G_USERID." ORDER BY id DESC LIMIT $RegistrosAEmpezar, $regMostrar");
endif;

$i=1;

// bucle para llenar los datos segun pagina
while ($row = $consulta->fetch_assoc()):
?>
  <tr>
    <td><input id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" /></td>
    <td>
      <h3><?= $row['titulo'] ?></h3>
      <div class="options">
        <span id="boxart_<?= $row['id'] ?>">
          <?php if($row['activo']=="D"): ?>
            <a href="#" title="Activar articulo" onclick="activarArticulo(<?= $row['id'] ?>)">Publicar</a> <!-- actualizar funcion js -->
          <?php else: ?>
            <a href="#" title="Desactivar articulo" onclick="activarArticulo(<?= $row['id'] ?>)">No publicar</a> <!-- actualizar funcion js -->
          <?php endif ?>
        </span>
        <span>
          <a title="Editar" href="../rb-admin/index.php?pag=art&amp;opc=edt&amp;id=<?= $row['id'] ?>">Editar</a>
        </span>
        <span>
          <a href="#" style="color:red" title="Eliminars" onclick="Delete(<?= $row['id'] ?>,'art')">Eliminar</a> <!-- actualizar funcion js -->
        </span>
        <span>
          <a href="content.duplicate.php?id=<?= $row['id'] ?>&sec=art">Duplicar</a>
        </span>
        <span>
          <a href="<?= rb_url_link('art',$row['id']) ?>" target="_blank">Vista Preliminar</a>
        </span>
      </div>
    </td>
    <td class="col_autor"><span style="text-align: center; display: block;"><?php if($row['portada']==1){ ?><img src="img/star-24.png" alt="star" /><?php } ?></span></td>
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
    <td class="col_fecha"><?= rb_sqldate_to($row['fecha_creacion']) ?></td> <!-- actualizar funcion -->
  </tr>
<?php
$i++;
endwhile;
