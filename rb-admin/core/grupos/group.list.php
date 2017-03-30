<?php
require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
global $objUsuario;// = new Usuarios;
$regMostrar = $_COOKIE['user_show_items'];

$colOrder = "id"; // column name table
$Ord = "ASC"; // A-Z
		
if(isset($_GET['page']) && ($_GET['page']>0)){
	$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
}else{
	$RegistrosAEmpezar=0;
}
		
$result = $objUsuario->Consultar("SELECT * FROM usuarios_grupos ORDER BY $colOrder $Ord LIMIT $RegistrosAEmpezar, $regMostrar");
while ($row = mysql_fetch_array($result)):
?>
	<tr>
		<td><input id="nivel-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
		<td><?= $row['nombre'] ?>
			<div class="options">
				<span><a title="Editar" href="?pag=gru&amp;opc=edt&amp;id=<?= $row['id']?>">Editar</a></span>
				<span><a style="color:red" title="Eliminar" href="../rb-admin/core/grupos/group.delete.php?id=<?= $row['id']?>">Eliminar</a></span></td>
			</div>
		</td>
	</tr>
<?php
endwhile;
?>