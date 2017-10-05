<?php
$regMostrar = $_COOKIE['user_show_items'];

$colOrder = "id"; // column name table
$Ord = "ASC"; // A-Z

if(isset($_GET['page']) && ($_GET['page']>0)){
	$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
}else{
	$RegistrosAEmpezar=0;
}

$result = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles ORDER BY $colOrder $Ord LIMIT $RegistrosAEmpezar, $regMostrar");
while ($row = $result->fetch_assoc()):
?>
	<tr>
		<td><input id="nivel-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['nombre'] ?>
			<div class="options">
				<span><a title="Editar" href="?pag=nivel&amp;opc=edt&amp;id=<?= $row['id']?>">Editar</a></span>
				<span><a style="color:red" title="Eliminar" href="<?= G_SERVER ?>/rb-admin/core/niveles/niveles.delete.php?id=<?= $row['id']?>">Eliminar</a></span></td>
			</div>
		</td>
		<td><?= $row['nivel_enlace'] ?></td>
		<td><?= $row['permisos'] ?></td>
	</tr>
<?php
endwhile;
?>
