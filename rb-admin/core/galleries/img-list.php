<?php
if ( defined('G_ALBUMID')) echo G_ALBUMID;
if ( defined('G_ALBUMID')) $album_id = $AlbumID;
else $album_id = $_GET['album_id'];

$result = $objDataBase->Ejecutar("SELECT p.*, a.nombre FROM photo p, albums a WHERE p.album_id = a.id AND album_id=".$album_id." ORDER BY orden");
while ($row = $result->fetch_assoc()){
?>
  <li class="grid-1" data-id="<?= $row['id'] ?>">
    <label>
      <div class="cover-img" style="background-image:url('<?= G_SERVER ?>/rb-media/gallery/tn/<?= $row['src'] ?>')" title="<?= $row['src'] ?>">
        <input class="checkbox" id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
        <span class="filename truncate">
          <a class="fancybox" rel="group" href="../rb-media/gallery/<?= utf8_encode($row['src']) ?>"><?= utf8_encode($row['src']) ?></a>
        </span>
        <span class="edit">
          <a href="<?= G_SERVER ?>/rb-admin/index.php?pag=img&opc=edt&id=<?= $row['id'] ?>&album_id=<?= $row['album_id'] ?>">
            <i class="fa fa-pencil" aria-hidden="true"></i>
          </a>
        </span>
        <span class="delete">
          <a href="#" style="color:red" title="Eliminar" class="del-item" data-album-id="<?= $row['album_id'] ?>" data-id="<?= $row['id'] ?>">
            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </a>
        </span>
      </div>
    </label>
  </li>
<?php
}
?>
