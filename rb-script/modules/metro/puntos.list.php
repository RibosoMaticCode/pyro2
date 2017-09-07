<?php
require_once '../global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$r = $objDataBase->Consultar("SELECT * FROM metro_puntos ORDER BY nombre ASC LIMIT 10");

while ($punto = mysql_fetch_array($r)):
?>
	<tr id="f_<?= $punto['id']?>">
		<td><?= $punto['nombre'] ?>
			<div class="options">
				<span><a title="Editar" href="module.php?pag=predi_ptos&amp;opc=edt&amp;id=<?= $punto['id']?>">Editar</a></span>
				<span><a style="color:red" id="<?= $punto['id']?>" class="delete-link" title="Eliminar" href="#">Eliminar</a></span></td>
			</div>
		</td>
		<td><?= $punto['descripcion'] ?></td>
		<td>
			<a href="<?= G_SERVER ?>/rb-admin/module.php?pag=predi_tur&pto_id=<?= $punto['id'] ?>">Crear/Editar Turnos</a>
		</td>
		<td>
			<a href="<?= G_SERVER ?>/rb-admin/module.php?pag=predi_hor&id=<?= $punto['id'] ?>">Ver / Asignar Horarios</a>
		</td>
	</tr>
<?php
endwhile;
?>
