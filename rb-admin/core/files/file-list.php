<?php
if(G_USERTYPE == "admin"):
  $result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files ORDER BY id DESC");
else:
  $result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE usuario_id = ".G_USERID." ORDER BY id DESC");
endif;
while ($row = $result->fetch_assoc()):
?>
  <li class="grid-1">
    <label>
      <?php
        switch( rb_file_type( $row['type'] ) ){ // Mostrar un icono de algunos archivos permitidos en el sistema
          case 'image':
            $bg_image = G_SERVER.'rb-media/gallery/tn/'.$row['src'];
          break;
          case 'pdf':
            $bg_image = G_SERVER.'rb-admin/img/pdf.png';
          
          break;
          case 'word':
            $bg_image = G_SERVER.'rb-admin/img/doc.png';
          break;
          case 'excel':
            $bg_image = G_SERVER.'rb-admin/img/xls.png';
          break;
          default:
            $bg_image = G_SERVER.'rb-admin/img/document.png';
        }
        if($row['type'] == ""):
          $bg_image = G_SERVER.'rb-admin/img/unknown.png';
        endif;
      ?>
      <div class="cover-img" style="background-image:url('<?= $bg_image ?>')" title="<?= $row['src'] ?>">
        <input class="checkbox" id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
        <span class="filename truncate">
          <a target="_blank" class="fancybox" rel="group" href="<?= G_SERVER ?>rb-media/gallery/<?= utf8_encode($row['src']) ?>"><?= utf8_encode($row['src']) ?></a>
        </span>
        <?php
        if(isset($_GET['compress'])): // opcion oculta al usuario
        ?>
        <span class="edit">
          <a title="Compresion" href="<?= G_SERVER ?>rb-admin/core/files/compress.image.php?image=<?= utf8_encode($row['src']) ?>">
            <i class="fa fa-compress"></i>
          </a>
        </span>
        <?php
        endif;
        ?>
        <span class="delete">
          <a title="Eliminar" href="#" style="color:red" class="del-item" data-id="<?= $row['id'] ?>">
            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </a>
        </span>
      </div>
    </label>
  </li>
<?php
endwhile;
?>
