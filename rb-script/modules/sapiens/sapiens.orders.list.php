<?php
while ($row = $q->fetch_assoc()):
  ?>
	<tr>
		<td><?= rb_sqldate_to($row['date']) ?></td>
		<td><?= $row['names'] ?></td>
		<td><?= $row['email'] ?></td>
		<td><?= $row['phone'] ?></td>
		<td><?= $row['book_title'] ?></td>
		<td><?= $row['attended'] ?></td>
		<td>
			<a class="fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>sapiens/sapiens.orders.form.php?id=<?= $row['id'] ?>">Editar</a>
			<a class="del" data-item="<?= $row['id'] ?>" href="#">Eliminar</a>
		</td>
	</tr>
  <?php
endwhile;
?>
