<?php
require_once 'funcs.php';
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
		<td><?= crm_customer_fullname($row['customer_id']) ?></td>
        <td><?= rb_sqldate_to($row['fecha_visita']) ?></td>
		<td><?= $row['observaciones'] ?></td>
		<td class="row-actions">
            <a title="Editar" class="edit fancyboxForm fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= G_DIR_MODULES_URL ?>crm/newedit.visit.php?id=<?= $row['id'] ?>">
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
