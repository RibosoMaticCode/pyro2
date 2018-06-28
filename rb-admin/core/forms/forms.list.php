<?php
$colOrder = "name"; // column name table
$Ord = "ASC"; // A-Z

$result = $objDataBase->Ejecutar("SELECT * FROM forms ORDER BY $colOrder $Ord");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="forms-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['name'] ?>
			<div class="options">
				<span><a title="Editar" href="?pag=forms&amp;opc=edt&amp;id=<?= $row['id']?>">Editar</a></span>
				<span><a style="color:red" title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>" href="#">Eliminar</a></span></td>
			</div>
		</td>
		<td><?= $row['validations'] ?></td>
		<td><code>[FORM id="<?= $row['id'] ?>"]</code></td>
	</tr>
<?php
endwhile;
?>
