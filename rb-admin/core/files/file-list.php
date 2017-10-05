<?php
if(G_USERTYPE == "admin"):
  $result = $objDataBase->Ejecutar("SELECT * FROM photo ORDER BY id DESC");
else:
  $result = $objDataBase->Ejecutar("SELECT * FROM photo WHERE usuario_id = ".G_USERID." ORDER BY id DESC");
endif;
while ($row = $result->fetch_assoc()):
?>
  <li class="grid-1">
    <div class="cover-img">
    <?php
      if(rb_file_type($row['type']) == "image"):
        echo "<a class=\"fancybox\" rel=\"group\" href=\"../rb-media/gallery/".utf8_encode($row['src'])."\"> <img src=\"../rb-media/gallery/tn/".utf8_encode($row['tn_src'])."\" /></a>";
      else:
        if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
        if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
        if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
      endif;
    ?>
      <input class="checkbox" id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
      <span class="filename">
        <?= utf8_encode($row['src']) ?>
      </span>
      <span class="edit"><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=file_edit&amp;opc=edt&amp;id=<?= $row['id'] ?>">
        <img src="img/edit-black-16.png" alt="icon" />
      </a></span>
      <span class="delete"><a href="#" style="color:red" class="del-item" data-id="<?= $row['id'] ?>">
        <img src="img/del-black-16.png" alt="icon" />
      </a></span>
    </div>
  </li>
<?php
endwhile;
?>
