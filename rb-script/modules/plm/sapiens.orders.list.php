<?php
while ($row = $q->fetch_assoc()):
  ?>
	<tr>
		<td><?= $row['num_order'] ?></td>
		<td><?= rb_sqldate_to($row['date']) ?></td>
		<td><?= $row['names'] ?></td>
		<td><?= $row['email'] ?></td>
		<td><?= $row['phone'] ?></td>
		<td><?= $row['address'] ?></td>
		<td class="sapiens_actions">
			<a class="fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>plm/sapiens.orders.form.php?id=<?= $row['id'] ?>">Ver / Editar</a>
			<a class="del" data-item="<?= $row['id'] ?>" href="#">Eliminar</a>
		</td>
	</tr>
  <?php
endwhile;
?>
