<?php
require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
global $objUsuario;
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objUsuario->Consultar("SELECT * FROM usuarios_grupos WHERE id=$id");	
	$row=mysql_fetch_array($q);
	$mode = "update";
}else{
	$mode = "new";
}
?>
<form id="nivel-form" method="post" action="../rb-admin/core/grupos/group.save.php">
	<div id="toolbar">
       	<div id="toolbar-buttons">
			<span class="post-submit">
				<input class="submit" name="guardar" type="submit" value="Guardar" />
				<a href="?pag=gru"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar/Volver" /></a>
			</span>
		</div>
	</div>
	<div>
		<div class="content-edit">
			<section class="seccion">
				<div class="seccion-body">
					<label>Nombre Grupo:
						<input name="nombre" type="text" value="<?php if(isset($row)) echo $row['nombre'] ?>" required />
					</label>
				</div>
			</section>
		</div>
		<div id="sidebar"></div>
	</div>
	<input name="section" value="nivel" type="hidden" />
	<input name="mode" value="<?php echo $mode ?>" type="hidden" />
	<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
</form>