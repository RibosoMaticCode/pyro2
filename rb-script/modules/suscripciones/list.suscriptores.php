<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
include_once ABSPATH.'rb-script/modules/cunajardin/vars.php';

$objDataBase = new DataBase;

$q = $objDataBase->Ejecutar('SELECT * FROM suscriptores ORDER BY fecha DESC LIMIT 20');
while ($row = $q->fetch_assoc()):
  ?>
	<tr>
		<td><?= rb_sqldate_to($row['fecha']) ?></td>
		<td><?= $row['nombres'] ?></td>
		<td><?= $row['correo'] ?></td>
		<td><a class="del" data-item="<?= $row['id'] ?>" href="#">Eliminar</a></td>
	</tr>
  <?php
endwhile;
?>
