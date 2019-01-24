<?php
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
    <?php
    foreach ($columns_title_coltable as $key => $value) {
      ?>
      <td><?= $row[$value] ?></td>
      <?php
    }
    ?>
    <td><?= estado_habitacion($row['estado']) ?></td>
		<td class="row-actions">
      <a title="Editar" class="edit fancyboxForm fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= $newedit_path ?>?res_id=<?= $row['id'] ?>&date=<?= $fecha ?>">
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
