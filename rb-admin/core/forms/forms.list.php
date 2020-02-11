<?php
$colOrder = "name"; // column name table
$Ord = "ASC"; // A-Z

$result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."forms ORDER BY $colOrder $Ord");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="forms-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['name'] ?></td>
		<td><?= $row['validations'] ?></td>
		<td><code>[FORM id="<?= $row['id'] ?>"]</code></td>
		<td class="row-actions">
			<a class="edit" title="Editar" href="?pag=forms&opc=edt&id=<?= $row['id']?>"><i class="fa fa-edit"></i></a>
			<a title="Eliminar" class="del del-item" data-id="<?= $row['id'] ?>" href="#"><i class="fa fa-times"></i></a>
		</td>
	</tr>
<?php
endwhile;
?>
