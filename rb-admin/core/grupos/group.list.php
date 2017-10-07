<?php
$colOrder = "id"; // column name table
$Ord = "ASC"; // A-Z
global $objDataBase;
$result = $objDataBase->Ejecutar("SELECT * FROM usuarios_grupos ORDER BY $colOrder $Ord");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="nivel-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['nombre'] ?>
			<div class="options">
				<span><a title="Editar" href="?pag=gru&amp;opc=edt&amp;id=<?= $row['id']?>">Editar</a></span>
				<span><a href="#" style="color:red" title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>" >Eliminar</a></span></td>
			</div>
		</td>
	</tr>
<?php
endwhile;
?>
