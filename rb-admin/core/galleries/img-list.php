<?php
//require_once(ABSPATH."rb-script/class/rb-galerias.class.php");
if ( defined('G_ALBUMID')) echo G_ALBUMID;
if ( defined('G_ALBUMID')) $album_id = $AlbumID;
else $album_id = $_GET['album_id'];

$result = $objDataBase->Ejecutar("SELECT p.*, a.nombre FROM photo p, albums a WHERE p.album_id = a.id AND album_id=".$album_id." ORDER BY orden");
while ($row = $result->fetch_assoc()){
?>
  <li class="grid-1" data-id="<?= $row['id'] ?>">
    <div class="cover-img">
  <?php
    if(rb_file_type($row['type']) == "image"){
      echo "<a class=\"fancybox\" rel=\"group\" href=\"../rb-media/gallery/".utf8_encode($row['src'])."\"> <img src=\"../rb-media/gallery/tn/".utf8_encode($row['tn_src'])."\" /></a>";
    }else {
      if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
      if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
      if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
    }
    echo '<input class="checkbox" id="art-'.$row['id'].'" type="checkbox" value="'.$row['id'].'" name="items" />';
    ?>
    <span class="filename"><?= utf8_encode($row['src']) ?></span>
    <?php
    echo '<span class="edit"><a href="../rb-admin/index.php?pag=img&amp;opc=edt&amp;id='.$row['id'].'&amp;album_id='.$row['album_id'].'">
      <img src="img/edit-black-16.png" alt="icon" />
    </a></span>';
    echo '<span class="delete"><a href="#" style="color:red" title="Eliminar" onclick="Delete('.$row['id'].',\'img\',0,'.$row['album_id'].')">
      <img src="img/del-black-16.png" alt="icon" />
    </a></span>';
  ?>
    </div>
  </li>
<?php
}
?>
