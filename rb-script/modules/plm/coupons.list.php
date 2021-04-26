<?php
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
    <td><?= $row['date_register'] ?></td>
    <td><?= $row['code'] ?></td>
		<td><?= $row['description'] ?></td>
    <td><?php if($row['type']==0) print "Fijo"; elseif($row['type']==1) print "Porcentual" ?></td>
    <td><?= $row['amount'] ?></td>
    <td><?= rb_sqldate_to($row['date_expired'], 'd-m-Y') ?></td>
    <td><?= $row['expensive_min'] ?></td>
    <td><?= $row['expensive_max'] ?></td>
    <td><?= $row['limit_by_user'] ?></td>
    <td><?php if($row['status']==0) print "Inactivo"; elseif($row['status']==1) print "Activo" ?></td>
		<td class="row-actions">
      <a title="Editar" class="edit" data-item="<?= $row['id'] ?>" href="<?= G_SERVER ?>/rb-admin/module.php?pag=plm_coupons&product_id=<?= $row['id'] ?>">
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
