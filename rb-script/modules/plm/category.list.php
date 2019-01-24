<?php
while ($row = $qlist->fetch_assoc()):
  $photo = rb_get_photo_details_from_id($row['foto_id']);
  ?>
	<tr>
    <td><img style="max-width:50px" src="<?= $photo['thumb_url'] ?>" alt="imagen" /></td>
    <?php
    foreach ($columns_title_coltable as $key => $value) {
      ?>
      <td><?= $row[$value] ?></td>
      <?php
    }
    ?>
		<td class="row-actions">
      <a title="Editar" class="edit fancyboxForm fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= $newedit_path ?>?id=<?= $row['id'] ?>">
        <i class="fa fa-edit"></i>
      </a>
      <a title="Eliminar" class="del" data-item="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>
    </td>
	</tr>
  <?php
endwhile;
?>
