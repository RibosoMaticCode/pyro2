<?php
$colOrder = "nombre"; // column name table
$Ord = "ASC"; // A-Z

$result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_levels ORDER BY $colOrder $Ord");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="nivel-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['nombre'] ?></td>
		<td><?= $row['nivel_enlace'] ?></td>
		<td><?= $row['subnivel_enlace'] ?></td>
		<td><?= $row['descripcion'] ?></td>
		<td class="row-actions">
			<a title="Editar" class="edit" href="<?= G_SERVER ?>rb-admin/?pag=nivel&opc=edt&id=<?= $row['id']?>"><i class="fa fa-edit"></i></a>
			<a title="Eliminar" class="del del-item" data-id="<?= $row['id'] ?>" href="#"><i class="fa fa-times"></i></a>
		</td>
	</tr>
<?php
endwhile;
?>
