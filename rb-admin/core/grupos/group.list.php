<?php
$colOrder = "id"; // column name table
$Ord = "ASC"; // A-Z
global $objDataBase;
$result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_groups ORDER BY $colOrder $Ord");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="nivel-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td>
			<?= $row['nombre'] ?>
		</td>
		<td class="row-actions">
			<a title="Editar" class="edit" href="?pag=gru&opc=edt&id=<?= $row['id']?>"><i class="fa fa-edit"></i></a>
			<a href="#" title="Eliminar" class="del" data-id="<?= $row['id'] ?>" ><i class="fa fa-times"></i></a>
		</td>
	</tr>
<?php
endwhile;
?>
