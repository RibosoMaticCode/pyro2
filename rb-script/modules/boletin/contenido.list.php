<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

while ($row = $q->fetch_assoc()):
  ?>
	<tr>
		<td><?= $row['id'] ?></td>
		<td><?= rb_sqldate_to($row['fecha_creacion']) ?></td>
		<td><?= $row['titulo'] ?></td>
		<td><?= $row['categoria_id'] ?></td>
		<td><?= $row['lecturas'] ?></td>
		<td>
			<a href="<?= G_SERVER ?>rb-admin/module.php?pag=boletin_contenidos&id=<?= $row['id'] ?>">Editar</a>
			<a class="del" data-item="<?= $row['id'] ?>" href="#">Eliminar</a>
		</td>
	</tr>
  <?php
endwhile;
?>
