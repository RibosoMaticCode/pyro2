<?php
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
		<td><?= $row['nombres'] ?></td>
        <td><?= $row['apellidos'] ?></td>
		<td><?= $row['telefono'] ?></td>
        <td><?= $row['correo'] ?></td>
		<td class="row-actions">
            <a title="Editar" class="edit fancyboxForm fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= G_DIR_MODULES_URL ?>crm/newedit.customer.php?id=<?= $row['id'] ?>">
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
