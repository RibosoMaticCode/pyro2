<?php
$colOrder = "nombre"; // column name table
$Ord = "ASC"; // A-Z

$result = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles ORDER BY $colOrder $Ord");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="nivel-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['nombre'] ?>
			<div class="options">
				<span><a title="Editar" href="?pag=nivel&amp;opc=edt&amp;id=<?= $row['id']?>">Editar</a></span>
				<span><a style="color:red" title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>" href="#">Eliminar</a></span></td>
			</div>
		</td>
		<td><?= $row['nivel_enlace'] ?></td>
		<td><?= $row['subnivel_enlace'] ?></td>
		<td><?= $row['descripcion'] ?></td>
	</tr>
<?php
endwhile;
?>
