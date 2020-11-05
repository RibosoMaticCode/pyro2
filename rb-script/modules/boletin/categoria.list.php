<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';

while ($row = $q->fetch_assoc()):
  ?>
	<tr>
		<td><?= $row['id'] ?></td>
		<td><?= $row['titulo'] ?></td>
		<td><?= $row['icon_id'] ?></td>
		<td><?= $row['area_id'] ?></td>
		<td>
			<a class="fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>boletin/categoria.newedit.php?id=<?= $row['id'] ?>">Editar</a>
			<a class="del" data-item="<?= $row['id'] ?>" href="#">Eliminar</a>
		</td>
	</tr>
  <?php
endwhile;
?>
